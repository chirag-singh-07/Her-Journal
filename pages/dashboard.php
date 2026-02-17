<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$page_title = 'Overview';
date_default_timezone_set('Asia/Kolkata'); // Adjust as needed
$hour = date('H');
$greeting = 'Good Morning';
if ($hour >= 12 && $hour < 17)
    $greeting = 'Good Afternoon';
if ($hour >= 17)
    $greeting = 'Good Evening';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview - Her Journal</title>
    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;1,600&display=swap"
        rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/shared.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        /* Overview Specific Styles */
        .welcome-section {
            grid-column: 1 / -1;
            background: linear-gradient(135deg, #6d28d9, #db2777);
            border-radius: 30px;
            padding: 40px;
            color: white;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 20px 40px -10px rgba(109, 40, 217, 0.4);
        }

        .welcome-text {
            position: relative;
            z-index: 2;
            max-width: 60%;
        }

        .welcome-text h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .welcome-text p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 25px;
        }

        .welcome-btn {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .welcome-btn:hover {
            background: white;
            color: #db2777;
            transform: translateY(-2px);
        }

        .floating-shapes div {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .shape-1 {
            width: 200px;
            height: 200px;
            top: -50px;
            right: -50px;
        }

        .shape-2 {
            width: 100px;
            height: 100px;
            bottom: 20px;
            right: 150px;
        }

        .shape-3 {
            width: 60px;
            height: 60px;
            top: 40px;
            right: 250px;
        }

        /* Quick Action Cards */
        .quick-actions-grid {
            grid-column: 2;
            display: grid;
            gap: 20px;
        }

        .action-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            cursor: pointer;
            transition: all 0.3s;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .action-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            border-color: var(--primary);
        }

        .action-icon {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: white;
        }

        /* Recent Activity with Timeline */
        .activity-widget {
            grid-column: 1;
            background: white;
            border-radius: 24px;
            padding: 30px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .timeline-item {
            display: flex;
            gap: 20px;
            padding-bottom: 30px;
            position: relative;
            cursor: pointer;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-line {
            position: absolute;
            left: 20px;
            top: 45px;
            bottom: 0;
            width: 2px;
            background: rgba(0, 0, 0, 0.05);
        }

        .timeline-item:last-child .timeline-line {
            display: none;
        }

        .timeline-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 1rem;
            position: relative;
            z-index: 2;
            flex-shrink: 0;
            border: 4px solid white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .timeline-content h4 {
            font-size: 1rem;
            margin-bottom: 6px;
            color: var(--text-main);
        }

        .timeline-content p {
            color: var(--text-muted);
            font-size: 0.9rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .timeline-time {
            font-size: 0.8rem;
            color: var(--primary);
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
        }

        /* Inspiration Card */
        .inspiration-card {
            grid-column: 2;
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border-radius: 24px;
            padding: 30px;
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .inspiration-card i {
            font-size: 8rem;
            position: absolute;
            bottom: -20px;
            right: -20px;
            color: rgba(56, 189, 248, 0.1);
        }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        <!-- Sidebar -->
        <?php include '../includes/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header -->
            <?php include '../includes/header.php'; ?>

            <!-- Dashboard Grid -->
            <div class="dashboard-grid">

                <!-- Welcome Section -->
                <div class="welcome-section">
                    <div class="welcome-text">
                        <h1><?php echo $greeting; ?>, <?php echo htmlspecialchars($_SESSION['name'] ?? 'Guest'); ?>!
                        </h1>
                        <p>Ready to capture today's memories? Your journal is waiting.</p>
                        <a href="journal.php" class="welcome-btn"><i class="fa-solid fa-pen-nib"></i> Write Summary</a>
                    </div>
                    <div class="floating-shapes">
                        <div class="shape-1"></div>
                        <div class="shape-2"></div>
                        <div class="shape-3"></div>
                    </div>
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png"
                        style="height: 160px; position: relative; z-index: 2; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));"
                        alt="Journal Illustration">
                </div>

                <!-- Recent Activity Feed -->
                <div class="activity-widget">
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                        <h3><i class="fa-regular fa-clock"></i> Recent Activity</h3>
                        <a href="journal.php"
                            style="color: var(--primary); font-size: 0.9rem; font-weight: 600; text-decoration: none;">View
                            All</a>
                    </div>

                    <div id="timeline-container">
                        <div style="text-align: center; color: var(--text-muted); padding: 40px;">
                            <i class="fa-solid fa-spinner fa-spin"></i> Loading updates...
                        </div>
                    </div>
                </div>

                <!-- Quick Actions / Stats -->
                <div class="quick-actions-grid">

                    <!-- Analytics Teaser -->
                    <div class="action-card" onclick="window.location.href='analytics.php'">
                        <div class="action-icon icon-purple"
                            style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <div>
                            <h4 style="margin-bottom: 4px; font-size: 1.1rem;">Consistency</h4>
                            <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">You're on a 3-day streak!
                                🔥</p>
                        </div>
                    </div>

                    <!-- Mood Teaser -->
                    <div class="action-card" onclick="window.location.href='journal.php'">
                        <div class="action-icon icon-pink"
                            style="background: linear-gradient(135deg, #f472b6, #ec4899);">
                            <i class="fa-solid fa-face-smile"></i>
                        </div>
                        <div>
                            <h4 style="margin-bottom: 4px; font-size: 1.1rem;">Mood Check</h4>
                            <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">Mainly
                                <strong>Happy</strong> this week.
                            </p>
                        </div>
                    </div>

                    <!-- Inspiration / Quote -->
                    <div class="inspiration-card">
                        <i class="fa-solid fa-quote-right"></i>
                        <h4
                            style="color: #0ea5e9; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; margin-bottom: 10px;">
                            Daily Wisdom</h4>
                        <blockquote
                            style="font-family: 'Playfair Display', serif; font-size: 1.4rem; color: #0c4a6e; line-height: 1.4; margin: 0;">
                            "The only way to do great work is to love what you do."
                        </blockquote>
                        <p style="margin-top: 10px; color: #38bdf8; font-weight: 500;">- Steve Jobs</p>
                    </div>

                </div>

            </div>
        </main>
    </div>

    <!-- Modals -->
    <div class="modal" id="entryModal">
        <div class="modal-content glass-card">
            <h3>Entry Details</h3>
            <p id="modalDate" style="color: var(--primary); font-weight: 600; margin-bottom: 15px;"></p>
            <p id="modalText" style="line-height: 1.6; color: var(--text-main); font-size: 1.1rem;"></p>
            <div class="modal-actions" style="margin-top: 20px; display: flex; justify-content: flex-end;">
                <button class="btn btn-secondary"
                    onclick="document.getElementById('entryModal').classList.remove('active')">Close</button>
            </div>
        </div>
    </div>

    <script src="../js/common.js"></script>
    <script>
        // Load recent activity timeline
        async function loadTimeline() {
            const container = document.getElementById('timeline-container');
            try {
                const res = await fetch("../php/get_entries.php");
                if (res.status === 403) return window.location.href = "login.php";
                const entries = await res.json();

                if (entries.length === 0) {
                    container.innerHTML = `
                    <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                        <i class="fa-regular fa-paper-plane" style="font-size: 2rem; margin-bottom: 15px; opacity: 0.5;"></i>
                        <p>No activity yet. Write your first entry!</p>
                    </div>`;
                    return;
                }

                container.innerHTML = entries.slice(0, 4).map((entry, index) => {
                    const date = new Date(entry.entry_date).toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
                    const moodIcon = getMoodIcon(entry.mood);
                    return `
                        <div class="timeline-item" onclick="viewEntry(${index})">
                            <div class="timeline-line"></div>
                            <div class="timeline-icon">${moodIcon}</div>
                            <div class="timeline-content">
                                <span class="timeline-time">${date}</span>
                                <h4>Journal Entry</h4>
                                <p>${entry.text}</p>
                            </div>
                        </div>
                    `;
                }).join('');

                window.entriesData = entries; // Store for modal
            } catch (e) {
                console.error(e);
                container.innerHTML = '<p style="color: red; text-align: center;">Failed to load activity.</p>';
            }
        }

        function getMoodIcon(mood) {
            const icons = { 'Happy': '😊', 'Calm': '😌', 'Sad': '😢', 'Anxious': '😰', 'Energetic': '⚡' };
            return icons[mood] || '📝';
        }

        function viewEntry(index) {
            const entry = window.entriesData[index];
            document.getElementById('modalDate').innerText = new Date(entry.entry_date).toLocaleString();
            document.getElementById('modalText').innerText = entry.text;
            document.getElementById('entryModal').classList.add('active');
        }

        window.onload = loadTimeline;
    </script>
</body>

</html>