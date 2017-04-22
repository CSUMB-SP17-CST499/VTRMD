<?php
/*
 * We inlcude our database connection string here.
 * PDO is used to to allow cross-platform connections without
 * needing to write addtional SQL code
 * 
 * Include our connection to the RDBMS
 */
include_once "conn.inc.php";
include_once "./config/smtp.config.inc.php";

/*
 * Used to fetch a data table from the database
 */
function fetchAllRecords($sql, $namedParameters = array()) {

	$conn = createConn();

	try {	
	    //Prepare the sql and execute the statment

            $query = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $query -> execute($namedParameters);
            //Retieve all the rows
            $records = $query -> fetchAll(PDO::FETCH_ASSOC);

	} catch(Exception $ex) {
            //Log the error and send email
            $mailError = new SMTPService(
                    smtpConf::getErrorSendToAddress(),
                    $ex->getMessage(),
                    "VTRMD: fetchAllRecords() Exception Occurred!");
            
            if($mailError->sendMail()){
             //TODO: Log send to database   
            }
            
            $records = null; //set null for caller
	
	}
	
	return $records;
}

/*
 * Used to fetch a record from the database
 */
function fetchRecord($sql, $namedParameters = array()) {

	$conn = createConn();

	try {
		
		//Prepare the sql and execute the statment
		$query = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$query -> execute($namedParameters);
		//Retieve all the rows
		$record = $query -> fetch(PDO::FETCH_ASSOC);

	} catch(Exception $ex) {
	    //Log the error and send email
            $mailError = new SMTPService(
                    smtpConf::getErrorSendToAddress(),
                    $ex->getMessage(),
                    "VTRMD: fetchRecord() Exception Occurred!");
            
            if($mailError->sendMail()){
             //TODO: Log send to database   
            }


		$record = null; //set null for caller
	} 

	return $record;
}

/*
 * Used to insert a record into the database
 */
function insertRecord($sql, $namedParameters = array()) {
	
	$conn = createSqlConn();
	
	try {
		
		//Prepare the sql and execute the statment
		$prepedPDO = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$isInserted = $prepedPDO -> execute($namedParameters);
	
	} catch(Exception $ex) {
            //Log the error and send email
            $mailError = new SMTPService(
                    smtpConf::getErrorSendToAddress(),
                    $ex->getMessage(),
                    "VTRMD: insertRecord() Exception Occurred!");
            
            if($mailError->sendMail()){
             //TODO: Log send to database   
            }

		
		$isInserted = false;
	}

	return $isInserted;
}


?>
