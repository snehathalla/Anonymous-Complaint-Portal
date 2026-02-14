<?php
// One-time admin password reset script.
// Usage (run locally only): http://localhost/hack/reset_admin.php?user=admin&pw=NewStrongP@ss

// Prevent running from remote hosts (basic check)
if(!in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1','::1'])){
    echo "Access denied. Run this script locally.";
    exit();
}

require 'config.php';

$user = $_GET['user'] ?? 'admin';
$pw = $_GET['pw'] ?? '';

if($pw === ''){
    echo "Usage: ?user=admin&pw=NewPassword";
    exit();
}

$hash = password_hash($pw, PASSWORD_DEFAULT);

// Try update first
$stmt = $conn->prepare("UPDATE admin SET password=? WHERE username=?");
$stmt->bind_param('ss', $hash, $user);
$stmt->execute();

if($stmt->affected_rows > 0){
    echo "Password updated for user: " . htmlspecialchars($user);
} else {
    // insert new admin if not exists
    $ins = $conn->prepare("INSERT INTO admin (username,password) VALUES (?, ?)");
    $ins->bind_param('ss', $user, $hash);
    if($ins->execute()){
        echo "Admin user created: " . htmlspecialchars($user);
    } else {
        echo "Failed to create or update admin. Error: " . htmlspecialchars($conn->error);
    }
}

echo "\nPlease delete this file after use for security.";
?>
