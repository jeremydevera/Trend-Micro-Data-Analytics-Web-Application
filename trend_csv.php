
<?php 
	session_start();
	$conn = mysqli_connect("localhost", "root", "", "jeremy_db");
	$query = "SELECT * FROM jeremy_table_trend $_SESSION[current_query] ORDER BY id desc";
	$result = mysqli_query($conn, $query);
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename=SHA1 VSDT.csv');
	echo "DATE SOURCED, SHA1,SUGGESTED NAME, VSDT, TRENDX, FALCON, NOTES, MTF\r\n";
	while($row = $result->fetch_assoc()) {
		echo $row["date_sourced"] . "," . $row["sha1"] . "," . $row["suggested"] ."," . $row["vsdt"] . "," . $row["trendx"] . ",". $row["falcon"] ."," . $row["notes"] . "," . $row["mtf"] ."\r\n" ;
		}
	mysqli_close($conn);

?>

