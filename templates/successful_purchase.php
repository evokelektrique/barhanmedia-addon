<?php 
$authority = !empty($_GET['Authority']) ? $_GET['Authority'] : '';
$status = !empty($_GET['Status']) ? $_GET['Status'] : ''; // [OK, NOK]
if ($status === "OK"):
echo($content);
?>
<!-- Success Content -->
<?php endif; ?>
