<?php

include_once 'genericDataAccess.inc.php';

//Example of data access layer below

function getOrderHistory(){
		
	$sql = "SELECT c.firstName, c.lastName,\n"
         . "c.email, c.phone,\n"
         . "op.orderId, o.dateTime, o.timeRequested,\n"
         . "p.productName, op.qty, p.price,\n"
         . "p.price * op.qty AS 'Total'\n"
         . "FROM `oe_order` o\n"
         . "INNER JOIN `oe_orderProduct` op\n"
         . "ON o.orderId = op.orderId\n"
         . "INNER JOIN `oe_client` c\n"
         . "ON c.otterId = o.clientId\n"
         . "INNER JOIN `oe_product` p\n"
         . "ON p.productId = op.productId\n"
		 . "ORDER BY c.lastName";
	
	uiOrderHistory(fetchAllRecords($sql));
}

function getClientOrders($client) {

	$sql = "SELECT * FROM `oe_order` o \n" 
	       . "INNER JOIN `oe_client` c\n"
	       . "ON c.otterId = o.clientId\n"
	       . "WHERE c.lastName = :client";
	
	//The named parameters for this call	   
	$parameters = array();
	$parameters[':client'] = $client;
	
	//Call the function for UI output
	uiClientOrders(fetchAllRecords($sql, $parameters));
}

function getAllClients() {
	
	$sql = "SELECT c.otterId,\n"
           . " c.firstName,\n"
           . " c.lastName,\n"
           . " c.phone,\n"
           . " c.email,\n"
           . " c.officeNumber,\n"
           . " s.collegeName,\n"
           . " b.buildingName,\n"
           . " b.buildingNumber\n"
           . "FROM `oe_client` c\n"
           . "INNER JOIN `oe_building` b\n"
           . "ON c.buildingId = b.buildingId\n"
           . "INNER JOIN `oe_college` s\n"
           . "ON c.collegeId = s.collegeId";
	
	uiAllClients(fetchAllRecords($sql));	
}

function getClientsWithoutOrders()
{
	$sql = "SELECT c.otterId, c.firstName,\n"
    . "c.lastName, c.phone, c.email,\n"
    . "b.buildingName, b.buildingNumber\n"
    . "FROM `oe_client` c\n"
    . "LEFT JOIN `oe_order` o\n"
    . "ON c.otterId = o.clientId\n"
    . "INNER JOIN `oe_building` b\n"
    . "ON c.buildingId = b.buildingId\n"
    . "WHERE o.orderId IS NULL\n"
    . "ORDER BY c.lastName";
	
	uiClentsWithoutOrders(fetchAllRecords($sql));
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
