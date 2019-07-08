<?php

session_start();
$get=$_SESSION['s'];
require ('../.ht.src/classes/checkCondition.php');
$db = new checkingCondition;
$db->checkCond($get, $memberof);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/styleLdap.css">
</head>
<body>
    <div class="wrapper">
        <form action="../main.php">   
            <div class="loginSuccessBlock">
                <div class="welcome">
                    Добро пожаловать, 
                </div>
                <div class="welcomeName">
                    <?php
                    print ($get["0"]["extensionattribute1"]["0"]) . ' ' . ($get["0"]["extensionattribute2"]["0"]);
                    ?>
                </div>
                <div class="welcomeAuth">Авторизация успешна.</div>
                <a href=""><button type="submit" name="submit" id="submitButton" onclick="return loginForm()">Перейти к роутингу</button></a>
            </div>
        </form>
    </div>
</body>
</html>