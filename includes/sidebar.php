<aside class="sidebar glass">
    <div class="sidebar-header">
        <div class="logo-box"><i class="fa-solid fa-feather-pointed"></i></div>
        <span class="logo-text">Her Journal</span>
    </div>

    <ul class="sidebar-menu">
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        $menu_items = [
            'dashboard.php' => ['icon' => 'fa-house', 'label' => 'Overview'],
            'journal.php' => ['icon' => 'fa-book-open', 'label' => 'My Journal'],
            'analytics.php' => ['icon' => 'fa-chart-pie', 'label' => 'Analytics'],
            'calendar.php' => ['icon' => 'fa-calendar-days', 'label' => 'Calendar'],
            'settings.php' => ['icon' => 'fa-gear', 'label' => 'Settings']
        ];

        foreach ($menu_items as $page => $item) {
            $class = ($current_page == $page) ? 'active' : '';
            echo "<li class=\"$class\"><a href=\"$page\"><i class=\"fa-solid {$item['icon']}\"></i> {$item['label']}</a></li>";
        }
        ?>
    </ul>

    <div class="sidebar-footer">
        <button onclick="logout()" class="btn-logout"><i class="fa-solid fa-right-from-bracket"></i>
            Logout</button>
    </div>
</aside>