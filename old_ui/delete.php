<?php
	include_once 'pass.php';
	if(isset($_GET['delete']) && $_SESSION['username']){
		$conn = mysqli_connect("localhost", "root", "", "charles_db");
		$id = $_GET['delete'];
		$query = " DELETE FROM charles_table_primary WHERE id='$id' ";
		$result = mysqli_query($conn, $query);
		echo mysqli_error($conn);
		echo '<script type="text/javascript">'; 
        echo 'alert("Succesfully Deleted!");'; 
        echo 'window.location.href = "index.php";';
        echo '</script>';
	}else{
		header('Location:index.php');
	}
	
	
?>