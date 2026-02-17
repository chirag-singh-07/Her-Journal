<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$page_title = 'Analytics';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - Her Journal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/shared.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            padding: 40px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        @media (max-width: 1024px) {
            .analytics-grid {
                grid-template-columns: 1fr;
            }
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .stat-card {
            padding: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .stat-icon-large {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }
    </style>
</head>
<body>
    <div class="dashboard-layout">
        <?php include '../includes/sidebar.php'; ?>

        <main class="main-content">
            <?php include '../includes/header.php'; ?>

            <div class="analytics-grid">
                
                <!-- Quick Stats -->
                <div class="grid-item glass-card stat-card">
                    <div class="stat-icon-large icon-purple">
                        <i class="fa-solid fa-fire"></i>
                    </div>
                    <div>
                        <h4 style="color: var(--text-muted); font-weight: 500;">Current Streak</h4>
                        <h2 style="font-size: 2.5rem; line-height: 1.1;">7 Days</h2>
                        <span style="color: #10b981; font-weight: 600;"><i class="fa-solid fa-arrow-trend-up"></i> +2 from last week</span>
                    </div>
                </div>

                <div class="grid-item glass-card stat-card">
                    <div class="stat-icon-large icon-pink">
                        <i class="fa-solid fa-heart-pulse"></i>
                    </div>
                    <div>
                        <h4 style="color: var(--text-muted); font-weight: 500;">Average Mood</h4>
                        <h2 style="font-size: 2.5rem; line-height: 1.1;">Happy</h2>
                        <span style="color: var(--primary); font-weight: 600;">Mainly positive vibes!</span>
                    </div>
                </div>

                <!-- Mood Trend Chart -->
                <div class="grid-item glass-card full-width" style="padding: 30px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h3><i class="fa-solid fa-chart-line"></i> Mood Trends (Last 7 Days)</h3>
                        <select style="padding: 8px 16px; border-radius: 12px; border: 1px solid #ddd;">
                            <option>Last 7 Days</option>
                            <option>Last 30 Days</option>
                            <option>All Time</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="moodChart"></canvas>
                    </div>
                </div>

                <!-- Word Cloud / Keywords -->
                <div class="grid-item glass-card" style="padding: 30px;">
                    <h3 style="margin-bottom: 20px;"><i class="fa-solid fa-tags"></i> Common Themes</h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        <span style="font-size: 1.5rem; color: var(--primary); font-weight: 700;">Gratitude</span>
                        <span style="font-size: 1.2rem; color: var(--accent); font-weight: 600;">Work</span>
                        <span style="font-size: 1rem; color: #10b981; font-weight: 500;">Family</span>
                        <span style="font-size: 1.8rem; color: #f59e0b; font-weight: 800;">Peace</span>
                        <span style="font-size: 0.9rem; color: var(--text-muted);">Exercise</span>
                        <span style="font-size: 1.1rem; color: var(--primary-dark);">Coffee</span>
                        <span style="font-size: 1.3rem; color: #ec4899;">Friends</span>
                        <span style="font-size: 1rem; color: var(--text-main);">Travel</span>
                        <span style="font-size: 1.4rem; color: #6366f1;">Learning</span>
                    </div>
                    <p style="margin-top: 20px; color: var(--text-muted); font-size: 0.9rem;">These words appear most frequently in your happy entries.</p>
                </div>

                <!-- Mood Distribution Pie Chart -->
                <div class="grid-item glass-card" style="padding: 30px;">
                    <h3 style="margin-bottom: 20px;"><i class="fa-solid fa-chart-pie"></i> Mood Distribution</h3>
                    <div class="chart-container" style="height: 250px;">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>

                <!-- Writing Consistency Heatmap-ish -->
                <div class="grid-item glass-card full-width" style="padding: 30px;">
                    <h3 style="margin-bottom: 20px;"><i class="fa-solid fa-calendar-check"></i> Writing Consistency</h3>
                    <div class="chart-container" style="height: 200px;">
                         <canvas id="barChart"></canvas>
                    </div>
                </div>

            </div>
        </main>
    </div>
    <script src="../js/common.js"></script>
    <script>
        // Chart Configs
        Chart.defaults.font.family = "'Outfit', sans-serif";
        Chart.defaults.color = '#64748b';

        // Mood Trend Line Chart
        const moodCtx = document.getElementById('moodChart').getContext('2d');
        new Chart(moodCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Mood Score',
                    data: [3, 4, 3, 5, 4, 5, 4], // 1-5 scale (Sad to Happy/Energetic)
                    borderColor: '#7c3aed',
                    backgroundColor: 'rgba(124, 58, 237, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#f472b6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 6,
                        ticks: {
                            callback: function(value) {
                                const moods = ['', '😢 Sad', '😰 Anxious', '😌 Calm', '😊 Happy', '⚡ Energetic'];
                                return moods[value] || '';
                            }
                        },
                        grid: { borderDash: [5, 5] }
                    },
                    x: { grid: { display: false } }
                }
            }
        });

        // Mood Distribution Pie Chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Happy', 'Calm', 'Energetic', 'Anxious', 'Sad'],
                datasets: [{
                    data: [45, 25, 15, 10, 5],
                    backgroundColor: [
                        '#7c3aed', // Purple
                        '#f472b6', // Pink
                        '#f59e0b', // Orange
                        '#64748b', // Gray
                        '#3b82f6'  // Blue
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right' }
                },
                cutout: '70%'
            }
        });

        // Consistency Bar Chart
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Entries per Week',
                    data: [5, 7, 4, 6],
                    backgroundColor: '#a78bfa',
                    borderRadius: 8,
                    barThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { display: false },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</body>
</html>