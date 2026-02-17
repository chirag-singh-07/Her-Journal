<header class="dashboard-header glass">
    <div class="header-left">
        <h2><?php echo $page_title ?? 'Dashboard'; ?> 🌸</h2>
        <p class="date-display"><?php echo date('l, F j, Y'); ?></p>
    </div>
    <div class="header-right">
        <button class="btn-icon"><i class="fa-regular fa-bell"></i></button>
        <div class="user-profile">
            <div class="user-info" style="text-align: right; margin-right: 10px;">
                <span class="user-name"
                    style="display: block; font-weight: 600; font-size: 0.9rem;"><?php echo htmlspecialchars($_SESSION['name'] ?? 'User'); ?></span>
                <span class="user-role"
                    style="display: block; font-size: 0.75rem; color: var(--text-muted);">Member</span>
            </div>
            <div class="avatar"><?php echo strtoupper(substr($_SESSION['name'] ?? 'U', 0, 1)); ?></div>
        </div>
    </div>
</header>