
<?php 
	session_start();
	$conn = mysqli_connect("localhost", "root", "", "charles_db");
	$query = "SELECT * FROM charles_table_primary $_SESSION[current_query] ORDER BY id desc";
	$result = mysqli_query($conn, $query);
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename=ADC/Behavioral Module Internal Benchmarking.csv');
	echo "SOURCE, DATE SOURCED, SHA1, ADC, OTHER DETECTION, FILE DETECTION, TREND X, PREVALENCE, PATH, ANALYZE, DATE TESTED, TESTER, NOTES\r\n";
	while($row = $result->fetch_assoc()) {
		echo $row["source"] . "," . $row["date_sourced"] . "," . $row["sha1"] . "," . $row["adc"] . "," . $row["other_detection"] . "," . $row["file_detection"] . "," . $row["trendx"] . "," . $row["prev"] . "," . $row["path"] . "," . $row["analyze_analyze"] . "," . $row["date_tested"] . "," . $row["tester"] . "," . $row["notes"] . "\r\n" ;
		}
	mysqli_close($conn);

?>

