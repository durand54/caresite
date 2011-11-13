<?php
class my{
}

class front{
	function error(){
		if($error=html::getInput($_REQUEST,'error')){
			switch($error){
				case 'login': 
					$error_string='You must be logged in to view that page.';
					break;
				case 'badlogin': 
					$error_string='Incorrect user or password.';
					break;
				case 'badsubscription': 
					$error_string='You must be subscribed to view that page.';
					break;
			}
?>
<span style="color:red"><?php echo  $error_string?></span><br />
<?php
		}
	}
	function init(){
	}
	function initAdmin(){
	}
}

class session{
	function init(){
		global $my;
		
		session_start();
		if($_SESSION['id']!=''){
			$my=new my;
			$my->id = $_SESSION['id'];
		}
	
		$result=subscriberDB::getServicesByUser($my->id);
		
		$my->services['cbg']=array();
		$my->services['sfcs']=array();
		while($row=mysql_fetch_object($result)){
			$my->subscriberid=$row->SubscriberID;
			$name=str_replace('Competitive Battleground','',$row->name);
			if($row->type=='CBG'){
				$my->services['cbg'][]=array('name'=>$name,'cbgid'=>$row->cbgid,'id'=>$row->serviceid);
			}else{
				$my->services['sfcs'][]=array('name'=>$name,'sfcsid'=>$row->sfcsid,'id'=>$row->serviceid);
			}
		}
	}

	function initAdmin(){
		global $my;
		
		//session_start();
		$sid = session_id();
		//echo "<br />$sid<br />this is sessionid<br />";
		if(isset($_SESSION['admin_id'])){
			
			$my=new my;
			$my->admin_id = $_SESSION['admin_id'];
			//echo $_SESSION['admin_id'];
		
		} else {
			//echo "there is no cookie";
		} 
		/*if($_SESSION['admin_id']!=''){
			$my=new my;
			$my->admin_id = $_SESSION['admin_id'];
		}*/
	}

}
?>