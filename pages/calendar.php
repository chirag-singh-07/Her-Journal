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
                            <button id="todayBtn" class="btn btn-secondary" style="padding: 8px 16px; font-size: 0.9rem;">Today</button>
                            <h2 id="monthTitle" style="font-family: 'Outfit', sans-serif;">Loading...</h2>
                        </div>
                        <div class="calendar-nav">
                            <button id="prevBtn"><i class="fa-solid fa-chevron-left"></i></button>
                            <button id="nextBtn"><i class="fa-solid fa-chevron-right"></i></button>
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
                        <div id="calendar-body">
                            <div style="text-align: center; padding: 40px; color: var(--text-muted);" class="weekday" style="grid-column: 1 / -1;">
                                <i class="fa-solid fa-spinner fa-spin"></i> Loading calendar...
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar for Selected Date -->
                <div class="selected-date-info">
                    <h3 id="dateTitle" style="margin-bottom: 20px; font-size: 1.2rem; color: var(--text-muted);">Select a date</h3>
                    <div id="entriesContainer" style="text-align: center; padding: 40px; color: var(--text-muted);">
                        <i class="fa-regular fa-calendar"></i>
                        <p>Click on a date to view entries</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="../js/common.js"></script>
    <script>
        let currentYear = new Date().getFullYear();
        let currentMonth = new Date().getMonth() + 1;
        let selectedDate = null;

        const mood_emojis = {
            'Happy': '😊',
            'Calm': '😌',
            'Sad': '😢',
            'Anxious': '😰',
            'Energetic': '⚡'
        };

        async function loadCalendar(year, month) {
            try {
                const res = await fetch(`../php/get_calendar.php?year=${year}&month=${month}`);
                if (res.status === 403) return window.location.href = "login.php";
                const data = await res.json();

                // Update month title
                document.getElementById('monthTitle').textContent = `${data.month_name} ${data.year}`;

                // Build calendar days
                const calendarBody = document.getElementById('calendar-body');
                calendarBody.innerHTML = '';

                data.calendar_days.forEach(day => {
                    const dayCell = document.createElement('div');
                    dayCell.className = 'day-cell';
                    
                    if (day.is_other_month) {
                        dayCell.classList.add('other-month');
                    }
                    
                    if (day.is_today) {
                        dayCell.classList.add('today');
                    }

                    let html = `<span class="day-number">${day.day}</span>`;
                    
                    // Add entry markers
                    if (day.entries.length > 0) {
                        const entry = day.entries[0]; // Get first entry of the day
                        const moodColor = data.mood_colors[entry.mood] || '#6366f1';
                        const moodEmoji = mood_emojis[entry.mood] || '📝';
                        
                        html += `
                            <div class="entry-marker">
                                <span class="mood-dot" style="background: ${moodColor};"></span>
                                <span>${moodEmoji}</span>
                            </div>
                        `;

                        if (day.entries.length > 1) {
                            html += `<div class="entry-marker" style="font-size: 0.7rem; background: rgba(0,0,0,0.05); padding: 2px 6px;">+${day.entries.length - 1} more</div>`;
                        }
                    }

                    dayCell.innerHTML = html;
                    dayCell.style.cursor = 'pointer';
                    
                    // Click handler
                    dayCell.addEventListener('click', () => {
                        loadDateEntries(day.date);
                    });

                    calendarBody.appendChild(dayCell);
                });

                // Load today's entries by default
                const today = new Date();
                if (today.getFullYear() === year && today.getMonth() + 1 === month) {
                    const todayStr = today.toISOString().split('T')[0];
                    loadDateEntries(todayStr);
                }
            } catch (e) {
                console.error(e);
            }
        }

        async function loadDateEntries(date) {
            try {
                selectedDate = date;
                const res = await fetch(`../php/get_calendar_entries.php?date=${date}`);
                const data = await res.json();

                const dateObj = new Date(date);
                const dateFormatted = dateObj.toLocaleDateString('en-US', { 
                    weekday: 'short', 
                    year: 'numeric', 
                    month: 'short', 
                    day: 'numeric' 
                });

                const isToday = date === new Date().toISOString().split('T')[0];
                document.getElementById('dateTitle').textContent = `${dateFormatted}${isToday ? ' (Today)' : ''}`;

                const entriesContainer = document.getElementById('entriesContainer');

                if (data.entries.length === 0) {
                    entriesContainer.innerHTML = `
                        <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                            <i class="fa-regular fa-pen-to-square" style="font-size: 2rem; margin-bottom: 15px; opacity: 0.5;"></i>
                            <p>No entries for this date</p>
                        </div>
                    `;
                    return;
                }

                entriesContainer.innerHTML = data.entries.map((entry, idx) => {
                    const mood = entry.mood || 'Unknown';
                    const moodEmoji = mood_emojis[mood] || '📝';
                    const entryTime = new Date(entry.entry_date).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                    
                    let htmlPreview = entry.text;
                    if (htmlPreview.length > 150) {
                        htmlPreview = htmlPreview.substring(0, 150) + '...';
                    }

                    return `
                        <div style="background: white; border-radius: 16px; padding: 20px; margin-bottom: 15px; text-align: left; border-left: 4px solid var(--primary);" class="entry-card">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                                <div style="font-size: 2rem;">${moodEmoji}</div>
                                <span style="color: var(--text-muted); font-size: 0.85rem;">${entryTime}</span>
                            </div>
                            <h4 style="margin: 0 0 8px 0; color: var(--text-main);">${mood}</h4>
                            <p style="margin: 0; color: var(--text-muted); font-size: 0.95rem; line-height: 1.5;">${htmlPreview}</p>
                            ${entry.attachment_path ? `<div style="margin-top: 12px; border-radius: 8px; overflow: hidden; height: 100px;"><img src="../${entry.attachment_path}" style="width: 100%; height: 100%; object-fit: cover;"></div>` : ''}
                        </div>
                    `;
                }).join('');

            } catch (e) {
                console.error(e);
            }
        }

        // Event listeners
        document.getElementById('prevBtn').addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 1) {
                currentMonth = 12;
                currentYear--;
            }
            loadCalendar(currentYear, currentMonth);
        });

        document.getElementById('nextBtn').addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 12) {
                currentMonth = 1;
                currentYear++;
            }
            loadCalendar(currentYear, currentMonth);
        });

        document.getElementById('todayBtn').addEventListener('click', () => {
            currentYear = new Date().getFullYear();
            currentMonth = new Date().getMonth() + 1;
            loadCalendar(currentYear, currentMonth);
        });

        // Load initial calendar
        loadCalendar(currentYear, currentMonth);
    </script>
</body>
</html>