<?php
// save.php — Horse Race winner logger
// Place this file in the same directory as horse_race.html on your PHP server.

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// ── Sanitize input ────────────────────────────────────────────
$winner = isset($_POST['winner']) ? trim($_POST['winner']) : '';

if (empty($winner)) {
    http_response_code(400);
    echo json_encode(["error" => "No winner provided"]);
    exit;
}

// Allow only safe values like "Horse 1" … "Horse 7"
if (!preg_match('/^Horse [1-9][0-9]?$/', $winner)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid winner value"]);
    exit;
}

// ── Database connection ───────────────────────────────────────
$conn = new mysqli("localhost", "root", "", "horse_race");

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "DB connection failed: " . $conn->connect_error]);
    exit;
}

// ── Prepared statement (prevents SQL injection) ───────────────
$stmt = $conn->prepare("INSERT INTO winners (name) VALUES (?)");
$stmt->bind_param("s", $winner);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "winner" => $winner]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Insert failed: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
