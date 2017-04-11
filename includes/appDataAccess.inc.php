<?php

include_once 'genericDataAccess.inc.php';

//Example of data access layer below

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
	$dashboardItems['Orders to Date'] = getOrdersToDate();
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

function getOrdersToDate(){
	
	$sql = "SELECT COUNT(`orderId`) AS 'OTD' FROM `oe_order` WHERE 1";
	
	$record = fetchRecord($sql);
	
	return $record['OTD'];
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

function getProductVolume(){
	
	$sql = "SELECT p.productId, p.productName, p.price,\n"
	. "SUM(qty) AS 'qty', SUM(qty * p.price) AS 'Sales' FROM `oe_orderProduct` op\n"
    . "RIGHT JOIN `oe_product` p\n"
    . "ON op.productId = p.productId\n"
    . "GROUP BY `productId`\n"
    . "ORDER BY Sales DESC";
	
	uiGetProductVolume(fetchAllRecords($sql));
}

?>
