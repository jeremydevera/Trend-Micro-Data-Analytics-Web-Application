<?php require_once 'ti.php' ?>
<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>
<htmnl>
    <head>
        <!-- Semantic UI -->
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="static/semantic/semantic.min.css">
        <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous">
        </script>
        <script type="text/javascript" src="static/semantic/semantic.min.js"></script>
        <link rel="stylesheet" type="text/css" href="static/semantic_alert/Semantic-UI-Alert.css">
        <script type="text/javascript" src="static/semantic_alert/Semantic-UI-Alert.js"></script>

        <!-- Extra Styles -->
        <link rel="stylesheet" type="text/css" href="static/css/base.css">
            
        <script>
            $(document).ready(function () {
                $('.modal_trigger').click(function () {
                    $('#modal_login').modal({autofocus: true, observeChanges: true,}).modal('show');
                });
                $('#cancel_login').click(function () {
                    $('#modal_login').modal('hide');
                });
            });
        </script>

        <?php startblock('extrastyle') ?>
        <?php endblock() ?>
    </head>

    <body>
        <div id="navbar" class="ui fixed inverted secondary menu">
            <img id="logo" class="ui image item" src="static/pictures/logo.png">
            <a class="ui item" id="home_navbar" href="index.php">ML Solutions</a>
            <?php
                if(isset($_SESSION['username'])) {
                    echo '<a id="selections_navbar" class="item" href="selections.php">Selections</a>';
                } else {
                    echo '<a id="selections_navbar" class="item modal_trigger" data-target="#modal_login">Selections</a>';
                }
            ?>
            <div id="dashboard_navbar" class="ui dropdown item"> Dashboard <i class="dropdown icon"></i>
                <div class="menu">
                    <div class="ui dropdown item">
                        Charts <i class="dropdown icon"></i>
                        <div class="menu">
                            <a class="item" target='_blank' href="graphs/adc_pie.php">ADC Daily/Weekly</a>
                            <a class="item" target='_blank' href="graphs/monthly.php">ADC Monthly</a>
                            <a class="item" target='_blank' href="graphs/overall.php">ADC Overall</a>
                            <a class="item" target='_blank' href="graphs/adc_bar.php">ADC Bar</a>
                            <a class="item" target='_blank' href="graphs/adc_bar1.php">ADC Bar1</a>
                            <a class="item" target='_blank' href="graphs/adc_bar2.php">ADC Bar2</a>
                            <a class="item" target='_blank' href="graphs/trendx_weekly.php">TrendX Weekly</a>
                            <a class="item" target='_blank' href="graphs/trendx_monthly.php">TrendX Monthly</a>
                            <a class="item" target='_blank' href="trendslice_overall.php">TrendX Pie Overall</a>
                            <a class="item" target='_blank' href="trendslice_monthly.php">TrendX Pie Monthly</a>
                            <a class="item" target='_blank' href="trendxdoubleline_overall.php">TrendX Line Overall</a>
                            <a class="item" target='_blank' href="graphs/bar.php">Samples Bar</a>
                            <a class="item" target='_blank' href="graphs/video.php">Video</a>
                        </div>
                    </div>
                    <div class="item" onclick="startslideshow()">Start Slideshow</div>
                    <a class="item" href="settings.php">Settings</a>
                </div>
            </div>
            <a id="history_navbar" class="item" href="history.php">History</a>
            <a id="adc_navbar" class="item" href="adc.php">ADC</a>
            <div class="right menu">
                <?php 
                    if(isset($_SESSION['username'])) {
                        echo '<div class="item">';
                        echo '    Signed in as : &nbsp' .  $_SESSION['username'];
                        echo '</div>';
                    } 
                ?>
                <div id="accounts_navbar" class="ui dropdown item">
                    <img id="icon" src="static/pictures/icon.png">
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <?php 
                            if(isset($_SESSION['username'])) {
                                echo '<a style="color: black; text-align: center; width: 100%;" class="ui button item" href="users.php">Manage Accounts</a>';
                                echo '<a style="color: black; text-align: center; width: 100%;" class="ui button item" href="logout.php">Logout</a>';
                            } else {
                                echo '<a style="color: black; text-align: center; width: 100%;" class="ui button item modal_trigger" data-target="#modal_login">Login</a>';
                        }?>
                        <div class="ui mini modal" id="modal_login">
                            <i class="close icon"></i>
                            <div class="header" style="text-align: center;">
                                USER LOGIN
                            </div>
                            <div class="content">
                                <form class="ui form" id="form_login" method="post" action="login.php">
                                    <div style="text-align: center;" class="field">
                                        <label>Username : </label>
                                        <input type="text" class="login_inputs" name="username" placeholder="e.g: Army" required>
                                    </div>
                                    <div style="text-align: center;" class="field">
                                        <label>Password : </label>
                                        <input type="password" class="login_inputs" name="password" placeholder="Password" required>
                                    </div>
                                </form>
                            </div>
                            <div class="actions">
                                <button class="ui red button" id="cancel_login">
                                    <i class="thumbs down outline icon"></i> Cancel
                                </button>
                                <button type="submit" form="form_login" id="loginform_submit" class="ui blue button">
                                    <i class="thumbs up outline icon"></i> Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br><br><br>
        <?php startblock('body') ?>
        <?php endblock() ?>

        <?php startblock('extrascripts') ?>
        <?php endblock() ?>
        <script>
            $('.ui.dropdown').dropdown();
            var loginforminputs = document.getElementsByClassName("login_inputs");
                for(var i = 0; i < loginforminputs.length; i++) {
                    loginforminputs[i].addEventListener("keydown", function (e) {
                        if (e.keyCode === 13) {
                            document.getElementById('loginform_submit').click();
                        }
                    });
            }

            function startslideshow() {
                <?php
                    $file = fopen("graphs/settings.ini", "r");
                    $line = fgets($file);
                    fclose($file);
                    $first_graph = "";
                    for($i = 0; $i < strlen($line); $i++) {
                        if($line[$i] == 1) {
                            if($i == 0) $first_graph = "graphs/adc_pie.php";
                            elseif($i == 1) $first_graph = "graphs/monthly.php";
                            elseif($i == 2) $first_graph = "graphs/overall.php";
                            elseif($i == 3) $first_graph = "graphs/trendx_weekly.php";
                            elseif($i == 4) $first_graph = "graphs/trendx_monthyl.php";
                            elseif($i == 5) $first_graph = "graphs/adc_bar1.php";
                            elseif($i == 6) $first_graph = "graphs/adc_bar2.php";
                            elseif($i == 7) $first_graph = "graphs/adc_bar.php";
                            elseif($i == 8) $first_graph = "graphs/bar.php";
                            elseif($i == 9) $first_graph = "graphs/trendslice_monthly.php";
                            elseif($i == 10) $first_graph ="graphs/trendslice_overall.php";
                            elseif($i == 11) $first_graph ="graphs/trendxdoubleline_overall.php";
                            elseif($i == 12) $first_graph ="graphs/trend_dashboard.php";
                            elseif($i == 13) $first_graph ="graphs/video.php";
                            break;
                        }
                    }
                ?>
                window.open('<?php echo $first_graph ?>', '_blank');
            }
        </script>
    </body>
</htmnl>