<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Track Complaint</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
<div class="card p-4 shadow">
<h3 class="text-center">Track Complaint</h3>

<form method="POST">
<input type="number" name="complaint_id" placeholder="Enter Complaint ID" required class="form-control mb-3">
<button type="submit" class="btn btn-primary w-100">Track</button>
</form>

<?php
if(isset($_POST['complaint_id'])){
    $cid = $_POST['complaint_id'];

    $stmt = $conn->prepare("SELECT * FROM complaints WHERE id=?");
    $stmt->bind_param("i", $cid);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        echo "<div class='alert alert-info mt-3'>";
        echo "<strong>Department:</strong> ".$row['department']."<br>";
        echo "<strong>Title:</strong> ".$row['title']."<br>";
        echo "<strong>Status:</strong> ".$row['status'];
        echo "</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Invalid Complaint ID!</div>";
    }
}
?>

</div>
</div>

</body>
</html>
