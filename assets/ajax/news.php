<?php
$wpLoad = dirname(__FILE__) . "/../../../../../wp-load.php";
include_once($wpLoad);
global $vaccine;
$vaccineNews = $vaccine->fetchVaccineNews();
print $vaccineNews;
?>