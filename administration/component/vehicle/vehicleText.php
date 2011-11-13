<?php

//require_once($system->site_path.'adminInc/configOS.php');
$vehicleID = $_COOKIE['vehicleID'];
$adminID = $_COOKIE['adm'];

			global $db;
			global $d;
			$keyPoint = '';
			$futureIntl = '';
			$currentGenerationEquipmentUpdates = '';
			$currentGenerationLaunchInfo = '';
			$priorGenerationInfo = '';
			$vehicleConfigPowerTrainProfile = '';
			$autopacificsTake = '';
			$administrator = $db->get("SELECT * FROM vehicleKeypoint where vehicleID = '$vehicleID' and adminID = '$adminID'");
			if($administrator){
				while(list($key,$value) = each($administrator)){
    			$keyPoint = $value['keypointText'];
    		}
    		}
			unset($administrator);
			$administrator = $db->get("SELECT * FROM vehicleFutureIntel where vehicleID = '$vehicleID' and adminID = '$adminID'");
			if($administrator){
				while(list($key,$value) = each($administrator)){
    			$futureIntl = $value['futureIntl'];
    		}
    		}
			unset($administrator);
			$administrator = $db->get("SELECT * FROM vehicleCGEquipUpdates where vehicleID = '$vehicleID' and adminID = '$adminID'");
			if($administrator){
				while(list($key,$value) = each($administrator)){
    			$currentGenerationEquipmentUpdates = $value['currentGenerationEquipmentUpdates'];
    		}
    		}
			unset($administrator);
			$administrator = $db->get("SELECT * FROM vehicleCGLaunchInfo where vehicleID = '$vehicleID' and adminID = '$adminID'");
			if($administrator){
				while(list($key,$value) = each($administrator)){
    			$currentGenerationLaunchInfo = $value['currentGenerationLaunchInfo'];
    		}
    		}
			unset($administrator);
			$administrator = $db->get("SELECT * FROM vehiclePriorGenerationInfo where vehicleID = '$vehicleID' and adminID = '$adminID'");
			if($administrator){
				while(list($key,$value) = each($administrator)){
    			$priorGenerationInfo = $value['priorGenerationInfo'];
    		}
    		}
			unset($administrator);
			$administrator = $db->get("SELECT * FROM vehicleConfigPowerTrainProfile where vehicleID = '$vehicleID' and adminID = '$adminID'");
			if($administrator){
				while(list($key,$value) = each($administrator)){
    			$vehicleConfigPowerTrainProfile = $value['vehicleConfigPowerTrainProfile'];
    		}
    		}
			unset($administrator);
			$administrator = $db->get("SELECT * FROM vehicleAutoPacificsTake where vehicleID = '$vehicleID' and adminID = '$adminID'");
			if($administrator){
				while(list($key,$value) = each($administrator)){
    			$autopacificsTake = $value['autopacificsTake'];
    		}
    		}
			unset($administrator);		
			


?>