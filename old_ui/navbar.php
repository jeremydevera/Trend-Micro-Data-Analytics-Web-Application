<style>
    .dropdown-item {
        font-size: 120%;
    }
</style>
<!-- <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">
<script src = "https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.js"></script> -->

<nav class="navbar navbar-inverse visible-xs">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav nav-bar"><br>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="selections.php">Selections</a></li>
                    <li><a data-target="#demo5" data-toggle="collapse">Users <span class="glyphicon glyphicon-chevron-down"></span></a></li>
                    <ul class="collapse nav nav-pills nav-stacked" id="demo5">
                        <li><a href="users.php"><span class="glyphicon glyphicon-chevron-right"></span> Manage Accounts</a></li>
                        <li><a href="login.php"><span class="glyphicon glyphicon-chevron-right"></span> Log In</a></li>
                        <li><a href="logout.php"><span class="glyphicon glyphicon-chevron-right"></span> Log Out</a></li>
                    </ul>
                    <li><a data-target="#demo6" data-toggle="collapse">Dashboard <span class="glyphicon glyphicon-chevron-down"></span></a></li>
                    <ul class="collapse nav nav-pills nav-stacked" id="demo6">
                        <?php
                            $file = fopen("settings.ini", "r");
                            $line = fgets($file);
                            if($line[0] == "1") {
                            echo "<li><a href='adc_pie.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Charts/Graphs</a></li>";
                            } elseif($line[1] == "1") {
                            echo "<li><a href='monthly.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Charts/Graphs</a></li>";
                            } elseif($line[2] == "1") {
                            echo "<li><a href='overall.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Charts/Graphs</a></li>";
                            } elseif($line[3] == "1") {
                            echo "<li><a href='trendx_weekly.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Charts/Graphs</a></li>";
                            } elseif($line[4] == "1") {
                            echo "<li><a href='trendx_monthly.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Charts/Graphs</a></li>";
                            } elseif($line[5] == "1") {
                            echo "<li><a href='adc_bar1.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Charts/Graphs</a></li>";
                            } elseif($line[6] == "1") {
                            echo "<li><a href='adc_bar2.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Charts/Graphs</a></li>";
                            } elseif($line[8] == "1") {
                            echo "<li><a href='bar.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Charts/Graphs</a></li>";
                            } elseif($line[7] == "1") {
                            echo "<li><a href='adc_bar.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Charts/Graphs</a></li>";
                            }
                            fclose($file);
                        ?>
                        <li><a href="settings.php"><span class="glyphicon glyphicon-chevron-right"></span> Settings</a></li>
                    </ul>
                    <li><a href="history.php">History</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-2 sidenav hidden-xs">
            <div class="row"><br>
                <img style="padding: 10px;" class="img-responsive" src="trend_micro.jpg">
            </div>
            <br>
            <img src="image.jpg" style="padding: 10px;" class="img-responsive"><br>
            <ul class="nav nav-pills nav-stacked">
                <li><a href="index.php">Home</a></li>
                <li><a href="selections.php">Selections</a></li>
                <li><a data-target="#demo2" data-toggle="collapse">Users <span class="glyphicon glyphicon-chevron-down"></span></a></li>
                <ul class="collapse nav nav-pills nav-stacked" id="demo2">
                    <li><a href="users.php"><span class="glyphicon glyphicon-chevron-right"></span> Manage Accounts</a></li>
                    <li><a href="login.php"><span class="glyphicon glyphicon-chevron-right"></span> Log In</a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-chevron-right"></span> Log Out</a></li>
                </ul>
                <li><a data-target="#demo3" data-toggle="collapse">Dashboard <span class="glyphicon glyphicon-chevron-down"></span></a></li>
                <ul class="collapse nav nav-pills nav-stacked" id="demo3">
                    <li class="btn-group dropup"><a type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class='glyphicon glyphicon-chevron-right'></span> Charts and Graphs</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href='adc_pie.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> ADC Pie</a><br>
                            <a class="dropdown-item" href='adc_bar.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> ADC Bar</a><br>
                            <a class="dropdown-item" href='adc_bar1.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> ADC Bar1</a><br>
                            <a class="dropdown-item" href='adc_bar2.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> ADC Bar2</a><br>
                            <a class="dropdown-item" href='monthly.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> ADC Monthly</a><br>
                            <a class="dropdown-item" href='overall.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> ADC Overall</a><br>
                            <a class="dropdown-item" href='trendx_weekly.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> TrendX Weekly</a><br>
                            <a class="dropdown-item" href='trendx_monthly.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> TrendX Monthly</a><br>
                            <a class="dropdown-item" href='bar.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Samples Bar</a><br>
                        </div>
                    </li><br><br>
                    <?php
                        $file = fopen("settings.ini", "r");
                        $line = fgets($file);
                        if($line[0] == "1") {
                        echo "<li><a href='adc_pie.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Start Slideshow</a></li>";
                        } elseif($line[1] == "1") {
                        echo "<li><a href='monthly.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Start Slideshow</a></li>";
                        } elseif($line[2] == "1") {
                        echo "<li><a href='overall.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Start Slideshow</a></li>";
                        } elseif($line[3] == "1") {
                        echo "<li><a href='trendx_weekly.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Start Slideshow</a></li>";
                        } elseif($line[4] == "1") {
                        echo "<li><a href='trendx_monthly.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Start Slideshow</a></li>";
                        } elseif($line[5] == "1") {
                        echo "<li><a href='adc_bar1.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Start Slideshow</a></li>";
                        } elseif($line[6] == "1") {
                        echo "<li><a href='adc_bar2.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Start Slideshow</a></li>";
                        } elseif($line[8] == "1") {
                        echo "<li><a href='bar.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Start Slideshow</a></li>";
                        } elseif($line[7] == "1") {
                        echo "<li><a href='adc_bar.php' target='_blank'><span class='glyphicon glyphicon-chevron-right'></span> Start Slideshow</a></li>";
                        }
                        fclose($file);
                    ?>
                    <li><a href="settings.php"><span class="glyphicon glyphicon-chevron-right"></span> Settings</a></li>
                </ul>
                <li><a href="history.php">History</a></li>
            </ul>
            <br>
        </div>
        <br>