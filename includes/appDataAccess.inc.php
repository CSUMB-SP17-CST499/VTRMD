<?php
/**
 * Description of appDataAccess.inc.php: 
 *
 * @author rciampa
 */

include_once 'genericDataAccess.inc.php';


/*
 * Inserts record rows into the dv_test_locations table. The dv_test_locations
 * table is the first set in mormalization.
 */
function insertLocation($master_id, $location_id, $lat, $long)
{

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
function insertCalSpeedData($data)
{
    
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

/*
 * Retrieves a set of test by location id in the CalSpeed database table
 * the field used is Location_ID.
 */
function getTestDataByLocation($locationId)
{

	$sql = "SELECT * FROM `dv_calspeed_data` \n"
               . "WHERE `dv_calspeed_data`.`LocationID` = :LocationID";
	
	//The named parameters for this call	   
	$parameters = array();
	$parameters[':LocationID'] = $locationId;
        
	
	//Call the function for output
	$results = fetchAllRecords($sql, $parameters);
        
        return $results;
}

/*
 * Retieves all the test locations that are currently held in the CalSpeed
 * databse.
 */
function getAllTestLocations()
{

	$sql = "SELECT \n"
                . "`Master_ID`, \n"
                . "`LocationID`, \n"
                . "X(`Geo_location`) AS Latitiude, \n"
                . "Y(`Geo_location`) AS Longitude, \n"
                . "`Updated` \n"
                . "FROM `dv_test_locations` \n"
                . "WHERE 1;";
           
	//Call the function for output
	$results = fetchAllRecords($sql);
        
        return $results;
}

/*
 * Creates the associative array for the dashboard. The dashboard holds
 * the metadata about the current dataset in the CalSpeed database. 
 */
function getDashboard()
{
	
	$dashboardItems = array();
	
	//Get the total number of records in the CalSpeed database
	$dashboardItems['Total Record Count'] = getTotalNumberOfRecords();
	//Get the average total RTT time for the California West tests
	$dashboardItems['California West Total RTT Average'] = 
                getAverageCaliforniaWestRttEndToEnd();
	//Get the average total RTT time for the East Coast test 
	$dashboardItems['East Coast Total RTT Average'] = 
                getAverageEastCostRttEndToEnd();
	//Get the number of Healthy Choices in OE
	$dashboardItems['Oregon West Total RTT Average'] =
                getAverageOregonWestRttEndToEnd();
	//Get the gross sales to date
	$dashboardItems['Gross Sales to Date'] = getGrossSalesToDate();
	
	return $dashboardItems;
}

/*
 * Fetches the total number of records in the visualization database.
 * This query only fetches records rows which are based on master_id.
 * The real number of tests 
 */
function getTotalNumberOfRecords()
{
	
	$sql = "SELECT COUNT(`*`) \n"
             . "AS 'total_records' \n"
             . "FROM `dv_test_locations` \n"
             . "WHERE 1;";
	
	$record = fetchRecord($sql);
	
	return $record['total_records'];
}


function getAverageOfcwStartRTT($dec_places = 2)
{
	$sql = "SELECT AVG(`cwStartRTT`) AS Average \n"
             . "FROM `dv_calspeed_data` WHERE 1;";
	
	$result = fetchRecord($sql);
	
	return number_format($result['Avgerage'], $dec_places);
	
}

/*
 * Gets the average round trip time (RTT) for all the California West
 * tests in the CalSpeed database.
 */
function getAverageCaliforniaWestRttEndToEnd($dec_places = 2)
{
    $sql = "SELECT AVG(`cwStartRTT` + `cwTnRTT1` + `cwTnRTT2` + `cwTnRTT3` + \n"
         . "`cwTnRTT4` + `cwTnRTT5` + `cwTnRTT6` + `cwTnRTT7`\n"
         . " + `cwTnRTT8` + `cwTnRTT9` + `cwTnRTT10` + `cwEndRTT`) AS CWRTT_AVG \n"
         . "FROM `dv_calspeed_data` WHERE 1;";
    
           
    $result = fetchRecord($sql);
    
    return number_format($result['CWRTT_AVG'], $dec_places);
}

/*
 * Gets the average round trip time (RTT) for all the East Coast
 * tests in the CalSpeed database.
 */
function getAverageEastCoastRttEndToEnd($dec_places = 2)
{
    $sql = "SELECT AVG(`eStartRTT` + `eTnRTT1` + `eTnRTT2` + `eTnRTT3` + \n"
         . "`eTnRTT4` + `eTnRTT5` + `eTnRTT6` + `eTnRTT7`\n"
         . " + `eTnRTT8` + `eTnRTT9` + `eTnRTT10` + `eEndRTT`) AS EASTRTT_AVG \n"
         . "FROM `dv_calspeed_data` WHERE 1;";
		 
	$result = fetchRecord($sql);
	
	return number_format($result['EASTRTT_AVG'], $dec_places);
}

/*
 * Gets the average round trip time (RTT) for all the Oregon West
 * tests in the CalSpeed database.
 */
function getAverageOregonWestRttEndToEnd($dec_places = 2)
{
    $sql = "SELECT AVG(`owStartRTT` + `owTnRTT1` + `owTnRTT2` + `owTnRTT3` + \n"
         . "`owTnRTT4` + `owTnRTT5` + `owTnRTT6` + `owTnRTT7`\n"
         . " + `owTnRTT8` + `owTnRTT9` + `owTnRTT10` + `owEndRTT`) \n"
         . "AS OWRTT_AVG FROM `dv_calspeed_data` WHERE 1;";
    
    $result = fetchRecord($sql);
		   
    return number_format($result['OWRTT_AVG'], $dec_places);
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
