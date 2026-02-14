<!DOCTYPE html>
<html>
<head>
<title>File Complaint</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
<div class="card shadow p-4">
<h2 class="text-center mb-4">Submit Complaint</h2>

<form action="submit.php" method="POST">
<input type="text" name="department" placeholder="Department" required class="form-control mb-3">
<input type="text" name="title" placeholder="Title" required class="form-control mb-3">
<textarea name="description" placeholder="Description" required class="form-control mb-3"></textarea>

<button type="submit" class="btn btn-success w-100">Submit</button>
</form>

</div>
</div>

</body>
</html>
