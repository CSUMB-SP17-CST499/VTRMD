<?php

include_once 'genericDataAccess.inc.php';


/*
 * Inserts record rows into the dv_test_locations table. The dv_test_locations
 * table is the first set in mormalization.
 */
function insertLocation($master_id, $location_id, $lat, $long){

	$sql = "INSERT INTO `ciam1324`.`dv_test_locations` \n"
	. "(`Master_ID`, `LocationID`, `Geo_location`, `Updated`) \n"
	. "VALUES (:master_id, :location_id, GeomFromText('POINT(:lat :long)',0),\n"
	. " CURRENT_TIMESTAMP);";
	
	//The named parameters for this call
	$parameters = array();
	$parameters[':master_id'] = $master_id;
	$parameters[':location_id'] = $location_id;
	$parameters[':lat'] = $lat;
        $parameters[':long'] = $long;

	$result = array();
	$result['rows_effected'] = 0;
	$re = insertRecord($sql, $parameters);
        if($re != null){
 	   $result['rows_effected'] = $re;
	}
	return $result;
}

/*
 * Inserts records into the main dv_calspeed_data table for the CalSpeed web
 * application.
 */
function insertCalSpeedData($data){
    
    $sql = "INSERT INTO `dv_calspeed_data` \n"
         . "(`Master_ID`,) \n"
         . "VALUES (`:Master_ID`) ;";
    
    $parameters = array();
    $parameters[':Master_ID'] = $data[0];
    
    $result = array();
    $result['rows_effected'] = 0;
    $re = insertRecord($sql, $parameters);
    if($re != null){
        $result['rows_effected'] = $re;
    }
    
    return $result;
    
}




function getTestDataByLocation($locationId) {

	$sql = "SELECT * FROM `dv_calspeed_data` \n"
               . "WHERE `dv_calspeed_data`.`LocationID` = :LocationID";
	
	//The named parameters for this call	   
	$parameters = array();
	$parameters[':LocationID'] = $locationId;
        
	
	//Call the function for output
	$results = fetchAllRecords($sql, $parameters);
        
        return $results;
}

function getAllTestLocations() {

	$sql = "SELECT \n"
                . "`Master_ID`, \n"
                . "`LocationID`, \n"
                . "X(`Geo_location`) AS Latitiude, \n"
                . "Y(`Geo_location`) AS Longitude, \n"
                . "`Updated` \n"
                . "FROM `dv_test_locations` \n"
                . "WHERE 1";
        
	//The named parameters for this call	   
	
	
	//Call the function for output
	$results = fetchAllRecords($sql);
        
        return $results;
}


function getDashboard(){
	
	$dashboardItems = array();
	
	//Get the total number of orders to date
	$dashboardItems['Total Records Onhand'] = getOrdersToDate();
	//Get the average item cost at the OE
	$dashboardItems['Average Item Cost'] = number_format(getAverageItemCost(),2);
	//Get the average amout of all orders to date
	$dashboardItems['Average Order Total'] = number_format(getAverageOrderCost(),2);
	//Get the number of Healthy Choices in OE
	$dashboardItems['Healthy Choices'] = getHealthyChoiceCount();
	//Get the gross sales to date
	$dashboardItems['Gross Sales to Date'] = getGrossSalesToDate();
	
	uiDashboard($dashboardItems);
}

/*
 * Fetches the total number of records in the visualization database.
 * This query only fetches records rows which are based on master_id.
 * The real number of tests 
 */
function getTotalNumberOfRecords(){
	
	$sql = "SELECT COUNT(`*`) \n"
             . "AS 'total_records' \n"
             . "FROM `dv_test_locations` \n"
             . "WHERE 1";
	
	$record = fetchRecord($sql);
	
	return $record['total_records'];
}

function getAverageItemCost()
{
	$sql = "SELECT AVG(`price`) AS 'Average' FROM `oe_product` WHERE 1";
	
	$record = fetchRecord($sql);
	
	return $record['Average'];
	
}

function getAverageOrderCost()
{
	$sql = "SELECT AVG(p.price * op.qty) AS 'AOT' \n"
           . "FROM `oe_orderProduct` op\n"
           . "INNER JOIN `oe_product` p\n"
           . "ON p.productId = op.productId";
           
    $record = fetchRecord($sql);
    
    return $record['AOT'];
}

function getHealthyChoiceCount()
{
	$sql = "SELECT COUNT(`productId`) AS 'HIC' FROM\n"
	     . "`oe_product` WHERE `healthyChoice` = 1";
		 
	$record = fetchRecord($sql);
	
	return $record['HIC'];
}

function getGrossSalesToDate()
{
	
    $sql = "SELECT SUM(Sales) AS 'GSTD' FROM (\n"
         . "SELECT SUM(qty * p.price) AS 'Sales'\n"
         . "FROM `oe_orderProduct` op\n"
         . "RIGHT JOIN `oe_product` p\n"
         . "ON op.productId = p.productId\n"
         . "GROUP BY op.`productId`) salesTable";
    
    $record = fetchRecord($sql);
		   
    return $record['GSTD'];
}

function logEmailMessage($to, $subject, $message){
	
	$sql = "INSERT INTO `dv_emailLog`(`to`, `subject`, `message`) \n"
                . "VALUES (:to,:subject,:message);";
        
        $parameters = array();
        
        $parameters[':to'] = $to;
        $parameters[':subject'] = $subject;
        $parameters[':message'] = $message;
        
        if(!insertRecord($sql, $parameters)){
            //TODO: Log to local file on db insert failure
        }
	
}



?>
