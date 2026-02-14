<?php
session_start();
include 'config.php';

if(isset($_POST['login'])){
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // basic validation
    if($username === '' || $password === ''){
        $error = "Please provide username and password.";
    } else {
        // select only the password column to avoid fetching unnecessary data
        $stmt = $conn->prepare("SELECT password FROM admin WHERE username=? LIMIT 1");
        if(!$stmt){
            // prepare failed (DB issue)
            $error = "Database error (prepare failed).";
        } else {
            $stmt->bind_param("s", $username);
            $stmt->execute();

            // get password whether get_result exists or not
            $db_password = null;
            if(method_exists($stmt, 'get_result')){
                $res = $stmt->get_result();
                if($res && $res->num_rows > 0){
                    $row = $res->fetch_assoc();
                    $db_password = $row['password'];
                }
            } else {
                // fallback when mysqlnd/get_result is not available
                $stmt->bind_result($db_password);
                $stmt->fetch();
            }

            if($db_password !== null){
                // support hashed passwords and legacy plain-text (fallback)
                if(password_verify($password, $db_password) || hash_equals($db_password, $password)){
                    session_regenerate_id(true);
                    $_SESSION['admin'] = $username;
                    header("Location: admin.php");
                    exit();
                }
            }

            $error = "Invalid Login!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark">

<div class="container mt-5">
<div class="card p-4 col-md-5 mx-auto">
<h3 class="text-center">Admin Login</h3>

<?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

<form method="POST">
<input type="text" name="username" placeholder="Username" required class="form-control mb-3">
<input type="password" name="password" placeholder="Password" required class="form-control mb-3">
<button type="submit" name="login" class="btn btn-danger w-100">Login</button>
</form>

</div>
</div>

</body>
</html>
