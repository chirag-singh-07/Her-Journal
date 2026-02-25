<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit;
}

$user_id = $_SESSION['user_id'];
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');

// Get all entries for the month
$start_date = "$year-$month-01";
$end_date = date('Y-m-t', strtotime($start_date));

$sql = "SELECT id, text, mood, entry_date, attachment_path FROM journal_entries 
        WHERE user_id = ? AND DATE(entry_date) BETWEEN ? AND ?
        ORDER BY entry_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $user_id, $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();

$entries_by_date = [];
while ($row = $result->fetch_assoc()) {
    $date = date('Y-m-d', strtotime($row['entry_date']));
    if (!isset($entries_by_date[$date])) {
        $entries_by_date[$date] = [];
    }
    $entries_by_date[$date][] = $row;
}

// Get mood color map
$mood_colors = [
    'Happy' => '#f472b6',
    'Calm' => '#10b981',
    'Energetic' => '#f59e0b',
    'Anxious' => '#64748b',
    'Sad' => '#3b82f6'
];

// Build calendar days
$first_day = date('w', strtotime($start_date));
$days_in_month = date('t', strtotime($start_date));
$days_prev_month = date('t', strtotime($start_date . ' -1 month'));

$calendar_days = [];

// Previous month days
for ($i = $first_day - 1; $i >= 0; $i--) {
    $day = $days_prev_month - $i;
    $prev_month = date('m', strtotime($start_date . ' -1 month'));
    $prev_year = date('Y', strtotime($start_date . ' -1 month'));
    $calendar_days[] = [
        'day' => $day,
        'date' => "$prev_year-$prev_month-$day",
        'is_other_month' => true,
        'entries' => []
    ];
}

// Current month days
for ($day = 1; $day <= $days_in_month; $day++) {
    $date = sprintf("%04d-%02d-%02d", $year, $month, $day);
    $is_today = ($date === date('Y-m-d'));
    $calendar_days[] = [
        'day' => $day,
        'date' => $date,
        'is_other_month' => false,
        'is_today' => $is_today,
        'entries' => $entries_by_date[$date] ?? []
    ];
}

// Next month days
$remaining = 42 - count($calendar_days); // 6 rows * 7 days
for ($i = 1; $i <= $remaining; $i++) {
    $next_month = date('m', strtotime($start_date . ' +1 month'));
    $next_year = date('Y', strtotime($start_date . ' +1 month'));
    $calendar_days[] = [
        'day' => $i,
        'date' => "$next_year-$next_month-$i",
        'is_other_month' => true,
        'entries' => []
    ];
}

echo json_encode([
    'year' => $year,
    'month' => $month,
    'month_name' => date('F', strtotime($start_date)),
    'calendar_days' => $calendar_days,
    'mood_colors' => $mood_colors
]);
?>
