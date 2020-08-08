<?php include 'base.php' ?>

<?php
    $rpp = 10;
    $page = 1;
    if(isset($_GET['rpp'])) {
        $_SESSION['history_rpp'] = $_GET['rpp'];
    }
    if(isset($_SESSION['history_rpp'])) {
        $rpp = $_SESSION['history_rpp'];
    }
    if(isset($_GET['page'])) {
        $page = $_GET['page'];
    }
    $_SESSION['current_query'] = "";
    $conn = mysqli_connect("localhost", "root", "", "charles_db");
    $query_count = " SELECT * FROM charles_table_history ORDER by id desc ";
    $result_count = mysqli_query($conn, $query_count);
    $total = mysqli_num_rows($result_count);
    $temp = ($page-1)*$rpp;
    $query = " SELECT * FROM charles_table_history ORDER by id desc LIMIT $temp, $rpp ";
    $page_result = mysqli_query($conn, $query);
?>

<?php startblock('extrastyle') ?>
    <link rel="stylesheet" type="text/css" href="static/css/index.css">
    <script src="static/js/index.js"></script>
    <title>CI - Samples Index</title>

    <style>
        html {
            /* padding: 20px; */
            /* background-color: rgba(255, 210, 210, 0.692); */
            background-color: rgba(182, 225, 253, 0.493);
            /* rgba(206, 206, 206, 0.322); */
        }

        body {
            /* background-color: rgba(122, 47, 47, 0); */
            background-color: rgba(17, 58, 97, 0);
            padding: 10px;
        }
    </style>

    <script>
        $(document).ready(function () {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                event.preventDefault();
                return false;
                }
            });
            $('#history_navbar').addClass("active");
            $('#create_sample').click(function () {
                $('#modal_create').modal({autofocus: false, observeChanges: true,}).modal('show');
            });
            $('#filter_sample').click(function () {
                $('#modal_filter').modal({autofocus: false, observeChanges: true,}).modal('show');
            });
            $('#cancel_filter').click(function () {
                $('#modal_filter').modal('hide');
            });
            $('.cancel_button').click(function () {
                $('.ui.modal').modal('hide');
            });
        });
    </script>
<?php endblock() ?>

