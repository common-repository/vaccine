<?php
$wpLoad = dirname(__FILE__) . "/../../../../../wp-load.php";
include_once($wpLoad);
if(isset($_GET["id"])){
	$currentId = $_GET["id"];
	if(is_numeric($currentId)){
		if($currentId<=count($vaccine->scanFiles["perm"])){
			global $vaccine;
			$vaccineFiles = $vaccine->scanFiles["perm"];
			if(isset($vaccineFiles[$currentId])){
				$thisFile = rtrim(ABSPATH, "/") . $vaccineFiles[$currentId]["file"];
				if(file_exists($thisFile)){
					clearstatcache();
					$fileInf = stat($thisFile);
					//print_r($fileInf);
					$fileMode = sprintf("0%o", 0777 & $fileInf['mode']);
					if($fileMode==$vaccineFiles[$currentId]["permRequired"]){
						print '<img src="' . plugins_url('vaccine/assets/images/tick.png') . '" align="absmiddle" /> ' . $vaccineFiles[$currentId]["friendlyName"];
					}else{
						print '<img src="' . plugins_url('vaccine/assets/images/cross.png') . '" align="absmiddle" /> ' . $vaccineFiles[$currentId]["friendlyName"] . " (c:" . $fileMode . "|r:" . $vaccineFiles[$currentId]["permRequired"] . ")";
					}
				}else{
					print '<img src="' . plugins_url('vaccine/assets/images/cross.png') . '" align="absmiddle" /> ' . $vaccineFiles[$currentId]["friendlyName"] . " cannot stat";
				}
			}else{
				wp_die( __( 'Oooops, file array error' ) );
			}
		}else{
			wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );
		}
	}else{
		wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );
	}
}else{
	wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );
}
?>