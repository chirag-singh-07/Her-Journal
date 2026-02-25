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
                        <h2 id="streak-value" style="font-size: 2.5rem; line-height: 1.1;">-</h2>
                        <span style="color: #10b981; font-weight: 600;" id="streak-text"><i class="fa-solid fa-spinner fa-spin"></i> Loading...</span>
                    </div>
                </div>

                <div class="grid-item glass-card stat-card">
                    <div class="stat-icon-large icon-pink">
                        <i class="fa-solid fa-heart-pulse"></i>
                    </div>
                    <div>
                        <h4 style="color: var(--text-muted); font-weight: 500;">Average Mood</h4>
                        <h2 id="mood-value" style="font-size: 2.5rem; line-height: 1.1;">-</h2>
                        <span id="mood-text" style="color: var(--primary); font-weight: 600;">Loading...</span>
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
        let charts = {};
        const selectedPeriod = '7'; // Default to 7 days

        async function loadAnalyticsData(period = '7') {
            try {
                const res = await fetch(`../php/get_analytics.php?period=${period}`);
                if (res.status === 403) return window.location.href = "login.php";
                const data = await res.json();

                // Update stats
                document.getElementById('streak-value').textContent = data.stats.streak + ' Days';
                document.getElementById('streak-text').innerHTML = data.stats.streak > 0 ? 
                    `<i class="fa-solid fa-arrow-trend-up"></i> Keep it up! 🔥` : 
                    'Start writing to build a streak!';
                document.getElementById('mood-value').textContent = data.stats.dominant_mood;
                document.getElementById('mood-text').textContent = 'Your most frequent mood this period';

                // Update charts
                updateMoodTrendChart(data.daily_entries);
                updateMoodDistributionChart(data.mood_distribution);
                updateConsistencyChart(data.weekly_entries);

                return data;
            } catch (e) {
                console.error('Failed to load analytics:', e);
            }
        }

        function updateMoodTrendChart(dailyData) {
            const ctx = document.getElementById('moodChart').getContext('2d');
            
            if (charts.moodChart) {
                charts.moodChart.destroy();
            }

            // Create a map of all dates from today backwards
            const today = new Date();
            const dateMap = {};
            const labels = [];
            
            for (let i = 6; i >= 0; i--) {
                const d = new Date(today);
                d.setDate(d.getDate() - i);
                const dateStr = d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                labels.push(dateStr);
                dateMap[dateStr] = 0;
            }
            
            // Fill in actual data
            dailyData.labels.forEach((label, idx) => {
                if (dateMap.hasOwnProperty(label)) {
                    dateMap[label] = dailyData.data[idx];
                }
            });
            
            const chartData = labels.map(l => dateMap[l]);

            charts.moodChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Entries Written',
                        data: chartData,
                        backgroundColor: 'rgba(124, 58, 237, 0.7)',
                        borderColor: '#7c3aed',
                        borderRadius: 8,
                        barThickness: 40,
                        borderWidth: 0
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
                            ticks: { stepSize: 1 },
                            grid: { borderDash: [5, 5] }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        function updateMoodDistributionChart(moodData) {
            const ctx = document.getElementById('pieChart').getContext('2d');
            
            if (charts.pieChart) {
                charts.pieChart.destroy();
            }

            charts.pieChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: moodData.labels,
                    datasets: [{
                        data: moodData.data,
                        backgroundColor: moodData.colors,
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
        }

        function updateConsistencyChart(weeklyData) {
            const ctx = document.getElementById('barChart').getContext('2d');
            
            if (charts.barChart) {
                charts.barChart.destroy();
            }

            charts.barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: weeklyData.labels.length > 0 ? weeklyData.labels : ['No Data'],
                    datasets: [{
                        label: 'Entries per Week',
                        data: weeklyData.data.length > 0 ? weeklyData.data : [0],
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
                        y: { beginAtZero: true },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        // Chart.js defaults
        Chart.defaults.font.family = "'Outfit', sans-serif";
        Chart.defaults.color = '#64748b';

        // Load data on page load
        window.addEventListener('load', () => {
            loadAnalyticsData('7');
        });

        // Handle period selection changes (if needed)
        const periodSelect = document.querySelector('select');
        if (periodSelect) {
            periodSelect.addEventListener('change', (e) => {
                const period = e.target.value === 'Last 7 Days' ? '7' : 
                              e.target.value === 'Last 30 Days' ? '30' : 'all';
                loadAnalyticsData(period);
            });
        }
    </script>
</body>
</html>