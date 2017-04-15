<?php
    include_once './includes/appDataAccess.inc.php';
	
	$ret_caller = array();
        
	switch($_GET['fnc']){
		case 'getAllTestLocations':
                    $ret_caller['function'] = "getAllTestLocations";
                    $ret_caller['data'] = getAllTestLocations();
			break;
		case 'getTestDataByMasterID':
			if(isset($_GET['MasterID']) && !empty($_GET['MasterID'])){
				$ret_caller['function'] = "getTestDataByMasterID";
				$ret_caller['data'] = getTestDataByMasterID($_GET['MasterID']);
				break;
			}else{
				$ret_caller['call_error'] = "missing parameter";
			}
			break;
		case 'getTestDataByLocation':
                    	if(isset($_GET['LocationID']) && !empty($_GET['LocationID'])){
                        $ret_caller['function'] = "getTestDataByLocation";
                        $ret_caller['data'] = getTestDataByLocation($_GET['LocationID']);
                        
			}else{
				$ret_caller['call_error'] = "missing parameter";
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
