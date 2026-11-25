<!-- Topbar -->
<?php if (isset($_SESSION['member_id'])): ?>
<header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none">
    <div class="container-xl" style="overflow: visible;">
        <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <span class="avatar avatar-sm" style="background: rgba(255,191,0,0.2); color: #FFBF00; font-weight: 700;">
                        <?php echo strtoupper(substr($_SESSION['member_name'] ?? 'M', 0, 1)); ?>
                    </span>
                    <div class="d-none d-xl-block ps-2">
                        <div><?php echo $_SESSION['member_name'] ?? 'Member'; ?></div>
                        <div class="mt-1 small text-muted">Member</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="<?php echo url('member/profile'); ?>" class="dropdown-item">Profile</a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#modal-logout">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Mobile Topbar -->
<header class="navbar navbar-light d-lg-none d-flex d-print-none" style="background:#fff;border-bottom:1px solid #e5e7eb;height:56px;">
    <div class="container-fluid px-3" style="overflow: visible;">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="d-flex align-items-center gap-2">
                <a href="javascript:void(0)" class="d-flex" id="mobile-sidebar-toggle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 6l16 0" /><path d="M4 12l16 0" /><path d="M4 18l16 0" /></svg>
                </a>
                <span class="fw-bold" style="font-size: 1.1rem; color: #1a1a2e;"><?php echo e($globalSettings['ngo_name'] ?? 'NGO'); ?></span>
            </div>
            <div class="d-flex align-items-center gap-1">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                    <span class="avatar avatar-sm" style="background: rgba(255,191,0,0.2); color: #FFBF00; font-weight: 700;">
                        <?php echo strtoupper(substr($_SESSION['member_name'] ?? 'M', 0, 1)); ?>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="<?php echo url('member/profile'); ?>" class="dropdown-item">Profile</a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#modal-logout">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>
</header>
<?php return; endif; ?>
<header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none">
    <div class="container-xl" style="overflow: visible;">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Sidebar Toggle (Desktop Burger Menu) -->
        <a href="javascript:void(0)" class="nav-link px-0 me-3 d-none d-lg-block" id="sidebar-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 6l16 0" /><path d="M4 12l16 0" /><path d="M4 18l16 0" /></svg>
        </a>
        <div class="navbar-nav flex-row order-md-last">
            <div class="d-none d-md-flex me-3">
                <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
                </a>
                <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
                </a>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <span class="avatar avatar-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" /></svg>
                    </span>
                    <div class="d-none d-xl-block ps-2">
                        <div><?php echo $_SESSION['user_name'] ?? 'Administrator'; ?></div>
                        <div class="mt-1 small text-muted"><?php echo $globalSettings['ngo_name'] ?? 'Super Admin'; ?></div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="<?php echo url('admin/profile'); ?>" class="dropdown-item">Profile</a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#modal-logout">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Topbar -->
<header class="navbar navbar-light d-lg-none d-flex d-print-none" style="background:#fff;border-bottom:1px solid #e5e7eb;height:56px;">
    <div class="container-fluid px-3" style="overflow: visible;">
        <div class="d-flex align-items-center gap-2">
            <a href="javascript:void(0)" class="nav-link px-1" id="mobile-sidebar-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 6l16 0" /><path d="M4 12l16 0" /><path d="M4 18l16 0" /></svg>
            </a>
        </div>
        <div class="d-flex align-items-center gap-1">
            <a href="?theme=dark" class="nav-link px-2 hide-theme-dark">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
            </a>
            <a href="?theme=light" class="nav-link px-2 hide-theme-light">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
            </a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                    <span class="avatar avatar-sm" style="background:#e2e8f0;color:#475569;font-weight:600;font-size:0.75rem;">
                        <?php echo strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 2)); ?>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="<?php echo url('admin/profile'); ?>" class="dropdown-item">Profile</a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#modal-logout">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>
