<?php require_once 'app/views/admin/layouts/header.php'; ?>
<?php require_once 'app/views/admin/layouts/sidebar.php'; ?>

<div class="page-wrapper">
    <?php require_once 'app/views/admin/layouts/topbar.php'; ?>

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="mb-3">
                        <ol class="breadcrumb" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="<?php echo url('admin/dashboard'); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Settings</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">SMTP Settings</a></li>
                        </ol>
                    </div>
                    <h2 class="page-title fw-bold fs-1">
                        SMTP Settings
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <form action="<?php echo url('admin/settings/smtp'); ?>" method="POST">
                                        <input type="hidden" name="_csrf_token" value="<?php echo csrf_token(); ?>">

                <div class="row row-cards">
                    <!-- Server & Auth Box -->
                    <div class="col-md-7">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h3 class="card-title mb-3">Server Configuration</h3>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label required">SMTP Host</label>
                                        <input type="text" name="smtp_host" class="form-control" value="<?php echo $settings['smtp_host'] ?? ''; ?>" placeholder="smtp.gmail.com">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label required">SMTP Username</label>
                                        <input type="text" name="smtp_user" class="form-control" value="<?php echo $settings['smtp_user'] ?? ''; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label required">SMTP Password</label>
                                        <input type="password" name="smtp_pass" class="form-control" placeholder="<?php echo !empty($settings['smtp_pass']) ? 'Leave empty to keep current password' : 'Enter SMTP password'; ?>">
                                        <?php if (!empty($settings['smtp_pass'])): ?>
                                        <small class="text-muted"><i class="fas fa-lock me-1"></i>Password is stored encrypted</small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label required">Port</label>
                                        <input type="text" name="smtp_port" class="form-control" value="<?php echo $settings['smtp_port'] ?? ''; ?>" placeholder="587">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label required">Encryption</label>
                                        <select name="smtp_encryption" class="form-select">
                                            <option value="tls" <?php echo ($settings['smtp_encryption'] ?? '') == 'tls' ? 'selected' : ''; ?>>TLS</option>
                                            <option value="ssl" <?php echo ($settings['smtp_encryption'] ?? '') == 'ssl' ? 'selected' : ''; ?>>SSL</option>
                                            <option value="none" <?php echo ($settings['smtp_encryption'] ?? '') == 'none' ? 'selected' : ''; ?>>None</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sender Details Box -->
                    <div class="col-md-5">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h3 class="card-title mb-3">Sender Details</h3>
                                <p class="text-muted small mb-3">This information will appear as the "From" address in sent emails.</p>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label required">From Name</label>
                                        <input type="text" name="smtp_from_name" class="form-control" value="<?php echo $settings['smtp_from_name'] ?? ''; ?>" placeholder="NGO HELP">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label required">From Email</label>
                                        <input type="email" name="smtp_from_email" class="form-control" value="<?php echo $settings['smtp_from_email'] ?? ''; ?>" placeholder="noreply@ngohelp.org">
                                    </div>
                                    
                                    <div class="col-12 mt-4">
                                        <div class="alert alert-warning bg-warning-lt border-0 small">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v4" /><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.535a1.914 1.914 0 0 0 -3.274 0z" /><path d="M12 16h.01" /></svg>
                                            Ensure your SMTP credentials are correct to avoid delivery failures.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3 border-0 shadow-sm">
                    <div class="card-footer bg-transparent text-end">
                        <button type="submit" name="submit" class="btn btn-primary px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                            Save SMTP Settings
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php require_once 'app/views/admin/layouts/footer.php'; ?>
</div>
