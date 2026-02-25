<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit;
}

$user_id = $_SESSION['user_id'];
$period = isset($_GET['period']) ? $_GET['period'] : '7'; // 7, 30, or 'all'

// Determine date range
$start_date = match($period) {
    '30' => date('Y-m-d H:i:s', strtotime('-30 days')),
    'all' => '2000-01-01',
    default => date('Y-m-d H:i:s', strtotime('-7 days'))
};

// Get mood distribution
$mood_sql = "SELECT mood, COUNT(*) as count FROM journal_entries 
            WHERE user_id = ? AND entry_date >= ? 
            GROUP BY mood ORDER BY count DESC";
$mood_stmt = $conn->prepare($mood_sql);
$mood_stmt->bind_param("is", $user_id, $start_date);
$mood_stmt->execute();
$mood_result = $mood_stmt->get_result();

$mood_labels = [];
$mood_data = [];
$mood_colors = [];
$mood_color_map = [
    'Happy' => '#7c3aed',
    'Calm' => '#f472b6',
    'Energetic' => '#f59e0b',
    'Anxious' => '#64748b',
    'Sad' => '#3b82f6'
];

while ($row = $mood_result->fetch_assoc()) {
    $mood_labels[] = $row['mood'] ?: 'Unknown';
    $mood_data[] = (int)$row['count'];
    $mood_colors[] = $mood_color_map[$row['mood']] ?? '#6366f1';
}

// Get entries per day (last 7 or 30 days)
$daily_sql = "SELECT DATE(entry_date) as date, COUNT(*) as count 
             FROM journal_entries
             WHERE user_id = ? AND entry_date >= ?
             GROUP BY DATE(entry_date)
             ORDER BY date ASC";
$daily_stmt = $conn->prepare($daily_sql);
$daily_stmt->bind_param("is", $user_id, $start_date);
$daily_stmt->execute();
$daily_result = $daily_stmt->get_result();

$dates = [];
$daily_counts = [];
while ($row = $daily_result->fetch_assoc()) {
    $dates[] = date('M d', strtotime($row['date']));
    $daily_counts[] = (int)$row['count'];
}

// Get entries per week (for consistency chart)
$week_sql = "SELECT WEEK(entry_date) as week, YEAR(entry_date) as year, COUNT(*) as count
            FROM journal_entries
            WHERE user_id = ? AND entry_date >= ?
            GROUP BY YEAR(entry_date), WEEK(entry_date)
            ORDER BY year, week";
$week_stmt = $conn->prepare($week_sql);
$week_stmt->bind_param("is", $user_id, $start_date);
$week_stmt->execute();
$week_result = $week_stmt->get_result();

$week_labels = [];
$week_counts = [];
while ($row = $week_result->fetch_assoc()) {
    $week_labels[] = "Week " . $row['week'];
    $week_counts[] = (int)$row['count'];
}

// Get current streak
$streak_sql = "SELECT DATE(entry_date) as entry_date FROM journal_entries
              WHERE user_id = ?
              ORDER BY entry_date DESC
              LIMIT 30";
$streak_stmt = $conn->prepare($streak_sql);
$streak_stmt->bind_param("i", $user_id);
$streak_stmt->execute();
$streak_result = $streak_stmt->get_result();

$streak = 0;
$current_date = new DateTime();

while ($row = $streak_result->fetch_assoc()) {
    $entry_date = new DateTime($row['entry_date']);
    $diff = $current_date->diff($entry_date)->days;
    
    if ($diff === $streak) {
        $streak++;
        $current_date = $entry_date;
    } else {
        break;
    }
}

// Get total entries
$total_sql = "SELECT COUNT(*) as count FROM journal_entries WHERE user_id = ?";
$total_stmt = $conn->prepare($total_sql);
$total_stmt->bind_param("i", $user_id);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_entries = $total_result->fetch_assoc()['count'];

// Get average mood (numeric: Happy=5, Calm=4, Energetic=5, Anxious=2, Sad=1)
$avg_mood_sql = "SELECT AVG(CASE 
                    WHEN mood='Happy' THEN 5
                    WHEN mood='Energetic' THEN 5
                    WHEN mood='Calm' THEN 4
                    WHEN mood='Anxious' THEN 2
                    WHEN mood='Sad' THEN 1
                    ELSE 3
                 END) as avg_mood,
                 mood
              FROM journal_entries
              WHERE user_id = ? AND entry_date >= ?
              GROUP BY mood
              ORDER BY COUNT(*) DESC
              LIMIT 1";
$avg_stmt = $conn->prepare($avg_mood_sql);
$avg_stmt->bind_param("is", $user_id, $start_date);
$avg_stmt->execute();
$avg_result = $avg_stmt->get_result();
$dominant_mood = $avg_result->fetch_assoc()['mood'] ?? 'Unknown';

echo json_encode([
    'mood_distribution' => [
        'labels' => $mood_labels,
        'data' => $mood_data,
        'colors' => $mood_colors
    ],
    'daily_entries' => [
        'labels' => $dates,
        'data' => $daily_counts
    ],
    'weekly_entries' => [
        'labels' => $week_labels,
        'data' => $week_counts
    ],
    'stats' => [
        'streak' => $streak,
        'total_entries' => $total_entries,
        'dominant_mood' => $dominant_mood
    ]
]);
?>
