<?php
	include 'pass.php';
	if(isset($_POST['delete_many'])){
		$_SESSION['id_array'] = $_POST['check_box'];
		header("Location:delete_history_many_verify.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>CI - Samples History</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<style>
			.row.content {
				height: 1500px
			}
			.sidenav {
				background-color: #263643 ;
				height: 100%;
				position: fixed;
			}
			@media screen and (max-width: 767px) {
				.row.content {height: auto;}
			}
		</style>
	</head>
	<body>
		<?php
			include 'navbar.php';
		?>
				<div class="col-sm-offset-2 col-sm-10">
					<h3 class="text-center">HISTORY</h3>
					<form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
					<button type="submit" class="btn btn-danger btn-sm" name="delete_many" data-toggle='tooltip' title='Delete Selected'><span class="glyphicon glyphicon-trash"></span> DELETE</button>
						<script>
							function selectAll() {
								var blnChecked = document.getElementById("select_all_invoices").checked;
								var check_invoices = document.getElementsByClassName("check_invoice");
								var intLength = check_invoices.length;
								for(var i = 0; i < intLength; i++) {
									var check_invoice = check_invoices[i];
									check_invoice.checked = blnChecked;
								}
							}
						</script>
						<?php
							$page = 0;

							if(isset($_POST['page_select'])){ //pag ngsearch ka ba o hndi
								$page = ($_POST['page']-1)*10;
							}

							$conn = mysqli_connect("localhost", "root", "", "charles_db");
							$query_count = "SELECT * FROM charles_table_history ORDER by id desc";
							$result_count = mysqli_query($conn, $query_count);
							$row_count = mysqli_num_rows($result_count);

							$query = "SELECT * FROM charles_table_history ORDER by id desc LIMIT $page, 10";
							$result = mysqli_query($conn, $query);

							// History Table Headers
							echo "
							<div class='table-responsive'>
								<table class='table table-hover'>
									<thead>
									<tr>
										<th><input type='checkbox' id='select_all_invoices' onclick='selectAll()' data-toggle='tooltip' title='Mark All'></th>
										<th></th>
										<th>SOURCE</th>
										<th>DATE SOURCED</th>
										<th>SHA1</th>
										<th>ADC</th>
										<th>OTHER DETECTION</th>
										<th>FILE DETECTION</th>
										<th>TRENDX</th>
										<th>TRIGGER</th>
										<th>PREVALENCE</th>
										<th>PATH</th>
										<th>ANALYZE</th>
										<th>DATE TESTED</th>
										<th>TESTER</th>
										<th style='padding: 0 120px 8px 0'>LOG</th>
										<th style='padding: 0 1200px 8px 0'>NOTES</th>
										</tr>
									</thead>
									<tbody>
										<tr>";
										while($row = mysqli_fetch_assoc($result)){
											echo "<td>" . "<input type='checkbox' name='check_box[]' value='$row[id]' id='myDIV' class='check_invoice' data-toggle='tooltip' title='Mark'>" . "</td><td>" .
											"<div class='dropdown'>
												<button class='btn btn-default dropdown-toggle btn-xs' type='button' data-toggle='dropdown'><span class='caret'></span></button>
												<ul class='dropdown-menu'>
												<li><a href='delete_history_verify.php?delete=$row[id]'>Delete</a></li>
												</ul>
											</div>" . "</td><td>"
											// History Table Rows
											. $row['source'] . "</td><td>" . $row['date_sourced'] . "</td><td>" . $row['sha1'] . "</td><td>" . $row['adc'] . "</td><td>" . $row['other_detection'] . "</td><td>" . $row['file_detection'] . "</td><td>" . $row['trendx'] . "</td><td>" . $row['trig'] . "</td><td align='center'>" . $row['prev'] . "</td><td>" . $row['path'] . "</td><td>"
											. $row['analyze_analyze'] . "</td><td>" . $row['date_tested'] . "</td><td>"  . $row['tester'] . "</td><td>" . $row['log'] . "</td><td>" . $row['notes'] . "</td><td>" . "</td></tr>";
										}
									echo "</tbody>";
								echo "</table>";
							echo "</div><br><br><br>";
							echo "<div class='col-sm-12'>";
								echo "<select name='page' class='btn btn-default btn-sm'>";
									echo "<option value='1'>Page</option>";
									for($p=1; $p<=ceil($row_count/10); $p++){
										echo "<option value='$p' $pick>$p</option>";
									}
								echo "</select>";
								echo "<button type='submit' class='btn btn-default btn-sm' name='page_select' data-toggle='tooltip' title='Submit Page'><span class='glyphicon glyphicon-ok'></span></button>";
								echo " Page " . ((($page)/10)+1) . " of " . ceil($row_count/10);
								echo " ($row_count Results)";
							echo "</div>";
						?>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>