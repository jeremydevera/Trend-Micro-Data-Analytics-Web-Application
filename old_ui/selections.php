<html>
    <head>
		<title>CI - Database Selections</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">
		<script src = "https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<style>
			.sidenav {
				background-color: #263643;
				height: 100%;
				position: fixed;
			}
			@media screen and (max-width: 767px) {
				.row.content {height: auto;}
			}
		</style>
    </head>

    <?php
		session_start();
		if(isset($_POST['save_button'])){
			$_SESSION['id_array'] = $_POST['check_box'];
			header("Location:save_settings.php");
		}
    ?>

    <body style="background-color: #e8f3ff; overflow-y: hidden;">
        <?php
          include 'navbar.php';
        ?>
        <br>

                <div class="col-sm-offset-2 col-sm-10">
                    <div>
                    <div style="padding: 20px;">
                        <br><br>
                        <div style="margin-top: -6%;" class="ui form">
                            <div class="three fields">
                                <div class="field">
                                    <div style="padding: 20px; height: 95%" class="container ui segment">
                                        <h1 style="text-align: center; margin-top: 10px;" class="ui dividing header">MANAGE SOURCE</h1><br><br>
                                        <?php
											$page = 0;

											if(isset($_POST['page_select'])){ //pag ngsearch ka ba o hndi
												$page = ($_POST['page']-1)*10;
											}

											$conn = mysqli_connect("localhost", "root", "", "charles_db");
											$query_count = "SELECT * FROM charles_table_source ORDER by id desc";
											$result_count = mysqli_query($conn, $query_count);
											$row_count = mysqli_num_rows($result_count);

											$query = "SELECT * FROM charles_table_source ORDER by id desc LIMIT $page, 10";
											$result = mysqli_query($conn, $query);
											echo "
											<div style='height: 80%;' class='table-responsive'>
												<table class='table table-hover'>
													<thead>
													<tr>
														<th></th>
														<th>NAME</th>
														</tr>
													</thead>
													<tbody>
													<tr>";
											while($row = mysqli_fetch_assoc($result)){
												echo "<td>" .
												"<div class='dropdown'>
													<button class='btn btn-default dropdown-toggle btn-xs' type='button' data-toggle='dropdown'>Options <span class='caret'></span></button>
													<ul class='dropdown-menu'>
													<li><a href='update_source.php?update=$row[id]'>Update</a></li>
													<li><a href='delete_source.php?delete=$row[id]'>Delete</a></li>
													</ul>
												</div>" . "</td><td>"
												. $row['name'] . "</td><td>" . "</td></tr>";
											}
											echo "</tbody></table></div>";
											echo "<br><br><br>";
											echo "</form>";
                                        ?>
                                        <a class="ui green button" href="create_source.php" id="create_button"  style="font-size: 100%; position: absolute; bottom: 20px;">
                                            <i class="check icon"></i> CREATE
                                        </a>
                                    </div>
                                </div>
                                <div class="field">
                                    <div style="padding: 20px; height: 95%" class="container ui segment">
                                        <h1 style="text-align: center; margin-top: 10px;" class="ui dividing header">MANAGE ADC</h1><br><br>
                                        <?php
											$page = 0;

											if(isset($_POST['page_select'])){ //pag ngsearch ka ba o hndi
												$page = ($_POST['page']-1)*10;
											}

											$conn = mysqli_connect("localhost", "root", "", "charles_db");
											$query_count = "SELECT * FROM charles_table_adc ORDER by id desc";
											$result_count = mysqli_query($conn, $query_count);
											$row_count = mysqli_num_rows($result_count);

											$query = "SELECT * FROM charles_table_adc ORDER by id desc LIMIT $page, 10";
											$result = mysqli_query($conn, $query);

											echo "
											<div style='height: 80%;' class='table-responsive'>
												<table class='table table-hover'>
													<thead>
													<tr>
														<th></th>
														<th>NAME</th>
														</tr>
													</thead>
													<tbody>
													<tr>";
											while($row = mysqli_fetch_assoc($result)){
												echo "<td>" .
												"<div class='dropdown'>
													<button class='btn btn-default dropdown-toggle btn-xs' type='button' data-toggle='dropdown'>Options <span class='caret'></span></button>
													<ul class='dropdown-menu'>
													<li><a href='update_adc.php?update=$row[id]'>Update</a></li>
													<li><a href='delete_adc.php?delete=$row[id]'>Delete</a></li>
													</ul>
												</div>" . "</td><td>"
												. $row['name'] . "</td><td>" . "</td><td>"
												. "</td></tr>";
											}
											echo "</tbody></table></div>"; //kaya nandto ung form para masakop ung check box sa tables
											echo "<br><br><br>";
											echo "</form>";
                                        ?>
                                        <a class="ui green button" href="create_adc.php" id="create_button"  style="font-size: 100%; position: absolute; bottom: 20;">
                                            <i class="check icon"></i> CREATE
                                        </a>
                                    </div>
                                </div>
                                <div class="field">
                                    <div style="padding: 20px; height: 95%" class="container ui segment">
                                        <h1 style="text-align: center; margin-top: 10px;" class="ui dividing header">MANAGE TRIGGER</h1><br><br>
                                        <?php
											$page = 0;

											if(isset($_POST['page_select'])){ //pag ngsearch ka ba o hndi
												$page = ($_POST['page']-1)*10;
											}

											$conn = mysqli_connect("localhost", "root", "", "charles_db");
											$query_count = "SELECT * FROM charles_table_trig ORDER by id desc";
											$result_count = mysqli_query($conn, $query_count);
											$row_count = mysqli_num_rows($result_count);

											$query = "SELECT * FROM charles_table_trig ORDER by id desc LIMIT $page, 10";
											$result = mysqli_query($conn, $query);
											echo "
											<div style='height: 80%;' class='table-responsive'>
												<table class='table table-hover'>
													<thead>
													<tr>
														<th></th>
														<th>NAME</th>
														</tr>
													</thead>
													<tbody>
													<tr>";
											while($row = mysqli_fetch_assoc($result)){
												echo "<td>" .
												"<div class='dropdown'>
													<button class='btn btn-default dropdown-toggle btn-xs' type='button' data-toggle='dropdown'>Options <span class='caret'></span></button>
													<ul class='dropdown-menu'>
													<li><a href='update_trigger.php?update=$row[id]'>Update</a></li>
													<li><a href='delete_trigger.php?delete=$row[id]'>Delete</a></li>
													</ul>
												</div>" . "</td><td>"
												. $row['name'] . "</td><td>" . "</td></tr>";
											}
											echo "</tbody></table></div>";
											echo "<br><br><br>";
											echo "</form>";

                                        ?>
                                        <a class="ui green button" href="create_trigger.php" id="create_button"  style="font-size: 100%; position: absolute; bottom: 20;">
                                            <i class="check icon"></i> CREATE
                                        </a>
                                    </div>
                                </div>
                            </div><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
