<?php 
	session_start();
	if(!isset($_SESSION['username'])){
		echo '<script type="text/javascript">'; 
		echo 'alert("Not Logged In!");'; 
		echo 'window.location.href = "adc.php";';
		echo '</script>';
	} else {
		$conn = mysqli_connect("localhost", "root", "", "charles_db");
		$conn2 = mysqli_connect("localhost", "root", "", "jeremy_db");
	}
?>