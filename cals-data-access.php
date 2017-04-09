<?php
    include_once './includes/appDataAccess.inc.php';
	
	$ret_caller = array();
        
	switch($_GET['fnc']){
		case 'getAllTestLocations':
                    $ret_caller['function'] = "getAllTestLocations";
                    $ret_caller['data'] = getAllTestLocations();
			break;
		case 'getTestDataByMasterID':
			if(isset($_GET['client']) && !empty($_GET['client'])){
				getClientOrders($_GET['client']);
			}else{
				echo "missing parameter";
			}
			break;
		case 'getTestDataByLocation':
                    	if(isset($_GET['LocationID']) && !empty($_GET['LocationID'])){
				getTestDataByLocation($_GET['LocationID']);
			}else{
				echo "missing parameter";
			}
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
        
        echo json_encode($ret_caller);

?>
