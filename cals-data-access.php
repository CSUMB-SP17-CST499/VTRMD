<?php
    include_once './includes/dataAccess.php';
	
	
	switch($_GET['fnc']){
		case 'getAllTestLocations':
			getAllTestLocations();
			break;
		case 'getTestDataByMasterID':
			if(isset($_GET['client']) && !empty($_GET['client'])){
				getClientOrders($_GET['client']);
			}else{
				echo "missing parameter";
			}
			break;
		case 'getTestDataByLocation'
			break;
		case 'dashboard':
			getDashboard();
			break;
		case 'orderHist':
			getOrderHistory();
			break;
		case 'clientWoOrders':
			getClientsWithoutOrders();
			break;
		case 'productVol':
			getProductVolume();
			break;
	}

?>
