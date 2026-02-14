<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin-login.php");
    exit();
}
include 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Admin Dashboard</h2>
<a href="logout.php" class="btn btn-danger float-end">Logout</a>

<table class="table table-striped table-hover mt-3">
<tr>
<th>ID</th>
<th>Department</th>
<th>Title</th>
<th>Description</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM complaints");

while($row = $result->fetch_assoc()){
?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['department']; ?></td>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['description']; ?></td>
<td>
<span class="badge bg-<?php
if($row['status']=="Pending") echo "warning text-dark";
elseif($row['status']=="In Progress") echo "info";
else echo "success";
?>">
<?php echo $row['status']; ?>
</span>
</td>
<td>
<form method="POST" action="update.php" style="display:inline;">
<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
<select name="status">
<option>Pending</option>
<option>In Progress</option>
<option>Resolved</option>
</select>
<button type="submit" class="btn btn-sm btn-primary">Update</button>
</form>

<a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
</td>
</tr>
<?php } ?>

</table>

</body>
</html>
