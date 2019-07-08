<?php
require('.ht.src/database/globalVariables.php');

session_start();
$get=$_SESSION['s'];
require ('.ht.src/classes/checkCondition.php');
$db = new checkingCondition;
$db->checkCond($get, $memberof);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Routing</title>
    <meta name="description" content="Search the web for information and images.">
    <meta name="keywords" content="Search engine, routing, websites">
    <meta name="author" content="Chuck Tornton">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/routing/public/assets/css/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="/routing/public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/routing/public/assets/css/style.css">
    <link href="/routing/public/assets/css/jquery-ui.css" type="text/css" rel="stylesheet">
    <script src="/routing/public/assets/js/jquery-3.3.1.slim.min.js"></script>
    <script src="/routing/public/assets/js/jquery-ui.js"></script>
</head>
<body>
<div class="overlay"></div>
<div class="wrapperIndex indexPage">
    <div class="mainSection">
        <div class="logoContainer">
            <h1>ROUTING</h1>
        </div>
        <div class="searchContainer">
            <form action="/routing/public/display_results.php" method="GET">
                <div class="searchBarCont">
                    <input class="searchBox" id="autocomplete_input" autocomplete="off"
                           placeholder="Приложение, отв.группа, слово из текста, а также сервер и др." type="search"
                           name="term" autofocus>
                    <button class="searchButton" type="submit"> <!-- <img src='assets/icons/search1.png'> --></button>
                </div>
                <div class="searchBarTextCont"><p>Легко начать. Введите запрос, например: <span class="searchBarWord"><a
                                    href="<?= $searchLinkWord . $randSearchWord ?>"><?= $randSearchWord ?></a></span>
                    </p></div>
            </form>
            <div class="collapse" id="collapseExample">
                <div class="card card-body popularQueryes">
                    <button class="popularQueryesPhrase"><a
                                href="<?= $searchLinkWord . $randSearchWord ?>"><?= $randSearchWord ?> </a></button>
                    <button class="popularQueryesPhrase"><a
                                href="<?= $searchLinkWord . $siebelWord ?>"><?= $siebelWord ?> </a></button>
                    <button class="popularQueryesPhrase"><a
                                href="<?= $searchLinkWord . $locadmin ?>"><?= $locadmin ?> </a></button>
                    <button class="popularQueryesPhrase"><a
                                href="<?= $searchLinkWord . $secretWord ?>"><?= $secretWord ?> </a></button>
                </div>
            </div>
        </div>
        <a class="popularQ" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
           aria-controls="collapseExample">
            <div class="UpChevron"></div>
            <span>Также часто ищут</span>
        </a>
    </div>
</div>
<script src="/routing/public/assets/js/bootstrap.min.js"></script>
<script src="/routing/public/assets/js/popper.min.js"></script>
<script type="text/javascript" src="/routing/public/assets/js/script.js"></script>
</body>
</html>