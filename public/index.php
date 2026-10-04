<?php
$db = null;
$subscribe_message = isset($_GET['subscribed'])
    ? 'You are subscribed. I will use this list for page content, photo, and news updates.'
    : null;
$subscribe_error = null;

$request_host = strtolower((string) ($_SERVER['HTTP_HOST'] ?? ''));
$configured_environment = strtolower((string) (getenv('ENVIRONMENT') ?: ''));
$is_local = $configured_environment === 'local'
    || str_starts_with($request_host, 'localhost')
    || str_starts_with($request_host, '127.0.0.1');

$db_host = getenv('JERRY_DB_HOST') ?: ($is_local ? 'mysql' : 'localhost');
$db_name = getenv('JERRY_DB_NAME') ?: 'jerry_bil_jb';
$db_user = getenv('JERRY_DB_USER') ?: 'jerry_bil_jb';
$db_pass = getenv('JERRY_DB_PASS') ?: '!JB263e11';

try {
    $db = new PDO(
        "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

    $db->exec("CREATE TABLE IF NOT EXISTS visitors (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ip VARCHAR(45),
        country VARCHAR(100),
        city VARCHAR(100),
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS testimonials (
        id INT AUTO_INCREMENT PRIMARY KEY,
        text TEXT,
        author VARCHAR(100),
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS guestbook (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        message TEXT,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS subscribers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(190) NOT NULL UNIQUE,
        name VARCHAR(100),
        topics VARCHAR(255) NOT NULL DEFAULT 'page_content,photos,news',
        status ENUM('active','unsubscribed') NOT NULL DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subscribe'])) {
        $subscriber_name = trim($_POST['subscriber_name'] ?? '');
        $subscriber_email = filter_var(trim($_POST['subscriber_email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $allowed_topics = ['page_content', 'photos', 'news'];
        $selected_topics = array_values(array_intersect((array) ($_POST['topics'] ?? []), $allowed_topics));

        if (!$subscriber_email) {
            $subscribe_error = 'Please enter a valid email address.';
        } elseif (!$selected_topics) {
            $subscribe_error = 'Choose at least one update type.';
        } else {
            $topics = implode(',', $selected_topics);
            $stmt = $db->prepare("
                INSERT INTO subscribers (email, name, topics, status)
                VALUES (?, ?, ?, 'active')
                ON DUPLICATE KEY UPDATE
                    name = VALUES(name),
                    topics = VALUES(topics),
                    status = 'active'
            ");
            $stmt->execute([$subscriber_email, $subscriber_name, $topics]);

            header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?') . '?subscribed=1#subscribe');
            exit;
        }
    }

    $visitor_ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    $visitor_country = 'Unknown';
    $visitor_city = 'Unknown';
    $geo_context = stream_context_create([
        'http' => [
            'timeout' => 1.5,
            'user_agent' => 'jerrybilous.ca visitor logger',
        ],
    ]);
    $geo_response = @file_get_contents("https://ipapi.co/{$visitor_ip}/json/", false, $geo_context);

    if ($geo_response !== false) {
        $geo = json_decode($geo_response, true);
        if (is_array($geo)) {
            $visitor_country = $geo['country_name'] ?? 'Unknown';
            $visitor_city = $geo['city'] ?? 'Unknown';
        }
    }

    $stmt = $db->prepare('INSERT INTO visitors (ip, country, city) VALUES (?, ?, ?)');
    $stmt->execute([$visitor_ip, $visitor_country, $visitor_city]);
} catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage());
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subscribe'])) {
        $subscribe_error = 'Subscriptions are temporarily unavailable. Please try again later.';
    }
}

$life_timezone = new DateTimeZone('America/Toronto');
$birth_date = new DateTimeImmutable('1959-07-03', $life_timezone);
$today = new DateTimeImmutable('today', $life_timezone);
$minimum_target_date = $birth_date->modify('+100 years');
$days_remaining = max(
    0,
    $today->diff($minimum_target_date)->invert
        ? 0
        : $today->diff($minimum_target_date)->days
);

$latest_notes_file = __DIR__ . '/assets/latest_notes.json';
$latest_notes = [];
if (is_file($latest_notes_file)) {
    $decoded_notes = json_decode((string) file_get_contents($latest_notes_file), true);
    if (is_array($decoded_notes)) {
        $latest_notes = array_slice($decoded_notes, 0, 3);
    }
}

$forsale_items_file = __DIR__ . '/assets/forsale_items.json';
$has_forsale_items = false;
if (is_file($forsale_items_file)) {
    $forsale_items = json_decode((string) file_get_contents($forsale_items_file), true);
    if (is_array($forsale_items)) {
        foreach ($forsale_items as $item) {
            if (is_array($item) && !empty($item['available']) && empty($item['sample'])) {
                $has_forsale_items = true;
                break;
            }
        }
    }
}

require __DIR__ . '/home.php';
