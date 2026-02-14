<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $department = $_POST['department'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO complaints (department, title, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $department, $title, $description);
    $stmt->execute();

    echo "<div class='container mt-5'>";
    echo "<div class='alert alert-success'>";
    echo "Complaint Submitted Successfully!<br>";
    echo "Your Complaint ID: <strong>".$stmt->insert_id."</strong>";
    echo "</div>";
    echo "<a href='index.php' class='btn btn-primary'>Back Home</a>";
    echo "</div>";
}
?>


