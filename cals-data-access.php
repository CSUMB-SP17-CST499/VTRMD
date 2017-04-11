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
                        $ret_caller['function'] = "getTestDataByLocation";
                        $ret_caller['data'] = getTestDataByLocation($_GET['LocationID']);
                        
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
        
	header('Content-Type: text/json; charset=UTF-8'); 
        echo json_encode($ret_caller);

?>
