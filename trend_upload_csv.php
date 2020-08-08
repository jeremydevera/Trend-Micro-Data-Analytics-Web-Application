<?php include 'authorize.php' ?>
<?php
    error_reporting(E_ALL ^ E_NOTICE);
    if(isset($_POST['submit'])) {
        $i=0;
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $db = 'jeremy_db';
        ini_set('max_execution_time', 5000);
        $con = mysqli_connect($host,$user,$password) or die('Could not' .mysqli_error($con));
        mysqli_select_db($con, $db) or die ('Could not' .mysqli_error($con));



        if($_FILES["file"]["error"] != 0) {
            echo '<script type="text/javascript">'; 
            echo '      alert("Not a CSV file");'; 
            echo '      window.location.href = "index.php";';
            echo '</script>';
            error_reporting(E_ALL ^ E_NOTICE);
            exit();
        } 
        $mimes = array('application/vnd.ms-excel','text/csv','text/tsv');
        if(in_array($_FILES['file']['type'],$mimes)){
        // do something
        } else {
            echo '<script type="text/javascript">'; 
            echo '      alert("Not a CSV file");'; 
            echo '      window.location.href = "index.php";';
            echo '</script>';
            error_reporting(E_ALL ^ E_NOTICE);
        }
        $file = $_FILES['file']['tmp_name'];
        $handle = fopen($file, "r");
        ini_set ('memory_limit', filesize ($file) + 4000000);
        $c = 0;
        list($date) = explode('_', $_FILES['file']['name']);
        while(($csvdata = fgetcsv($handle,10000,","))!== FALSE){
            if ( count($csvdata) >= 6 ) {

                echo '<script type="text/javascript">'; 
                echo '      alert("Please upload csv with no column DATE_SOURCED");'; 
                echo '      window.location.href = "index.php";';
                echo '</script>';
                error_reporting(E_ALL ^ E_NOTICE);
                exit();
            }
            if($i>0) {
        $sha1 = $csvdata[0];
        $vsdt = $csvdata[1];
        $trendx  = $csvdata[2];
        $notes  = $csvdata[3];

        // Get record where sha1 
        $check_sha = "SELECT sha1 FROM jeremy_table_trend WHERE sha1='".$sha1."'";
        $check_shaquery = mysqli_query($con , $check_sha);  
        if($check_shaquery){
            $sha_count = mysqli_num_rows($check_shaquery);
        }

        // Check if sha1 already in database
        if(isset($sha_count) && $sha_count>0){
            $sql = "UPDATE `jeremy_table_trend` SET `date_sourced`='".$date."',`sha1`='".$sha1."',`vsdt`='".$vsdt."',`trendx`='".$trendx."',`notes`='".$notes."' WHERE sha1='".$sha1."'";
            $query = mysqli_query($con , $sql);
        }else{
            $sql = "INSERT INTO jeremy_table_trend (date_sourced,sha1,vsdt,trendx,notes) VALUES ('$date','$sha1','$vsdt','$trendx','$notes')";
            $query = mysqli_query($con , $sql);
        }

        $c = $c+1;
        error_reporting(E_ALL ^ E_NOTICE);
        }
            $i++;
            error_reporting(E_ALL ^ E_NOTICE);
        }
        if($query){
            echo '<script type="text/javascript">'; 
            echo '      alert("CSV uploaded to server");'; 
            echo '      window.location.href = "index.php";';
            echo '</script>';
            error_reporting(E_ALL ^ E_NOTICE);
        }else { 
            echo "SLAM";
            error_reporting(E_ALL ^ E_NOTICE);
        }
        $sql = "UPDATE jeremy_table_trend SET vsdt = SUBSTRING(vsdt, 1, CHAR_LENGTH(vsdt) - 1) WHERE vsdt LIKE '%)'";
        $sql2 = "UPDATE jeremy_table_trend SET vsdt = SUBSTR(vsdt, 2) WHERE vsdt LIKE '(%';";
        $query = mysqli_query($con , $sql);
        $query = mysqli_query($con , $sql2);
        error_reporting(E_ALL ^ E_NOTICE);
    }
    error_reporting(E_ALL ^ E_NOTICE);
?>