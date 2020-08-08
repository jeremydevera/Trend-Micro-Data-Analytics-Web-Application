<?php include 'base.php' ?>

<?php
    $rpp = 10;
    $page = 1;
    if(isset($_GET['rpp'])) {
        $_SESSION['trendx_rpp'] = $_GET['rpp'];
    }
    if(isset($_SESSION['trendx_rpp'])) {
        $rpp = $_SESSION['trendx_rpp'];
    }
    if(isset($_GET['page'])) {
        $page = $_GET['page'];
    }
    $_SESSION['current_query'] = "";
    $conn = mysqli_connect("localhost", "root", "", "jeremy_db");
    $query_count = " SELECT * FROM jeremy_table_trend ORDER by id desc ";
    $result_count = mysqli_query($conn, $query_count);
    $total = mysqli_num_rows($result_count);
    $temp = ($page-1)*$rpp;
    $query = " SELECT * FROM jeremy_table_trend ORDER by date_sourced desc LIMIT $temp, $rpp ";
    $page_result = mysqli_query($conn, $query);
    if(isset($_GET['update_id'])) {
        $update_id = $_GET['update_id'];
        $update_id = " SELECT * FROM jeremy_table_trend WHERE id='$update_id' ";
        $update_id = mysqli_query($conn, $update_id);
        $update_id = mysqli_fetch_assoc($update_id);
    }
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
            $('#home_navbar').addClass("active");
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
            var this_rpp = document.getElementById("rpp");
            this_rpp.addEventListener("keydown", function (e) {
                if (e.keyCode === 13) {
                    window.location.href = "index.php?rpp=" + this_rpp.value;
                }
            });
        });
    </script>
<?php endblock() ?>



