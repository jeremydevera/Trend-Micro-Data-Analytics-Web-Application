<!DOCTYPE html>
<html style="background-color: #000; overflow-y: hidden;">
<head></head>

<?php 
    include 'read_settings.php';
?>

<body>
    <video width="100%" controls autoplay muted>
        <source src="<?php echo $vidname; ?>" type="video/mp4">
    </video>
</body>

</html>

<?php
    $_SESSION['current_graph'] = 9;
	include 'nextgraph.php';
?>