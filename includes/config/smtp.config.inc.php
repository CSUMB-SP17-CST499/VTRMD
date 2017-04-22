<?php
/**
 * Description of smtp
 *
 * @author rciampa
 */
class smtpConf {
    private $siteAdministrator = "Richard Ciampa <rciampa@csumb.edu>";
    
    public static function getErrorSendToAddress(){
        return $this->siteAdministrator;    
    }
    
}
