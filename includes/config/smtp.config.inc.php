<?php
/**
 * Description of smtp
 *
 * @author rciampa
 */
class smtpConf {
    private static $siteAdministrator = "Richard Ciampa <rciampa@csumb.edu>";
    
    public function __construct() {
    }


    public static function getErrorSendToAddress(){
        return self::$siteAdministrator;    
    }
    
}
