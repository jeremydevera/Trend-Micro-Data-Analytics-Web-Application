<?php
  include 'pass.php';
?>
	
<?php
	include_once 'pass.php';
	$conn = mysqli_connect("localhost", "root", "", "charles_db");
	if(isset($_GET['delete'])){
		$id = $_GET['delete'];
		$query = " DELETE FROM charles_table_users WHERE id='$id' ";
		$result = mysqli_query($conn, $query);
	}
	header('Location:users.php');
	
?>