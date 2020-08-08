<?php include 'base.php' ?>

<?php
    $rpp = 10;
    $page = 1;
    if(isset($_GET['rpp'])) {
        $_SESSION['rpp'] = $_GET['rpp'];
    }
    if(isset($_SESSION['rpp'])) {
        $rpp = $_SESSION['rpp'];
    }
    if(isset($_GET['page'])) {
        $page = $_GET['page'];
    }
    $_SESSION['current_query'] = "";
    $conn = mysqli_connect("localhost", "root", "", "charles_db");
    $query_count = " SELECT * FROM charles_table_primary ORDER by id desc ";
    $result_count = mysqli_query($conn, $query_count);
    $total = mysqli_num_rows($result_count);
    $temp = ($page-1)*$rpp;
    $query = " SELECT * FROM charles_table_primary ORDER by id desc LIMIT $temp, $rpp ";
    $page_result = mysqli_query($conn, $query);
    if(isset($_GET['update_id'])) {
        $update_id = $_GET['update_id'];
        $update_id = " SELECT * FROM charles_table_primary WHERE id='$update_id' ";
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
            $('#adc_navbar').addClass("active");
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
                    window.location.href = "adc.php?rpp=" + this_rpp.value;
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
                    <h1> PRIMARY DATA </h1>
                    <?php
                        if(isset($_SESSION['username'])) {
                            echo '<button class="ui small green button" id="create_sample"><i class="plus icon"></i> CREATE</button>';
                        } else {
                            echo '<button class="ui small green button modal_trigger" data-target="#modal_login"><i class="plus icon"></i> CREATE</button>';
                        }
                    ?>
                    <div class="ui modal" id="modal_create">
                        <i class="close icon"></i>
                        <div class="header" style="text-align: center;">CREATE SAMPLE</div>
                        <div class="content">
                            <form class="ui form" id="form_create" method="post" action="sample_create.php" style="text-align: center;">
                                <div class="field">
                                    <div class="fields">
                                        <div class="four wide field">
                                            <label>SOURCE</label>
                                            <select class="ui fluid dropdown" id="create_source" name="source">
                                                <option value="">Choose Source</option>
                                                <?php $query = "SELECT * FROM charles_table_source"; ?>
                                                <?php $sources = mysqli_query($conn, $query); ?>
                                                <?php while($row = mysqli_fetch_assoc($sources)) { ?>
                                                    <option value="<?php echo $row['value']?>"><?php echo $row['value']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="four wide field">
                                            <label>DATE SOURCED</label>
                                            <input type="date" id="create_sourced" name="date_sourced">
                                        </div>
                                        <div class="eight wide field">
                                            <label>SHA-1</label>
                                            <input type="text" name="sha1" id="create_sha1" placeholder="SHA-1" maxlength="40" minlength="40" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="three fields">
                                    <div class="four wide field">
                                        <label>ADC</label>
                                        <select class="ui fluid dropdown" id="create_adc" name="adc">
                                            <option value="">Choose ADC</option>
                                            <?php $query = "SELECT * FROM charles_table_adc"; ?>
                                            <?php $adcs = mysqli_query($conn, $query); ?>
                                            <?php while($row = mysqli_fetch_assoc($adcs)) { ?>
                                                <option value="<?php echo $row['value']?>"><?php echo $row['value']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="six wide field">
                                        <label>OTHER DETECTION</label>
                                        <input type="text" name="other_detection" placeholder="Other Detection">
                                    </div>
                                    <div class="six wide field">
                                        <label>FILE DETECTION</label>
                                        <input type="text" name="file_detection" placeholder="File Detection">
                                    </div>
                                </div>
                                <div class="three fields">
                                    <div class="six wide field">
                                        <label>TRENDX</label>
                                        <input type="text" name="trendx" placeholder="Trenx">
                                    </div>
                                    <div class="six wide field">
                                        <label>TRIGGER</label>
                                        <select class="ui fluid dropdown" id="create_trigger" name="trigger">
                                            <option value="">Choose Trigger</option>
                                            <?php $query = "SELECT * FROM charles_table_trig"; ?>
                                            <?php $triggers = mysqli_query($conn, $query); ?>
                                            <?php while($row = mysqli_fetch_assoc($triggers)) { ?>
                                                <option value="<?php echo $row['name']?>"><?php echo $row['name']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="four wide field">
                                        <label>PREVALENCE</label>
                                        <input type="text" name="prevalence" placeholder="Prevalence">
                                    </div>
                                </div>
                                <div class="field">
                                    <label>PATH</label>
                                    <input type="text" name="path" placeholder="Path">
                                </div>
                                <div class="three fields">
                                    <div class="two wide field">
                                        <label>ANALYZE</label>
                                        <select class="ui fluid dropdown" id="create_analyze" name="analyze">
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                    </div>
                                    <div class="four wide field">
                                        <label>DATE TESTED</label>
                                        <input type="date" id="create_tested" name="date_tested">
                                    </div>
                                    <div class="eleven wide field">
                                        <label>NOTES</label>
                                        <input type="text" name="notes" placeholder="Notes">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="actions">
                            <button class="ui red button cancel_button">
                                <i class="thumbs down outline icon"></i> Cancel
                            </button>
                            <?php 
                                if(isset($_SESSION['username'])){
                                    echo '<button class="ui blue button" onclick="create_check()">';
                                    echo '    <i class="thumbs up outline icon"></i> Submit';
                                    echo '</button>';
                                } else {
                                    echo '<button class="ui blue button modal_trigger" data-target="#modal_login">';
                                    echo '    <i class="thumbs up outline icon"></i> Submit';
                                    echo '</button>';
                            }?>
                        </div>
                    </div>
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
                    <a class="ui small orange button" href="sample_csv.php"><i class="download icon"></i> CSV</a>
                    <a class="ui small teal button" href="sample_chart.php" target="_blank"><i class="chart pie icon"></i> CHART</a>
                    <button class="ui small basic button" id="filter_sample"><i class="search icon"></i>  Filter</button> 
                </div>
            </div><br><br>
            <div class="container-fluid" id="data_table">
                <div id="outer"><div id="inner1"><div id="inner2"><div id="inner2top"></div><div id="inner2bottom">
                    <table class="ui celled stackable table" style="overflow:visible;">
                        <thead><tr>
                            <th style="text-align: center;"><input class="ui checkbox" type="checkbox" id="select_all" onclick="selectAll()"></th>
                            <th style="text-align: center; overflow:visible;">Options</th>
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
                            <th style="text-align: center;">NOTES</th>
                        </tr></thead>
                        <tbody style="font-size: 105%;">
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
                                                        $s = $row['source']; $ds = $row['date_sourced']; $sh = $row['sha1']; $adc = $row['adc']; $o = $row['other_detection']; $f = $row['file_detection']; $tx = $row['trendx']; $tr = $row['trig']; $p = $row['prev']; $path = str_replace("\\", '\\\\', $row['path']); $a = $row['analyze_analyze']; $dt = $row['date_tested']; $tester = $row['tester']; $n = str_replace('\"', '\\\"', $row['notes']);
                                                        echo "<a class='item' style='color: black; width: 100%;' onclick='open_update(\"" . $temp . "\", \"" . $s . "\", \"" . $ds . "\", \"" . $sh . "\", \"" . $adc . "\", \"" . $o . "\", \"" . $f . "\", \"" . $tx . "\", \"" . $tr . "\", \"" . $p . "\", \"" . $path . "\", \"" . $a . "\", \"" . $dt . "\", \"" . $tester . "\", \"" . $n . "\")'>Update</a>";
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

    <div class="ui modal" id="modal_filter">
        <i class="close icon"></i>
        <div class="header" style="text-align: center;">
            FILTER SAMPLES
        </div>
        <div class="content">
            <form class="ui form" id="form_filter" method="post" action="sample_filter.php" style="text-align: center;">
                <div class="fields">
                    <div class="four wide field">
                        <label>SOURCE</label>
                        <select class="ui fluid dropdown" name="source">
                            <option value="">Choose Source</option>
                            <?php $query = "SELECT * FROM charles_table_source"; ?>
                            <?php $sources = mysqli_query($conn, $query); ?>
                            <?php while($row = mysqli_fetch_assoc($sources)) { ?>
                                <option value="<?php echo $row['value']?>"><?php echo $row['value']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="four wide field">
                        <label>FROM DATE SOURCED</label>
                        <input type="date" name="sourced_from" id="sourced_from" onchange="setmaxmin(this.value, 'sourced_to', 'min')">
                    </div>
                    <div class="four wide field">
                        <label>TO DATE SOURCED</label>
                        <input type="date" name="sourced_to" id="sourced_to" onchange="setmaxmin(this.value, 'sourced_from', 'max')">
                    </div>
                    <div class="four wide field">
                        <label>ADC</label>
                        <select class="ui fluid dropdown" name="adc">
                            <option value="">Choose ADC</option>
                            <?php $query = "SELECT * FROM charles_table_adc"; ?>
                            <?php $adcs = mysqli_query($conn, $query); ?>
                            <?php while($row = mysqli_fetch_assoc($adcs)) { ?>
                                <option value="<?php echo $row['value']?>"><?php echo $row['value']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="three fields">
                    <div class="ten wide field">
                        <label>SHA-1</label>
                        <input type="text" class="filter_input" name="sha1"  maxlength="40" minlength="40" placeholder="SHA-1">
                    </div>
                    <div class="three wide field">
                        <label>TRIGGER</label>
                        <select class="ui fluid dropdown" name="trigger">
                            <option value="">Choose Trigger</option>
                            <?php $query = "SELECT * FROM charles_table_trig"; ?>
                            <?php $triggers = mysqli_query($conn, $query); ?>
                            <?php while($row = mysqli_fetch_assoc($triggers)) { ?>
                                <option value="<?php echo $row['name']?>"><?php echo $row['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="three wide field">
                        <label>PREVALENCE</label>
                        <input type="text" class="filter_input" name="prevalence" placeholder="Prevalence">
                    </div>
                </div>
                <div class="three fields">
                    <style>.ui.selection.dropdown { min-width: 5 !important; }</style>
                    <div class="six wide field">
                        <label>OTHER DETECTION</label>
                        <div class="ui left labeled input">
                            <select class="ui mini label dropdown" id="other_eq" name="other_eq">
                                <option value="">Choose</option>
                                <option value="eq">Equals</option>
                                <option value="neq">Not Equals</option>
                                <option value="contains">Contains</option>
                            </select>
                            <input type="text" class="filter_input" name="other_detection" placeholder="Other Detection" list="other_options">
                            <datalist id="other_options"><option value="None">None</option></datalist>
                        </div>
                    </div>
                    <div class="six wide field">
                        <label>FILE DETECTION</label>
                        <div class="ui left labeled input">
                            <select class="ui mini label dropdown" id="file_eq" name="file_eq">
                                <option value="">Choose</option>
                                <option value="eq">Equals</option>
                                <option value="neq">Not Equals</option>
                                <option value="contains">Contains</option>
                            </select>
                            <input type="text" class="filter_input" name="file_detection" placeholder="File Detection" list="file_options">
                            <datalist id="file_options"><option value="None">None</option></datalist>
                        </div>
                    </div>
                    <div class="six wide field">
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
                <div class="fields">
                    <div class="eleven wide field">
                        <label>PATH</label>
                        <input type="text" class="filter_input" name="path" placeholder="Path">
                    </div>
                    <div class="three wide field">
                        <label>TESTER</label>
                        <select class="ui fluid dropdown" name="tester">
                            <option value="">Choose Tester</option>
                            <?php $query = "SELECT * FROM charles_table_users"; ?>
                            <?php $users = mysqli_query($conn, $query); ?>
                            <?php while($row = mysqli_fetch_assoc($users)) { ?>
                                <option value="<?php echo $row['username']?>"><?php echo $row['username']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="two wide field">
                        <label>ANALYZE</label>
                        <select class="ui fluid dropdown" name="analyze">
                            <option value="">Select</option>
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                </div>
                <div class="three fields">
                    <div class="four wide field">
                        <label>FROM DATE TESTED</label>
                        <input type="date" name="tested_from" id="tested_from" onchange="setmaxmin(this.value, 'tested_to', 'min')">
                    </div>
                    <div class="four wide field">
                        <label>TO DATE TESTED</label>
                        <input type="date" name="tested_to" id="tested_to" onchange="setmaxmin(this.value, 'tested_from', 'max')">
                    </div>
                    <div class="nine wide field">
                        <label>NOTES</label>
                        <input type="text" class="filter_input" name="notes" placeholder="Notes">
                    </div>
                </div>
            </form>
        </div>
        <div class="actions">
            <a class="ui red button" href="adc.php">
                <i class="redo alternate icon"></i> Clear
            </a>
            <button type="submit" form="form_filter" id="filter_submit" class="ui blue button">
                <i class="filter icon"></i> Filter
            </button>
        </div>
    </div>

    <div class="ui modal" id="modal_update">
        <div class="header" style="text-align: center;">
            UPDATE SAMPLE
        </div>
        <div class="content">
            <form class="ui form" id="form_update" method="post" action="sample_update.php" style="text-align: center;">
                <input type="hidden" name="update_id" id="update_id">
                <div class="field">
                    <div class="fields">
                        <div class="four wide field">
                            <label>SOURCE</label>
                            <select class="ui fluid dropdown" name="source" id="source_update">
                                <option value="">Select Source</option>
                                <?php $query = "SELECT * FROM charles_table_source"; ?>
                                <?php $sources = mysqli_query($conn, $query); ?>
                                <?php while($row1 = mysqli_fetch_assoc($sources)) { ?>
                                    <option value="<?php echo $row1['value'] ?>"><?php echo $row1['value'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="four wide field">
                            <label>DATE SOURCED</label>
                            <input type="date" name="date_sourced" id="sourced_update" value="">
                        </div>
                        <div class="eight wide field">
                            <label>SHA-1</label>
                            <input type="text" name="sha1" id="sha1_update" maxlength="40" minlength="40" value="">
                        </div>
                    </div>
                </div>
                <div class="three fields">
                    <div class="four wide field">
                        <label>ADC</label>
                        <select class="ui fluid dropdown" name="adc" id="adc_update">
                            <option value="">Select ADC</option>
                            <?php $query = "SELECT * FROM charles_table_adc"; ?>
                            <?php $adcs = mysqli_query($conn, $query); ?>
                            <?php while($row1 = mysqli_fetch_assoc($adcs)) { ?>
                                <option value="<?php echo $row1['value'] ?>"><?php echo $row1['value'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="six wide field">
                        <label>OTHER DETECTION</label>
                        <input type="text" name="other_detection" id="other_update" value=''>
                    </div>
                    <div class="six wide field">
                        <label>FILE DETECTION</label>
                        <input type="text" name="file_detection" id="file_update" value=''>
                    </div>
                </div>
                <div class="three fields">
                    <div class="six wide field">
                        <label>TRENDX</label>
                        <input type="text" name="trendx" id="trendx_update" value=''>
                    </div>
                    <div class="six wide field">
                        <label>TRIGGER</label>
                        <select class="ui fluid dropdown" name="trigger" id="trigger_update">
                            <option value="">Select Trigger</option>
                            <?php $query = "SELECT * FROM charles_table_trig"; ?>
                            <?php $triggers = mysqli_query($conn, $query); ?>
                            <?php while($row1 = mysqli_fetch_assoc($triggers)) { ?>
                                <option value="<?php echo $row1['name'] ?>"><?php echo $row1['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="four wide field">
                        <label>PREVALENCE</label>
                        <input type="text" name="prevalence" id="prev_update" value="">
                    </div>
                </div>
                <div class="field">
                    <label>PATH</label>
                    <input type="text" name="path" id="path_update" value=''>
                </div>
                <div class="three fields">
                    <div class="two wide field">
                        <label>ANALYZE</label>
                        <select class="ui fluid dropdown" name="analyze" id="analyze_update">
                            <option value="">Analyze</option>
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                    <div class="four wide field">
                        <label>DATE TESTED</label>
                        <input type="date" name="date_tested" id="tested_update" value="">
                    </div>
                    <div class="ten wide field">
                        <label>NOTES</label>
                        <input type="text" name="notes" id="notes_update" value=''>
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
            UPDATE SAMPLE
        </div>
        <div class="content">
            <form class="ui form" id="form_update_many" method="post" action="sample_update_many.php" style="text-align: center;">
                <input type="hidden" name="update_ids" id="update_ids">
                <div class="field">
                    <div class="fields">
                        <div class="four wide field">
                            <label>SOURCE</label>
                            <select class="ui fluid dropdown" name="source" id="source_update_many">
                                <option value="">Select Source</option>
                                <?php $query = "SELECT * FROM charles_table_source"; ?>
                                <?php $sources = mysqli_query($conn, $query); ?>
                                <?php while($row1 = mysqli_fetch_assoc($sources)) { ?>
                                    <option value="<?php echo $row1['value'] ?>"><?php echo $row1['value'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
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
                    </div>
                </div>
                <div class="three fields">
                    <div class="four wide field">
                        <label>ADC</label>
                        <select class="ui fluid dropdown" name="adc" id="adc_update_many">
                            <option value="">Select ADC</option>
                            <?php $query = "SELECT * FROM charles_table_adc"; ?>
                            <?php $adcs = mysqli_query($conn, $query); ?>
                            <?php while($row1 = mysqli_fetch_assoc($adcs)) { ?>
                                <option value="<?php echo $row1['value'] ?>"><?php echo $row1['value'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="six wide field">
                        <label>OTHER DETECTION</label>
                        <input type="text" name="other_detection" id="other_update_many" value=''>
                    </div>
                    <div class="six wide field">
                        <label>FILE DETECTION</label>
                        <input type="text" name="file_detection" id="file_update_many" value=''>
                    </div>
                </div>
                <div class="three fields">
                    <div class="six wide field">
                        <label>TRENDX</label>
                        <input type="text" name="trendx" id="trendx_update_many" value=''>
                    </div>
                    <div class="six wide field">
                        <label>TRIGGER</label>
                        <select class="ui fluid dropdown" name="trigger" id="trigger_update_many">
                            <option value="">Select Trigger</option>
                            <?php $query = "SELECT * FROM charles_table_trig"; ?>
                            <?php $triggers = mysqli_query($conn, $query); ?>
                            <?php while($row1 = mysqli_fetch_assoc($triggers)) { ?>
                                <option value="<?php echo $row1['name'] ?>"><?php echo $row1['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="four wide field">
                        <label>PREVALENCE</label>
                        <input type="text" name="prevalence" id="prev_update_many" value="">
                    </div>
                </div>
                <div class="field">
                    <label>PATH</label>
                    <input type="text" name="path" id="path_update_many" value=''>
                </div>
                <div class="three fields">
                    <div class="two wide field">
                        <label>ANALYZE</label>
                        <select class="ui fluid dropdown" name="analyze" id="analyze_update_many">
                            <option value="">Analyze</option>
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                    <div class="four wide field">
                        <label>DATE TESTED</label>
                        <input type="date" name="date_tested" id="tested_update_many" value="">
                    </div>
                    <div class="ten wide field">
                        <label>NOTES</label>
                        <input type="text" name="notes" id="notes_update_many" value=''>
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
            <form class="ui form" id="form_delete" method="post" action="sample_delete.php">
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
                    window.location.href = "adc.php?rpp=" + rpp_input.value;
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
        console.log(tested_date.getFullYear() + "-" + tm + "-" + td);
        document.getElementById('create_sourced').setAttribute('value', sourced_date.getFullYear() + "-" + sm + "-" + sd);
        document.getElementById('create_tested').setAttribute('value', tested_date.getFullYear() + "-" + tm + "-" + td);

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
            window.location.href = "adc.php?page=" + temp; 
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

        function open_update(id, source, sourced, sha1, adc, other, file, trendx, trigger, prev, path, analyze, tested, tester, notes) {
            document.getElementById('update_id').setAttribute('value', id);
            document.getElementById('form_update').setAttribute('action', 'sample_update.php');
            x = document.getElementById('source_update');
            for(var i = 0; i < x.options.length; i++) {
                if(x.options[i].value == source) {
                    x.selectedIndex = i;
                    x.remove(x.selectedIndex);
                    option = document.createElement("option");
                    option.text = source;
                    option.selected = "selected";
                    x.add(option);
                    break;
                }
            }
            document.getElementById('sourced_update').setAttribute('value', sourced);
            document.getElementById('sha1_update').setAttribute('value', sha1);
            x = document.getElementById('adc_update');
            for(var i = 0; i < x.options.length; i++) {
                if(x.options[i].value == adc) {
                    x.selectedIndex = i;
                    x.remove(x.selectedIndex);
                    option = document.createElement("option");
                    option.text = adc;
                    option.selected = "selected";
                    x.add(option);
                    break;
                }
            }
            document.getElementById('other_update').setAttribute('value', other);
            document.getElementById('file_update').setAttribute('value', file);
            document.getElementById('trendx_update').setAttribute('value', trendx);
            x = document.getElementById('trigger_update');
            for(var i = 0; i < x.options.length; i++) {
                if(x.options[i].value == trigger) {
                    x.selectedIndex = i;
                    x.remove(x.selectedIndex);
                    option = document.createElement("option");
                    option.text = trigger;
                    option.selected = "selected";
                    x.add(option);
                    break;
                }
            }
            document.getElementById('prev_update').setAttribute('value', prev);
            document.getElementById('path_update').setAttribute('value', path);
            x = document.getElementById('analyze_update');
            for(var i = 0; i < x.options.length; i++) {
                if(x.options[i].value == analyze) {
                    x.selectedIndex = i;
                    x.remove(x.selectedIndex);
                    option = document.createElement("option");
                    option.text = analyze;
                    option.selected = "selected";
                    x.add(option);
                    break;
                }
            }
            document.getElementById('tested_update').setAttribute('value', tested);
            document.getElementById('notes_update').setAttribute('value', notes);
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
                        $user = "SELECT * FROM charles_table_users WHERE username='" . $_SESSION['username'] . "'";
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