<?php startblock('body') ?>
    <div style="width: 100%; margin-top: 0%;" class="ui segment container" >
        <div class="main">
            <div style="text-align: center;" class="inline-buttons">
                <div class="column">
                    <h1> TREND DATA </h1>
                    <?php
                        if(isset($_SESSION['username'])) {
                            echo '<a class="ui small blue button" onclick="options_many(\'update\')"><i class="edit outline icon"></i> EDIT</a>';
                        } else {
                            echo '<button class="ui small blue button modal_trigger" data-target="#modal_login"><i class="edit outline icon"></i> EDIT</button>';
                        }
                    ?>
                    <?php
                        if(isset($_SESSION['username'])) {
                            echo '<a class="ui small red button" onclick="options_many(\'delete\')"><i class="trash alternate outline icon"></i> DELETE</a>';
                        } else {
                            echo '<button class="ui small red button modal_trigger" data-target="#modal_login"><i class="trash alternate outline icon"></i> DELETE</button>';
                        }
                    ?>
                   
                    <a class="ui small orange button" href="trend_csv.php"><i class="download icon"></i> CSV</a>
                    <a class="ui small teal button" href="trendslice_overall.php" target="_blank"><i class="chart pie icon"></i> CHART</a>
                    <button class="ui small basic button" id="filter_sample"><i class="search icon"></i>  Filter</button> 
                </div>
            </div><br><br>
            
            <div class="container-fluid" id="data_table">
                <div id="outer"><div id="inner1"><div id="inner2"><div id="inner2top"></div><div id="inner2bottom">
                    <table class="ui celled stackable table" style="overflow:visible;">
                        <thead><tr>
                            <th style="text-align: center;"><input class="ui checkbox" type="checkbox" id="select_all" onclick="selectAll()"></th>
                            <th style="text-align: center; overflow:visible;">Options</th>
                            <th style="text-align: center;">DATE SOURCED</th>
                            <th style="text-align: center;">SHA1</th>
                            <th style="text-align: center;">SUGGESTED NAME</th>
                            <th style="text-align: center;">VSDT</th>
                            <th style="text-align: center;">TRENDX</th>
                            <th style="text-align: center;">FALCON</th>
                            <th style="text-align: center;">NOTES</th>
                            <th style="text-align: center;">MALWARE TRUE FAMILY</th>
                        </tr></thead>
                        <tbody style="font-size: 105%; text-align:center">
                            <?php while($row = mysqli_fetch_assoc($page_result)) { $currsamp_id = $row['id'];?>
                                <tr>
                                    <td><input class="ui checkbox" type="checkbox" name="check_box" value="<?php echo $row['id'] ?>"></td>
                                    <td onclick="$('#options_<?php echo $currsamp_id ?>').dropdown('show')" style="overflow: visible !important;"> 
                                        <div class="ui dropdown item" id="options_<?php echo $currsamp_id ?>">
                                            <i class="settings icon"></i><i class="dropdown icon"></i>
                                            <div class="menu">
                                                <?php
                                                    if(isset($_SESSION['username'])) {
                                                        $temp = $row['id'];
                                                        $ds = $row['date_sourced']; $sh = $row['sha1']; $sg = $row['suggested']; $vsdt = $row['vsdt']; $tx = $row['trendx']; $fa = $row['falcon'];  $mtf = $row['mtf']; $n = str_replace('\"', '\\\"', $row['notes']);
                                                        echo "<a class='item' style='color: black; width: 100%;' onclick='open_update(\"" . $temp . "\", \"" . $ds . "\", \"" . $sh . "\", \"" . $sg . "\", \"" . $vsdt . "\",  \"" . $tx . "\",\"" . $fa . "\",  \"" . $n . "\",  \"" . $mtf . "\")'>Update</a>";
                                                    } else {
                                                        echo '<a class="item modal_trigger" style="color: black; width: 100%;" data-target="#modal_login">Update</a>';
                                                    }
                                                ?>
                                                <?php
                                                    if(isset($_SESSION['username'])) {
                                                        $temp = $row['id']; $sha1 = $row['sha1'];
                                                        echo '<a class="item" style="color: black;" onclick="open_delete(\''.$temp.'\', \''.$sha1.'\', \'open\')">Delete</a>';
                                                    } else {
                                                        echo '<a class="item modal_trigger" style="color: black;" data-target="#modal_login">Delete</a>';
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td nowrap title="Date Sourced"><?php echo $row['date_sourced'] ?></td>
                                    <td nowrap title="SHA-1"><?php echo $row['sha1'] ?></td>
                                    <td nowrap title="Suggested"><?php echo $row['suggested'] ?></td>
                                    <td nowrap title="VSDT"><?php echo $row['vsdt'] ?></td>
                                    <td nowrap title="TrendX"><?php echo $row['trendx'] ?></td>
                                    <td nowrap title="Falcon"><?php echo $row['falcon'] ?></td>
                                    <td nowrap title="Notes"><?php echo $row['notes'] ?></td>
                                    <td nowrap title="Malware True Family"><?php echo $row['mtf'] ?></td>
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
                                                    
                <div class="item">
                    <form id = "myForm" class="ui input" enctype="multipart/form-data" method = "POST" action="trend_upload_csv.php" role = "form">
                            <input type = "file" name ="file" id="file" size = "150">
                            <!--<button class="ui small red button" type = "submit" class = "btn btn-default" name ="submit"  value = "submit">Upload CSV</button> -->
                            <input id="myBtn"  class="ui small red button" type = "submit" class = "btn btn-default"  name ="submit"  value = "Upload Raw CSV"   /> 
                    </form>
                </div>

                <div class="item">
                    <form id = "myForm2" class="ui input" enctype="multipart/form-data" method = "POST" action="trend_upload_updated_csv.php" role = "form">
                            <input type = "file" name ="file2" id="file2" size = "150">
                            <!--<button class="ui small red button" type = "submit" class = "btn btn-default" name ="submit"  value = "submit">Upload CSV</button> -->
                            <input id="myBtn2"  class="ui small red button" type = "submit" class = "btn btn-default"  name ="submit2"  value = "Upload Filtered CSV"   /> 
                    </form>
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

    <div class="ui modal" id="modal_filter">
        <i class="close icon"></i>
        <div class="header" style="text-align: center;">
            FILTER TREND
        </div>
        <div class="content">
            <form class="ui form" id="form_filter" method="post" action="trend_filter.php" style="text-align: center;">
                <div class="fields">
                    <div class="five wide field">
                        <label>FROM DATE SOURCED</label>
                        <input type="date" name="sourced_from" id="sourced_from" onchange="setmaxmin(this.value, 'sourced_to', 'min')">
                    </div>
                    <div class="five wide field">
                        <label>TO DATE SOURCED</label>
                        <input type="date" name="sourced_to" id="sourced_to" onchange="setmaxmin(this.value, 'sourced_from', 'max')">
                    </div>
                    
                    <div class="six wide field">
                        <label>VSDT</label>
                        <div class="ui left labeled input">
                            <select class="ui mini label dropdown" id="vsdt_eq" name="vsdt_eq">
                                <option value="">Choose</option>
                                <option value="eq">Equals</option>
                                <option value="neq">Not Equals</option>
                                <option value="contains">Contains</option>
                            </select>
                            <input type="text" class="filter_input" name="vsdt" placeholder="Vsdt" list="vsdt_options">
                            <datalist id="vsdt_options"><option value="None">None</option></datalist>
                        </div>
                    </div>
                </div>
                <div class="three fields">
                    <div class="eight wide field">
                        <label>SHA-1</label>
                        <input type="text" class="filter_input" name="sha1"  maxlength="40" minlength="40" placeholder="SHA-1">
                    </div>   
                    <style>.ui.selection.dropdown { min-width: 5 !important; }</style>
                    <div class="eight wide field">
                        <label>TRENDX</label>
                        <div class="ui left labeled input">
                            <select class="ui mini label dropdown" id="trendx_eq" name="trendx_eq">
                                <option value="">Choose</option>
                                <option value="eq">Equals</option>
                                <option value="neq">Not Equals</option>
                                <option value="contains">Contains</option>
                            </select>
                            <input type="text" class="filter_input" name="trendx" placeholder="Trenx" list="trendx_options">
                            <datalist id="trendx_options"><option value="None">None</option></datalist>
                        </div>
                    </div>
                </div>

                <div class="three fields">
                    <div class="eight wide field">
                        <label>NOTES</label>
                        <input type="text" class="filter_input" name="notes" placeholder="Notes">
                    </div>
                    <div class="eight wide field">
                        <label>MALWARE TRUE FAIMLY</label>
                        <div class="ui left labeled input">
                            <select class="ui mini label dropdown" id="mtf_eq" name="mtf_eq">
                                <option value="">Choose</option>
                                <option value="eq">Equals</option>
                                <option value="neq">Not Equals</option>
                                <option value="contains">Contains</option>
                            </select>
                            <input type="text" class="filter_input" name="mtf" placeholder="Mtf" list="mtf_options">
                            <datalist id="mtf_options"><option value="None">None</option></datalist>
                        </div>
                    </div>
                    
                </div>

                <div class="three fields">
                    <div class="eight wide field">
                        <label>SUGGESTED NAME</label>
                        <div class="ui left labeled input">
                            <select class="ui mini label dropdown" id="suggested_eq" name="suggested_eq">
                                <option value="">Choose</option>
                                <option value="eq">Equals</option>
                                <option value="neq">Not Equals</option>
                                <option value="contains">Contains</option>
                            </select>
                            <input type="text" class="filter_input" name="suggested" placeholder="Suggested" list="suggested_options">
                            <datalist id="suggested_options"><option value="None">None</option></datalist>
                        </div>
                    </div>
                    <div class="eight wide field">
                        <label>FALCON</label>
                        <div class="ui left labeled input">
                            <select class="ui mini label dropdown" id="falcon_eq" name="falcon_eq">
                                <option value="">Choose</option>
                                <option value="eq">Equals</option>
                                <option value="neq">Not Equals</option>
                                <option value="contains">Contains</option>
                            </select>
                            <input type="text" class="filter_input" name="falcon" placeholder="Falcon" list="falcon_options">
                            <datalist id="falcon_options"><option value="None">None</option></datalist>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
        <div class="actions">
            <a class="ui red button" href="index.php">
                <i class="redo alternate icon"></i> Clear
            </a>
            <button type="submit" form="form_filter" id="filter_submit" class="ui blue button">
                <i class="filter icon"></i> Filter
            </button>
        </div>
    </div>

    <div class="ui modal" id="modal_upload">
        <div class="header" style="text-align: center;">
            UPLOADING CSV PLEASE WAIT
        </div>
    </div >

    <div class="ui modal" id="modal_update">
        <div class="header" style="text-align: center;">
            UPDATE TREND
        </div>
        <div class="content">
            <form class="ui form" id="form_update" method="post" action="trend_update.php" style="text-align: center;">
                <input type="hidden" name="update_id" id="update_id">
                <div class="field">
                    <div class="fields">
                        <div class="four wide field">
                            <label>DATE SOURCED</label>
                            <input type="date" name="date_sourced" id="sourced_update" value="">
                        </div>
                        <div class="eight wide field">
                            <label>SHA-1</label>
                            <input type="text" name="sha1" id="sha1_update" maxlength="40" minlength="40" value="">
                        </div>
                        <div class="four wide field">
                            <label>VSDT</label>
                            <input type="text" name="vsdt" id="vsdt_update" value="">
                        </div>
                    </div>
                </div>
                <div class="three fields">
                    <div class="six wide field">
                        <label>TRENDX</label>
                        <input type="text" name="trendx" id="trendx_update" value="">
                    </div>
                    <div class="eight wide field">
                        <label>NOTES</label>
                        <input type="text" name="notes" id="notes_update" value=''>
                    </div>
                    <div class="six wide field">
                        <label>MALWARE TRUE FAMILY</label>
                        <input type="text" name="mtf" id="mtf_update" value=''>
                    </div>
                </div>

                <div class="three fields">
                    <div class="eight wide field">
                        <label>SUGGESTED NAME</label>
                        <input type="text" name="suggested" id="suggested_update" value="">
                    </div>
                    <div class="eight wide field">
                        <label>FALCON</label>
                        <input type="text" name="falcon" id="falcon_update" value=''>
                    </div>
                </div>
            </form>
        </div>
        <div class="actions">
            <a class="ui red button cancel_button">
                <i class="thumbs down outline icon"></i> Cancel
            </a>
            <button class="ui blue button" type="submit" form="form_update">
                <i class="thumbs up outline icon"></i> Submit
            </button>
        </div>
    </div>

    <div class="ui modal" id="modal_update_many">
        <div class="header" style="text-align: center;">
            UPDATE TREND BULK
        </div>
        <div class="content">
            <form class="ui form" id="form_update_many" method="post" action="trend_update_many.php" style="text-align: center;">
                <input type="hidden" name="update_ids" id="update_ids">
                <div class="field">
                    <div class="fields">
                        <div class="four wide field">
                            <label>DATE SOURCED</label>
                            <input type="date" name="date_sourced" id="sourced_update_many" value="">
                        </div>
                        <div class="eight wide field">
                            <label>SHA-1</label>
                            <div class="ui disabled input">
                                <input type="text" placeholder="SHA-1">
                            </div>
                        </div>
                        <div class="four wide field">
                            <label>VSDT</label>
                            <input type="text" name="vsdt" id="vsdt_update" value="">
                        </div>
                    </div>
                </div>
    
                <div class="three fields">
                    <div class="six wide field">
                        <label>TRENDX</label>
                        <input type="text" name="trendx" id="trendx_update_many" value=''>
                    </div>
                    <div class="eight wide field">
                        <label>NOTES</label>
                        <input type="text" name="notes" id="notes_update_many" value=''>
                    </div>
                    <div class="six wide field">
                        <label>MALWARE TRUE FAMILY</label>
                        <input type="text" name="mtf" id="mtf_update_many" value=''>
                    </div>
                </div>

                <div class="three fields">
                    <div class="eight wide field">
                        <label>SUGGESTED NAME</label>
                        <input type="text" name="suggested" id="suggested_update" value="">
                    </div>
                    <div class="eight wide field">
                        <label>FALCON</label>
                        <input type="text" name="falcon" id="falcon_update" value=''>
                    </div>
                </div>
            </form>
        </div>
        <div class="actions">
            <a class="ui red button cancel_button">
                <i class="thumbs down outline icon"></i> Cancel
            </a>
            <button class="ui blue button" type="submit" form="form_update_many">
                <i class="thumbs up outline icon"></i> Submit
            </button>
        </div>
    </div>

    <div class="ui tiny modal" id="modal_delete">
        <div class="header" id="delete_header" style="text-align: center;"></div>
        <div class="content">
            <form class="ui form" id="form_delete" method="post" action="trend_delete.php">
                <input type="hidden" name="delete_id" id="delete_id">
                <div style="text-align: center;" class="field">
                    <div class="ui labeled input">
                        <div class="ui grey label">Your Password : </div>
                        <input type="password" name="delete_password" id="delete_password" placeholder="Password" required>
                    </div>
                </div>
            </form>
        </div>
        <div class="actions">
            <a class="ui red button cancel_button">
                <i class="thumbs down outline icon"></i> Cancel
            </a>
            <button class="ui blue button" id="submit_delete"onclick="open_delete(1,1,'submit')">
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
                    window.location.href = "index.php?rpp=" + rpp_input.value;
                }
        });
        var del_pw = document.getElementById("delete_password");
            del_pw.addEventListener("keydown", function (e) {
                if (e.keyCode === 13) {
                    document.getElementById('submit_delete').click();
                }
        });
        var filterinputs = document.getElementsByClassName("filter_input");
            for(var i = 0; i < filterinputs.length; i++) {
                filterinputs[i].addEventListener("keydown", function (e) {
                    if (e.keyCode === 13) {
                        document.getElementById('filter_submit').click();
                    }
                });
        }
        var tested_date = new Date();
        var sourced_date = new Date();
        if(tested_date.getDay() == 1) sourced_date.setDate(tested_date.getDate() - 3);
        else sourced_date.setDate(tested_date.getDate() - 1);
        console.log(tested_date);
        console.log(sourced_date);
        sd = sourced_date.getDate();
        sm = sourced_date.getMonth();
        td = tested_date.getDate();
        tm = tested_date.getMonth();
        if(sd < 10) sd = '0' + sd;
        if(td < 10) td = '0' + td;
        if(sm < 10) sm = '0' + (sm+1);
        if(tm < 10) tm = '0' + (tm+1);
        console.log(sourced_date.getFullYear() + "-" + sm + "-" + sd);
        document.getElementById('create_sourced').setAttribute('value', sourced_date.getFullYear() + "-" + sm + "-" + sd);

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
            window.location.href = "index.php?page=" + temp; 
        }

        function setmaxmin(date, id, maxmin) {
            var x = document.getElementById(id);
            x.setAttribute(maxmin, date);
        }

        function options_many(type) {
            var x = document.getElementsByName("check_box");
            id_string = "";
            for(var i = 0; i < x.length; i++) {
                if(x[i].checked) id_string += x[i].value + ",";
            }
            if(id_string == "") alert("Nothing Selected!"); 
            else if(type == 'delete') {
                document.getElementById('delete_header').innerHTML = "Confirm Bulk Deletion";
                document.getElementById('delete_id').setAttribute('value', id_string);
                $('#modal_delete').modal({autofocus: true, observeChanges: true,}).modal('show');
            } else if(type == 'update') {
                document.getElementById('update_ids').setAttribute('value', id_string);
                $('#modal_update_many').modal({autofocus: false, observeChanges: true,}).modal('show');
            }
        }

        function open_update(id,sourced,sha1,suggested,vsdt,trendx,falcon,notes,mtf) {
            document.getElementById('update_id').setAttribute('value', id);
            document.getElementById('form_update').setAttribute('action', 'trend_update.php');
            document.getElementById('sourced_update').setAttribute('value', sourced);
            document.getElementById('sha1_update').setAttribute('value', sha1);
            document.getElementById('suggested_update').setAttribute('value', suggested);
            document.getElementById('vsdt_update').setAttribute('value', vsdt);
            document.getElementById('trendx_update').setAttribute('value', trendx);
            document.getElementById('falcon_update').setAttribute('value', falcon);
            document.getElementById('notes_update').setAttribute('value', notes);
            document.getElementById('mtf_update').setAttribute('value', mtf);
            $('#modal_update').modal({autofocus: false, observeChanges: true,}).modal('show');
        }

        function open_delete(id, sha1, req) {
            if(req == 'open') {
                document.getElementById('delete_header').innerHTML = "Deleting :  " + sha1;
                document.getElementById('delete_id').setAttribute('value', id);
                $('#modal_delete').modal({autofocus: true, observeChanges: true,}).modal('show');
            } else if(req == 'submit') {
                <?php
                    if(isset($_SESSION['username'])) {
                        $user = "SELECT * FROM jeremy_table_users WHERE username='" . $_SESSION['username'] . "'";
                        $user = mysqli_query($conn, $user);
                        $user = mysqli_fetch_assoc($user);
                        $password = $user['password'];
                    } else $password = "1234";
                ?>
                var x = document.getElementById("delete_password").value;
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
                    document.getElementById('form_delete').submit();
                }
            }
        }

        function create_check() {
            if(document.getElementById('create_source').selectedIndex == 0) document.getElementById('create_source').parentElement.classList.add("error");
            else document.getElementById('create_source').parentElement.classList.remove("error");
            if(document.getElementById('create_adc').selectedIndex == 0) document.getElementById('create_adc').parentElement.classList.add("error");
            else document.getElementById('create_adc').parentElement.classList.remove("error");
            if(document.getElementById('create_sha1').value == '') document.getElementById('create_sha1').parentElement.classList.add("error");
            else document.getElementById('create_sha1').parentElement.classList.remove("error");
            if(document.getElementById('create_source').selectedIndex != 0 && document.getElementById('create_adc').selectedIndex != 0 && document.getElementById('create_sha1').value != '') {
                document.getElementById('form_create').submit();
            } else {
                $.uiAlert({
                    textHead: "Incomplete Form!",
                    text: "Fill all required fields",
                    bgcolor: '#DB2828',
                    textcolor: '#fff',
                    position: 'top-center',
                    icon: 'remove circle',
                    time: 3,
                });
            }
        }
    </script>
<?php endblock() ?>