<?php startblock('body') ?>
    <div style="width: 100%; margin-top: 0%;" class="ui segment container" >
        <div class="main">
            <div style="text-align: center;" class="inline-buttons"><h1> HISTORY DATA </h1></div><br>
            <?php
                if(isset($_SESSION['username'])) {
                    echo '<button class="ui small red button" onclick="delete_history(\'open\')"><i class="trash alternate outline icon"></i> DELETE</button><br><br>';
                } else {
                    echo '<button class="ui small red button modal_trigger" data-target="#modal_login"><i class="plus icon"></i> DELETE</button><br><br';
                }
            ?>
            <div class="container-fluid" id="data_table">
                <div id="outer"><div id="inner1"><div id="inner2"><div id="inner2top"></div><div id="inner2bottom">
                    <table class="ui celled stackable table" style="overflow:visible;">
                        <thead><tr>
                            <th style="text-align: center;"><input class="ui checkbox" type="checkbox" id="select_all" onclick="selectAll()"></th>
                            <th style="text-align: center;">SOURCE</th>
                            <th style="text-align: center;">DATE SOURCED</th>
                            <th style="text-align: center;">SHA1</th>
                            <th style="text-align: center;">ADC</th>
                            <th style="text-align: center;">OTHER DETECTION</th>
                            <th style="text-align: center;">FILE DETECTION</th>
                            <th style="text-align: center;">TRENDX</th>
                            <th style="text-align: center;">TRIGGER</th>
                            <th style="text-align: center;">PREVALENCE</th>
                            <th style="text-align: center;">PATH</th>
                            <th style="text-align: center;">ANALYZE</th>
                            <th style="text-align: center;">DATE TESTED</th>
                            <th style="text-align: center;">TESTER</th>
                            <th style="text-align: center;">LOG</th>
                            <th style="text-align: center;">NOTES</th>
                        </tr></thead>
                        <tbody style="font-size: 105%;">
                            <?php while($row = mysqli_fetch_assoc($page_result)) { ?>
                                <tr>
                                    <td><input class="ui checkbox" type="checkbox" name="check_box" value="<?php echo $row['id'] ?>"></td>
                                    <td nowrap title="Source"><?php echo $row['source'] ?></td>
                                    <td nowrap title="Date Sourced"><?php echo $row['date_sourced'] ?></td>
                                    <td nowrap title="SHA-1"><?php echo $row['sha1'] ?></td>
                                    <td nowrap title="ADC"><?php echo $row['adc'] ?></td>
                                    <td nowrap title="Other Detection"><?php echo $row['other_detection'] ?></td>
                                    <td nowrap title="File Detection"><?php echo $row['file_detection'] ?></td>
                                    <td nowrap title="TrendX"><?php echo $row['trendx'] ?></td>
                                    <td nowrap title="Trigger"><?php echo $row['trig'] ?></td>
                                    <td nowrap title="Prevalence" style="text-align: center;"><?php echo $row['prev'] ?></td>
                                    <td nowrap title="Path"><?php echo $row['path'] ?></td>
                                    <td nowrap title="Analyze" style="text-align: center;"><?php echo $row['analyze_analyze'] ?></td>
                                    <td nowrap title="Date Tested"><?php echo $row['date_tested'] ?></td>
                                    <td nowrap title="Tester"><?php echo $row['tester'] ?></td>
                                    <td nowrap title="Log"><?php echo $row['log'] ?></td>
                                    <td nowrap title="Notes"><?php echo $row['notes'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div></div></div></div>
            </div>
            <div id="page" class="ui menu">
                <div class="item">
                    Total results: <?php echo $total ?>
                </div>
                <div class="right menu">
                    <div class="item">
                        <div class="ui input" style="margin-top: 5px;">
                            Showing
                            <input type="text" style="margin-top: -10px; margin-left: 10px; margin-right: 10px; width: 50px;" id="rpp" value="<?php echo $rpp ?>">
                            per page
                        </div>
                    </div>
                    <div class="item">
                        <div class="ui right floated pagination menu">
                            <a class="icon item" onclick="change_page(0)"><i class="angle double left icon"></i></a>
                            <a class="icon item" onclick="change_page(-1)"><i class="angle left icon"></i></a>
                            <div style="padding: 0px;" class="ui form item">
                                <div class="field">
                                    <select class="ui search large fluid dropdown" onchange="change_page(this.value)">
                                        <option value=""><?php echo $page; ?> / <?php echo ceil($total/$rpp); ?></option>
                                        <?php for($p=1; $p<=ceil($total/$rpp); $p++) { ?>
                                            <?php
                                                if(($p < 10*ceil($page/10 - 1) + 10 and $p > 10*ceil($page/10 - 1)) or $p%10 == 0) {
                                                    echo '<option>' . $p . '</option>';
                                                }
                                            ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <a class="icon item" onclick="change_page(-2)">
                                <i class="angle right icon"></i>
                            </a>
                            <a class="icon item" onclick="change_page(-3)">
                                <i class="angle double right icon"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ui mini modal" id="modal_confirm">
        <i class="close icon"></i>
        <div class="header" style="text-align: center;">Confirm Delete</div>
        <div class="content">
            <form class="ui form" method="post" action="history_delete.php" id="form_del_history">
                <input type="hidden" id="sample_ids" name="sample_ids" value="">
                <div style="text-align: center;" class="field">
                    <div class="ui labeled input">
                        <div class="ui grey label">Your Password : </div>
                        <input type="password" name="password" id="history_delete" placeholder="Password" required>
                    </div>
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui red button" onclick="$('.ui.modal').modal('hide')">
                <i class="thumbs down outline icon"></i> Cancel
            </button>
            <button class="ui blue button" id="del_butt" onclick="delete_history('submit')">
                <i class="thumbs up outline icon"></i> Submit
            </button>
        </div>
    </div>
<?php endblock() ?>

<?php startblock('extrascripts') ?>
    <script>
        var rpp_input = document.getElementById("rpp");
        rpp_input.addEventListener("keydown", function (e) {
            if (e.keyCode === 13) {
                window.location.href = "history.php?rpp=" + rpp_input.value;
            }
        });
        var hist_del = document.getElementById("history_delete");
        hist_del.addEventListener("keydown", function (e) {
            if (e.keyCode === 13) {
                document.getElementById('del_butt').click();
            }
        });

        function change_page(next) {
            if(next == 0) {
                temp = 1;
            } else if(next == -3) {
                temp = <?php echo ceil($total/$rpp); ?>;
            } else if(next == -1) {
                if(<?php echo $page; ?> + next < 1) {
                    temp = 1;
                } else {
                    temp = <?php echo $page; ?> + next;
                }
            } else if(next == -2) {
                next = 1;
                if(<?php echo $page; ?> + next > <?php echo ceil($total/$rpp); ?>) {
                    temp = <?php echo ceil($total/$rpp); ?>;
                } else {
                    temp = <?php echo $page; ?> + next;
                }
            } else {
                temp = next;
            }
            window.location.href = "history.php?page=" + temp; 
        }

        function delete_history(type) {var x = document.getElementsByName("check_box");
            id_string = "";
            for(var i = 0; i < x.length; i++) {
                if(x[i].checked) {
                    id_string += x[i].value + ",";
                }
            }
            if(id_string == "") alert("Nothing Selected!");
            else if(type == 'open') $('#modal_confirm').modal({autofocus: true,}).modal('show');
            else if(type == 'submit') {
                <?php
                    $user = "SELECT * FROM charles_table_users WHERE username='" . $_SESSION['username'] . "'";
                    $user = mysqli_query($conn, $user);
                    $user = mysqli_fetch_assoc($user);
                    $password = $user['password'];
                ?>
                var x = document.getElementById("history_delete").value;
                if(x != "<?php echo $password ?>") {
                    $.uiAlert({
                        textHead: "Wrong Password!",
                        text: 'Enter correct password to proceed',
                        bgcolor: '#DB2828',
                        textcolor: '#fff',
                        position: 'top-center',
                        icon: 'remove circle',
                        time: 1,
                    });
                } else {
                    id_string = id_string.slice(0, -1);
                    document.getElementById('sample_ids').setAttribute('value', id_string);
                    document.getElementById('form_del_history').submit();
                }
            }
        }
    </script>
<?php endblock() ?>