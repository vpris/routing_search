<?php
//error_reporting(0);
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
$host = 's-msk20-adc001.raiffeisen.ru';
$port = '389';

if (isset($_POST['submit']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $dn = 'ou=_Users,dc=raiffeisen,dc=ru';
    $baseGroup = 'OU=Distribution,OU=_Groups,DC=raiffeisen,DC=ru';
    $memberGroupPath = "CN=RBAC-Sec-IT Service Desk,";
    $userDomain = 'raiffeisen.ru';
    $filter="(samaccountname=$username)";

    // Connect to LDAP server
    $ldap = ldap_connect($host, $port);

    if (!$ldap) 
    {
        $error = 'Нет подключения к LDAP-серверу';
    } else 
    {
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
        $bind = ldap_bind($ldap, $username.'@'.$userDomain, $password) or print('<div class="error">' . 'Ошибка.' . '</div>');
        ldap_get_option($ldap, LDAP_OPT_DIAGNOSTIC_MESSAGE, $extended_error);
    }

    if ($bind)
    {
        //determine the LDAP Path from Active Directory details
        $result = ldap_search($ldap, $dn, $filter);
        $entries = ldap_get_entries($ldap,$result);
        
        if (!$result)
            $error = 'Result: '. ldap_error($ldap);
        else
        {
            session_start();
            $justthese = array("extensionAttribute1", "extensionAttribute2", "ou", "sn", "samaccountname", "memberOf", "givenname", "mail",);
            //$justthese = "sAMAccountType";
            $sr=ldap_search($ldap, $dn, $filter, $justthese);
            $info = ldap_get_entries($ldap, $sr);
            ldap_unbind($ldap);

            // проверяем группу
            $memberof = $info[0]['memberof'];

            $uName = ($info["0"]["extensionattribute1"]["0"]) . ' ' . ($info["0"]["extensionattribute2"]["0"]);

            if (in_array("CN=RBRU-IT_Division All,OU=Distribution,OU=Role Based Access Permissions,OU=_Groups,DC=raiffeisen,DC=ru", $memberof)) {
                $_SESSION['s']=$info;
                header('Location: \routing\public\successAuth.php'); 
            } else { 
                print '<div class="error">' . 'Здравствуйте, ' . $uName . '!' . '<br>' . 'У Вас нет нужной группы. Доступ только для IT. Если Вам действительно нужен доступ к Routing-порталу, можете запросить его.' . '</div>';
                return false;
            }
        }
    }

}

?>
