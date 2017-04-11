<?php
/*
 * We inlcude our database connection string here.
 * PDO is used to to allow cross-platform connections without
 * needing to write addtional SQL code
 * 
 * Include our connection to the RDBMS
 */
include_once "conn.inc.php";

/*
 * Used to fetch a data table from the database
 */
function fetchAllRecords($sql, $namedParameters = array()) {
		
	$conn = createConn();

	//Prepare the sql and execute the statment
	$query = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$query -> execute($namedParameters);
	//Retieve all the rows
	$records = $query -> fetchAll(PDO::FETCH_ASSOC);
	
	$conn = NULL;
	
	return $records;
}

/*
 * Used to fetch a record from the database
 */
function fetchRecord($sql, $namedParameters = array()) {
		
	$conn = createConn();

	//Prepare the sql and execute the statment
	$query = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$query -> execute($namedParameters);
	//Retieve all the rows
	$record = $query -> fetch(PDO::FETCH_ASSOC);
	
	$conn = NULL;
	
	return $record;
}

/*
 * Used to insert a record into the database
 */
function insertRecord($sql, $namedParameters = array()) {
	
	$conn = createSqlConn();
	//Prepare the sql and execute the statment
	$scalar = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$scalar -> execute($namedParameters);
	
}


?>
