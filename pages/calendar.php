<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$page_title = 'Calendar';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar - Her Journal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/shared.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        .calendar-layout {
            display: grid;
            grid-template-columns: 2.5fr 1fr;
            gap: 30px;
            padding: 40px;
            max-width: 1400px;
            margin: 0 auto;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .calendar-layout { grid-template-columns: 1fr; }
        }

        /* Calendar Header */
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .calendar-header h2 {
            font-size: 1.8rem;
            color: var(--text-main);
        }

        .calendar-nav button {
            background: white;
            border: 1px solid rgba(0,0,0,0.05);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s;
            color: var(--text-muted);
        }
        
        .calendar-nav button:hover {
            background: var(--primary);
            color: white;
        }

        /* Calendar Grid */
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }

        .weekday {
            text-align: center;
            font-weight: 600;
            color: var(--text-muted);
            padding: 10px 0;
            font-size: 0.9rem;
        }

        .day-cell {
            background: rgba(255,255,255,0.6);
            border-radius: 16px;
            min-height: 100px;
            padding: 10px;
            position: relative;
            border: 1px solid transparent;
            transition: all 0.2s;
            cursor: pointer;
        }

        .day-cell:hover {
            background: white;
            border-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .day-cell.today {
            background: white;
            border: 1px solid var(--primary);
        }

        .day-number {
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 5px;
            display: inline-block;
            width: 25px;
            height: 25px;
            text-align: center;
            line-height: 25px;
        }

        .today .day-number {
            background: var(--primary);
            color: white;
            border-radius: 50%;
        }

        .other-month {
            opacity: 0.4;
        }

        /* Entry Dots */
        .entry-marker {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 4px;
            font-size: 0.75rem;
            color: var(--text-muted);
            background: rgba(124, 58, 237, 0.05);
            padding: 4px 8px;
            border-radius: 8px;
        }

        .mood-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        /* Sidebar content */
        .selected-date-info {
            background: white;
            border-radius: 24px;
            padding: 30px;
            box-shadow: var(--shadow-sm);
        }
    </style>
</head>
<body>
    <div class="dashboard-layout">
        <?php include '../includes/sidebar.php'; ?>

        <main class="main-content">
            <?php include '../includes/header.php'; ?>

            <div class="calendar-layout">
                <!-- Main Calendar View -->
                <div class="glass-card" style="padding: 30px;">
                    <div class="calendar-header">
                        <div style="display: flex; gap: 15px; align-items: center;">
                            <button class="btn btn-secondary" style="padding: 8px 16px; font-size: 0.9rem;">Today</button>
                            <h2 style="font-family: 'Outfit', sans-serif;">February 2026</h2>
                        </div>
                        <div class="calendar-nav">
                            <button><i class="fa-solid fa-chevron-left"></i></button>
                            <button><i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </div>

                    <div class="calendar-grid">
                        <div class="weekday">Sun</div>
                        <div class="weekday">Mon</div>
                        <div class="weekday">Tue</div>
                        <div class="weekday">Wed</div>
                        <div class="weekday">Thu</div>
                        <div class="weekday">Fri</div>
                        <div class="weekday">Sat</div>

                        <!-- Previous Month Days -->
                        <div class="day-cell other-month"><span class="day-number">26</span></div>
                        <div class="day-cell other-month"><span class="day-number">27</span></div>
                        <div class="day-cell other-month"><span class="day-number">28</span></div>
                        <div class="day-cell other-month"><span class="day-number">29</span></div>
                        <div class="day-cell other-month"><span class="day-number">30</span></div>
                        <div class="day-cell other-month"><span class="day-number">31</span></div>
                        
                        <!-- Current Month Days (Fake Data) -->
                        <div class="day-cell"><span class="day-number">1</span></div>
                        <div class="day-cell">
                            <span class="day-number">2</span>
                            <div class="entry-marker">
                                <span class="mood-dot" style="background: #f472b6;"></span> Mood: Happy
                            </div>
                        </div>
                        <div class="day-cell"><span class="day-number">3</span></div>
                        <div class="day-cell">
                             <span class="day-number">4</span>
                             <div class="entry-marker">
                                <span class="mood-dot" style="background: #64748b;"></span> Mood: Anxious
                            </div>
                        </div>
                        <div class="day-cell"><span class="day-number">5</span></div>
                        <div class="day-cell"><span class="day-number">6</span></div>
                        <div class="day-cell"><span class="day-number">7</span></div>
                        <div class="day-cell"><span class="day-number">8</span></div>
                        <div class="day-cell">
                            <span class="day-number">9</span>
                            <div class="entry-marker">
                                <span class="mood-dot" style="background: #f59e0b;"></span> Mood: Energetic
                            </div>
                        </div>
                         <div class="day-cell"><span class="day-number">10</span></div>
                         <div class="day-cell"><span class="day-number">11</span></div>
                         <div class="day-cell"><span class="day-number">12</span></div>
                         <div class="day-cell"><span class="day-number">13</span></div>
                         <div class="day-cell"><span class="day-number">14</span>
                             <div class="entry-marker">
                                <span class="mood-dot" style="background: #7c3aed;"></span> Mood: Love
                            </div>
                         </div>
                         <div class="day-cell"><span class="day-number">15</span></div>
                         <div class="day-cell"><span class="day-number">16</span></div>
                         <div class="day-cell today">
                             <span class="day-number">17</span>
                             <div class="entry-marker">
                                <span class="mood-dot" style="background: #10b981;"></span> Mood: Calm
                            </div>
                         </div>
                         <div class="day-cell"><span class="day-number">18</span></div>
                         <div class="day-cell"><span class="day-number">19</span></div>
                         <div class="day-cell"><span class="day-number">20</span></div>
                         <div class="day-cell"><span class="day-number">21</span></div>
                         <div class="day-cell"><span class="day-number">22</span></div>
                         <div class="day-cell"><span class="day-number">23</span></div>
                         <div class="day-cell"><span class="day-number">24</span></div>
                         <div class="day-cell"><span class="day-number">25</span></div>
                         <div class="day-cell"><span class="day-number">26</span></div>
                         <div class="day-cell"><span class="day-number">27</span></div>
                         <div class="day-cell"><span class="day-number">28</span></div>
                    </div>
                </div>

                <!-- Sidebar for Selected Date -->
                <div class="selected-date-info">
                    <h3 style="margin-bottom: 20px; font-size: 1.2rem; color: var(--text-muted);">Feb 17, 2026 (Today)</h3>
                    
                    <div style="text-align: center; margin-bottom: 30px;">
                        <div style="width: 80px; height: 80px; border-radius: 50%; background: #d1fae5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 15px;">
                            😌
                        </div>
                        <h2 style="font-family: 'Playfair Display', serif; font-size: 1.6rem;">Feeling Calm</h2>
                        <p style="color: var(--text-muted);">"Took a long walk in the park today..."</p>
                    </div>

                    <div style="border-top: 1px solid rgba(0,0,0,0.05); padding-top: 20px;">
                        <h4 style="font-size: 0.9rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 15px; letter-spacing: 1px;">Memories</h4>
                        <div style="border-radius: 12px; overflow: hidden; margin-bottom: 10px;">
                            <img src="https://images.unsplash.com/photo-1490750967868-58cb807861d2?auto=format&fit=crop&q=80&w=400" style="width: 100%; height: 120px; object-fit: cover;">
                        </div>
                        <button class="btn btn-secondary" style="width: 100%;">View Full Entry</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="../js/common.js"></script>
</body>
</html>