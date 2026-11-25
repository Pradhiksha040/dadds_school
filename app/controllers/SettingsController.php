<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Setting;
use App\Models\AuditLog;
use App\Helpers\CryptoHelper;

class SettingsController extends Controller
{
    protected $settingModel;

    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth');
        }
        $this->checkModuleAccess('settings');
        $this->settingModel = new Setting();
    }

    private function getFormattedSettings($group = null)
    {
        $settings = $this->settingModel->getAllByGroup($group);
        $formatted = [];
        foreach ($settings as $s) {
            $formatted[$s->key_name] = $s->key_value;
        }
        return $formatted;
    }

    public function organization()
    {
        return $this->view('admin/settings/organization', [
            'title' => 'Organization Settings',
            'settings' => $this->getFormattedSettings('organization')
        ]);
    }

    public function smtp()
    {
        return $this->view('admin/settings/smtp', [
            'title' => 'SMTP Settings',
            'settings' => $this->getFormattedSettings('smtp')
        ]);
    }

    public function payments()
    {
        return $this->view('admin/settings/payments', [
            'title' => 'Payment Settings',
            'settings' => $this->getFormattedSettings('payments')
        ]);
    }

    public function templates()
    {
        $orgSettings = $this->getFormattedSettings('organization');
        return $this->view('admin/settings/templates', [
            'title' => 'Email Templates',
            'settings' => $this->getFormattedSettings('template'),
            'orgSettings' => $orgSettings
        ]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $activeTab = $_POST['active_tab'] ?? '';
            
            // Capture old settings for audit logging
            $group = 'organization';
            $refPath = $_SERVER['HTTP_REFERER'] ?? '';
            if (strpos($refPath, 'settings/templates') !== false) {
                $group = 'template';
            } elseif (strpos($refPath, 'settings/payments') !== false) {
                $group = 'payments';
            }
            if ($activeTab === 'tab-payments') {
                $group = 'payments';
            }
            
            $oldSettings = $this->getFormattedSettings($group);
            $changedSettings = [];

            // Handle regular text fields and special handling for checkboxes
            if ($activeTab === 'tab-settings') {
                $status = isset($_POST['contact_page_status']) ? 'active' : 'inactive';
                $map = isset($_POST['show_google_map']) ? 'yes' : 'no';
                
                if (isset($oldSettings['contact_page_status']) && $oldSettings['contact_page_status'] !== $status) {
                    $changedSettings['contact_page_status'] = ['old' => $oldSettings['contact_page_status'], 'new' => $status];
                }
                if (isset($oldSettings['show_google_map']) && $oldSettings['show_google_map'] !== $map) {
                    $changedSettings['show_google_map'] = ['old' => $oldSettings['show_google_map'], 'new' => $map];
                }
                
                $this->settingModel->updateByKey('contact_page_status', $status);
                $this->settingModel->updateByKey('show_google_map', $map);
            } elseif ($activeTab === 'tab-payments') {
                $group = 'payments';
                foreach ($_POST as $key => $value) {
                    if (!in_array($key, ['submit', 'active_tab', '_csrf_token', '_csrf_action'])) {
                        if (CryptoHelper::isSensitiveKey($key)) {
                            if (empty($value)) {
                                continue;
                            }
                            $value = CryptoHelper::encrypt($value);
                        }
                        $oldValue = $oldSettings[$key] ?? '';
                        if ($oldValue !== $value) {
                            $changedSettings[$key] = ['old' => $oldValue, 'new' => $value];
                        }
                        $this->settingModel->updateByKey($key, $value, $group);
                    }
                }
            } elseif ($activeTab === 'tab-id-prefix') {
                $group = 'organization';
                foreach ($_POST as $key => $value) {
                    if (!in_array($key, ['submit', 'active_tab', '_csrf_token', '_csrf_action'])) {
                        $oldValue = $oldSettings[$key] ?? '';
                        if ($oldValue !== $value) {
                            $changedSettings[$key] = ['old' => $oldValue, 'new' => $value];
                        }
                        $this->settingModel->updateByKey($key, $value, $group);
                    }
                }
            } elseif ($activeTab === 'tab-social') {
                $socialKeys = ['facebook', 'twitter', 'instagram', 'linkedin', 'youtube'];
                foreach ($socialKeys as $sk) {
                    $showKey = 'show_social_' . $sk;
                    $urlKey = 'social_' . $sk;
                    
                    $showValue = isset($_POST[$showKey]) ? '1' : '0';
                    $oldShowValue = $oldSettings[$showKey] ?? '0';
                    if ($oldShowValue !== $showValue) {
                        $changedSettings[$showKey] = ['old' => $oldShowValue, 'new' => $showValue];
                    }
                    $this->settingModel->updateByKey($showKey, $showValue, 'organization');
                    
                    if (isset($_POST[$urlKey])) {
                        $oldUrlValue = $oldSettings[$urlKey] ?? '';
                        if ($oldUrlValue !== $_POST[$urlKey]) {
                            $changedSettings[$urlKey] = ['old' => $oldUrlValue, 'new' => $_POST[$urlKey]];
                        }
                        $this->settingModel->updateByKey($urlKey, $_POST[$urlKey], 'organization');
                    }
                }
            } else {
                $group = 'organization';
                $refPath = $_SERVER['HTTP_REFERER'] ?? '';
                if (strpos($refPath, 'settings/templates') !== false) {
                    $group = 'template';
                } elseif (strpos($refPath, 'settings/payments') !== false) {
                    $group = 'payments';
                }
                foreach ($_POST as $key => $value) {
                    if (!in_array($key, ['submit', 'active_tab', '_csrf_token', '_csrf_action'])) {
                        if (CryptoHelper::isSensitiveKey($key)) {
                            if (empty($value)) {
                                continue;
                            }
                            $value = CryptoHelper::encrypt($value);
                        }
                        $oldValue = $oldSettings[$key] ?? '';
                        if ($oldValue !== $value) {
                            $changedSettings[$key] = ['old' => $oldValue, 'new' => $value];
                        }
                        $this->settingModel->updateByKey($key, $value, $group);
                    }
                }
            }

            // Handle file uploads
            $uploadDir = UPLOAD_PATH . 'settings/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileFields = [
                'ngo_logo' => 500 * 1024,
                'ngo_logo_dark' => 500 * 1024,
                'ngo_favicon' => 500 * 1024,
                'ngo_signature' => 500 * 1024
            ];
            
            foreach ($fileFields as $field => $maxSize) {
                if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
                    $valid = validate_upload($_FILES[$field], ['jpg', 'jpeg', 'png', 'gif', 'webp'], ['image/jpeg', 'image/png', 'image/gif', 'image/webp'], $maxSize);
                    if ($valid !== true) {
                        $_SESSION['error'] = ucfirst(str_replace('ngo_', '', $field)) . ': ' . $valid;
                        continue;
                    }

                    $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
                    $fileName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
                    $targetPath = $uploadDir . $fileName;
                    if (move_uploaded_file($_FILES[$field]['tmp_name'], $targetPath)) {
                        $oldFileValue = $oldSettings[$field] ?? '';
                        $newFileValue = 'uploads/settings/' . $fileName;
                        if ($oldFileValue !== $newFileValue) {
                            $changedSettings[$field] = ['old' => $oldFileValue, 'new' => $newFileValue];
                        }
                        $this->settingModel->updateByKey($field, $newFileValue, 'organization');
                    }
                }
            }

            // Log settings changes to audit trail
            if (!empty($changedSettings)) {
                $settingsDescription = $group . ' settings';
                if ($activeTab === 'tab-payments') {
                    $settingsDescription = 'payment gateway settings';
                } elseif ($activeTab === 'tab-social') {
                    $settingsDescription = 'social media settings';
                } elseif ($activeTab === 'tab-id-prefix') {
                    $settingsDescription = 'ID prefix settings';
                } elseif ($group === 'template') {
                    $settingsDescription = 'email template settings';
                }
                
                AuditLog::log(
                    'update',
                    'settings',
                    null,
                    $changedSettings,
                    ['group' => $group, 'active_tab' => $activeTab, 'description' => $settingsDescription]
                );
            }

            // Verify save by reading back from the correct group
            $verify = $this->settingModel->getAllByGroup($group);
            $saved = [];
            foreach ($verify as $s) {
                $saved[$s->key_name] = $s->key_value;
            }
            
            $allOk = true;
            foreach ($_POST as $key => $value) {
                if (!in_array($key, ['submit', 'active_tab', '_csrf_token', '_csrf_action'])) {
                    // Skip sensitive keys — they are encrypted in DB so comparison with plaintext always fails
                    if (CryptoHelper::isSensitiveKey($key)) {
                        continue;
                    }
                    if (isset($saved[$key]) && $saved[$key] !== $value) {
                        $allOk = false;
                        error_log("Settings mismatch: {$key} = expected '{$value}', got '{$saved[$key]}'");
                    }
                }
            }

            if ($allOk) {
                $_SESSION['success'] = 'Settings updated successfully';
            } else {
                $_SESSION['error'] = 'Some settings could not be saved. Check error logs.';
            }

            if ($activeTab) {
                $referer = $_SERVER['HTTP_REFERER'] ?? url('admin/dashboard');
                $referer = strtok($referer, '#') . '#' . $activeTab;
                header("Location: " . $referer);
                exit;
            }
        }
        
        $referer = $_SERVER['HTTP_REFERER'] ?? url('admin/dashboard');
        header("Location: " . $referer);
        exit;
    }
}
