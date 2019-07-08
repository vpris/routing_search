<?php

class checkingCondition {
    
    // Function is checking condition 
    function checkCond($get, $memberof) {

        if ($get == NULL) {
            header('Location: /routing/index.php');
        }
        
        $memberof = $get[0]["memberof"];
        
        if (in_array("CN=RBRU-IT_Division All,OU=Distribution,OU=Role Based Access Permissions,OU=_Groups,DC=raiffeisen,DC=ru", $memberof)) {
            //echo "Ищем наличие группы: IT HD_level0" . "<br>";
            //echo "Нашел: IT HD_level0" . "<br>";
        } else {
            header('Location: /routing/index.php');
        }
    }
}