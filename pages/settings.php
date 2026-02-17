<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$page_title = 'Settings';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Her Journal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/shared.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        .settings-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
            padding: 40px;
            max-width: 1400px;
            margin: 0 auto;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .settings-grid { grid-template-columns: 1fr; }
        }

        /* Settings Nav */
        .settings-nav {
            list-style: none;
            padding: 0;
        }

        .settings-nav li button {
            width: 100%;
            text-align: left;
            padding: 16px 20px;
            background: transparent;
            border: none;
            border-radius: 12px;
            color: var(--text-muted);
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .settings-nav li button:hover {
            background: rgba(124, 58, 237, 0.05);
            color: var(--primary);
        }

        .settings-nav li button.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
        }

        /* Settings Section Styles */
        .settings-section {
            display: none;
            animation: fadeIn 0.4s ease;
        }

        .settings-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-main);
            font-size: 0.95rem;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: 1px solid rgba(0,0,0,0.1);
            background: rgba(255,255,255,0.8);
            font-size: 1rem;
            outline: none;
            transition: all 0.2s;
        }

        .form-group input:focus, .form-group select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.05);
            background: white;
        }

        /* Toggles */
        .toggle-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .toggle-item:last-child {
            border-bottom: none;
        }

        .toggle-label h5 {
            font-size: 1rem;
            margin-bottom: 4px;
        }

        .toggle-label p {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin: 0;
        }

        .toggle-switch {
            position: relative;
            width: 50px;
            height: 28px;
            appearance: none;
            background: #cbd5e1;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .toggle-switch::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: white;
            transition: all 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .toggle-switch:checked {
            background: var(--primary);
        }

        .toggle-switch:checked::after {
            transform: translateX(22px);
        }

        /* Color Options */
        .theme-options {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .theme-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s;
        }

        .theme-circle:hover, .theme-circle.active {
            transform: scale(1.1);
            border-color: var(--text-main);
        }

    </style>
</head>
<body>
    <div class="dashboard-layout">
        <?php include '../includes/sidebar.php'; ?>

        <main class="main-content">
            <?php include '../includes/header.php'; ?>

            <div class="settings-grid">
                <!-- Settings Navigation -->
                <div class="glass-card" style="padding: 20px;">
                    <ul class="settings-nav">
                        <li><button class="active" onclick="showTab('profile', this)"><i class="fa-solid fa-user"></i> Profile</button></li>
                        <li><button onclick="showTab('appearance', this)"><i class="fa-solid fa-paintbrush"></i> Appearance</button></li>
                        <li><button onclick="showTab('notifications', this)"><i class="fa-solid fa-bell"></i> Notifications</button></li>
                        <li><button onclick="showTab('security', this)"><i class="fa-solid fa-shield-halved"></i> Security</button></li>
                    </ul>
                </div>

                <!-- Settings Content -->
                <div class="glass-card" style="padding: 40px; min-height: 500px;">
                    
                    <!-- Profile Section -->
                    <div id="profile" class="settings-section active">
                        <h3 style="margin-bottom: 30px; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 15px;">Profile Settings</h3>
                        
                        <div style="display: flex; gap: 24px; align-items: center; margin-bottom: 30px;">
                            <div class="avatar" style="width: 100px; height: 100px; font-size: 2.5rem; box-shadow: var(--shadow-md);">
                                <?php echo strtoupper(substr($_SESSION['name'] ?? 'U', 0, 1)); ?>
                            </div>
                            <div>
                                <h4 style="font-size: 1.4rem; margin-bottom: 8px;"><?php echo htmlspecialchars($_SESSION['name'] ?? 'User'); ?></h4>
                                <button class="btn btn-secondary" style="font-size: 0.9rem; padding: 8px 20px;">Upload New Photo</button>
                            </div>
                        </div>

                        <form>
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" value="<?php echo htmlspecialchars($_SESSION['name'] ?? 'User'); ?>">
                            </div>
                            <div class="form-group">
                                <label>Bio</label>
                                <input type="text" placeholder="Tell us a little about yourself...">
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" value="<?php echo htmlspecialchars($_SESSION['email'] ?? 'user@example.com'); ?>" disabled style="background: rgba(0,0,0,0.02); color: #64748b;">
                            </div>
                            <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
                                <button type="button" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>

                    <!-- Appearance Section -->
                    <div id="appearance" class="settings-section">
                        <h3 style="margin-bottom: 30px;">Appearance</h3>
                        
                        <div class="form-group">
                            <label>Interface Theme</label>
                            <div style="display: flex; gap: 20px; margin-top: 10px;">
                                <div style="flex: 1; padding: 20px; border: 2px solid var(--primary); border-radius: 16px; text-align: center; background: white; cursor: pointer;">
                                    <i class="fa-regular fa-sun" style="font-size: 1.5rem; color: #f59e0b; margin-bottom: 10px;"></i>
                                    <h5>Light Mode</h5>
                                </div>
                                <div style="flex: 1; padding: 20px; border: 1px solid rgba(0,0,0,0.1); border-radius: 16px; text-align: center; background: #1e1b4b; color: white; cursor: pointer; opacity: 0.7;">
                                    <i class="fa-solid fa-moon" style="font-size: 1.5rem; margin-bottom: 10px;"></i>
                                    <h5>Dark Mode</h5>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 30px;">
                            <label>Accent Color</label>
                            <div class="theme-options">
                                <div class="theme-circle active" style="background: #7c3aed;"></div>
                                <div class="theme-circle" style="background: #ec4899;"></div>
                                <div class="theme-circle" style="background: #10b981;"></div>
                                <div class="theme-circle" style="background: #f59e0b;"></div>
                                <div class="theme-circle" style="background: #3b82f6;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications Section -->
                    <div id="notifications" class="settings-section">
                        <h3 style="margin-bottom: 30px;">Notifications</h3>
                        
                        <div class="toggle-item">
                            <div class="toggle-label">
                                <h5>Daily Reminders</h5>
                                <p>Get reminded to write in your journal every day.</p>
                            </div>
                            <input type="checkbox" class="toggle-switch" checked>
                        </div>
                        
                        <div class="toggle-item">
                            <div class="toggle-label">
                                <h5>Motivational Quotes</h5>
                                <p>Receive a daily quote notification.</p>
                            </div>
                            <input type="checkbox" class="toggle-switch" checked>
                        </div>

                        <div class="toggle-item">
                            <div class="toggle-label">
                                <h5>Weekly Summary</h5>
                                <p>Get a weekly email report of your mood trends.</p>
                            </div>
                            <input type="checkbox" class="toggle-switch">
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div id="security" class="settings-section">
                        <h3 style="margin-bottom: 30px;">Security</h3>
                        
                        <form>
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" placeholder="••••••••">
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" placeholder="Enter new password">
                            </div>
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input type="password" placeholder="Repeat new password">
                            </div>
                             <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
                                <button type="button" class="btn btn-primary">Update Password</button>
                            </div>
                        </form>

                        <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(0,0,0,0.05);">
                            <h4 style="color: #ef4444; margin-bottom: 10px;">Danger Zone</h4>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <p style="color: var(--text-muted); font-size: 0.9rem;">Delete your account and all data permanently.</p>
                                <button class="btn" style="background: #fee2e2; color: #dc2626; border: none;">Delete Account</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
    <script src="../js/common.js"></script>
    <script>
        function showTab(tabId, btn) {
            // Hide all sections
            document.querySelectorAll('.settings-section').forEach(el => el.classList.remove('active'));
            // Remove active class from buttons
            document.querySelectorAll('.settings-nav button').forEach(el => el.classList.remove('active'));
            
            // Show selected section
            document.getElementById(tabId).classList.add('active');
            // Activate button
            btn.classList.add('active');
        }
    </script>
</body>
</html>