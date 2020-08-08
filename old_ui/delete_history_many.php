<?php
	include_once 'pass.php';
	$conn = mysqli_connect("localhost", "root", "", "charles_db");
	$id = $_SESSION['id_array'];
	$end = count($id);
	if($_SESSION['username']){
		if($id && $end){
			for($i=0; $i<$end; $i++){
				$query = "DELETE FROM charles_table_history WHERE id='$id[$i]'";
				$result = mysqli_query($conn, $query);
			}
		}
		echo '<script type="text/javascript">'; 
        echo 'alert("Succesfully Deleted!");'; 
        echo 'window.location.href = "history.php";';
        echo '</script>';
	}	
	else{
		header("Location:history.php");
		}
?>