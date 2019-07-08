<?php

session_start();
$get=$_SESSION['s'];
require ('../.ht.src/classes/checkCondition.php');
$db = new checkingCondition;
$db->checkCond($get, $memberof);

if(isset($_GET["term"])) {
	$printTerm = $_GET["term"];
}
else {
    exit("Нужно вернуться к поиску");
}
$type = isset($_GET["type"]) ? $_GET["type"] : "sites";
$page = isset($_GET["page"]) ? $_GET["page"] : 1;


require('../.ht.src/database/conf.php');
require('../.ht.src/database/queryes.php');
?>



<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>New Routing Search</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link href="assets/css/jquery-ui.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script src="assets/js/jquery-3.3.1.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.fancybox.min.js"></script>
    <script src="assets/js/jquery-ui.js"></script>
    <script type="text/javascript" src="assets/js/script.js"></script>
</head>
<body>
    <div class='headName'>
        <?php
            print ($get["0"]["extensionattribute1"]["0"]) . ' ' . ($get["0"]["extensionattribute2"]["0"]);
        ?>
    </div>
    <div class="wrapper">
            <div class="header">
                <div class="headerContent">
                    <div class="logoContainer">
                        <a href="../main.php">
                            <H2>ROUTING</H2>
                        </a>
                        <a href="https://confluence.raiffeisen.ru/display/SDesk/Routing" target="_blank"><button class="forkOnConfl"> Страница обсуждения в Confluence</button></a>
                    </div>
                    <div class="searchContainer">
                        <form action="display_images_results.php" method="GET">
                            <div class="searchBarContainer">
                                <input type="hidden" name="type" value="<?php echo $type; ?>">
                                <input class="searchBox" id="autocomplete_input" type="text" name="term" value="<?php echo $printTerm; ?>" autocomplete="off">
                                <button class="searchPageButton" type="submit"></button>
                            </div>
                        </form>
                    </div>
                    <div class="modalSearchHelp">
                        <!-- Button trigger modal -->
                        <button type="button" class="toolTip" data-toggle="modal" data-target="#exampleModal">
                            <img src="assets/icons/info.png">
                                Подсказка по поиску
                            <img src="assets/icons/info.png">
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Краткая справка по операторам поиска</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="operatorsDefault">
                                            По-умолчанию работает оператор <kbd>AND</kbd>.<br> Если вы ищите, <kbd> ABS поддержка </kbd>, то система ищет слово <kbd>ABS</kbd>, в одной записи с которым находится слово <kbd>Поддержка</kbd>. Это уменьшает круг вашего поиска.
                                        </div>
                                        <hr>
                                        Для более точной фильтрации существуют следующие операторы:
                                        <hr>
                                        <span class="operators">Кавычки:</span> Обозначается двойными кавычками <kbd>" "</kbd>.
                                        Это крайне важно, когда вы хотите найти фразу целиком <kbd>"L1_SD Level 1 → L1_SD Collaboration"</kbd>. Если вбить в таком виде, то получим совпадения только с таким текстом.
                                        <hr>
                                        <span class="operators">Оператор OR (или):</span> Обозначается вертикальной чертой <kbd>|</kbd>.
                                        Например: <kbd>Siebel | ABS</kbd>. Означает: "найти совпадения по Siebel или ABS".
                                        <hr>
                                        <span class="operators">Оператор NOT (не):</span> Обозначается <kbd>!</kbd> или <kbd>-</kbd>.
                                        Например: <kbd>Siebel !corporate</kbd> или <kbd>Siebel -corporate</kbd>. Что значит: "найти Siebel, который не содержит corporate"
                                        <hr>
                                        <span class="operators">Группировка:</span>В Routing Search есть возможность группировать запросы. Осуществляется внесением запросов в скобки <kbd>( Siebel )</kbd>.
                                            Пример использования: <kbd>(Siebel !corporate) | (ABS-4 !выписки)</kbd>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tabsContainer">
                    <ul class="tabList">
                        <li class="<?php echo $type == 'sites' ? 'active' : '' ?>" title='Поиск по роутингу'>
                            <a href='<?php echo "display_results.php?term=$printTerm&type=sites"; ?>'>
                                Страницы
                            </a>
                        </li>
                        <li class="<?php echo $type == 'ucmdb' ? 'active' : '' ?>" title='Поиск по ucmdb'>
                            <a href='<?php echo "display_ucmdb_results.php?term=$printTerm&type=ucmdb"; ?>'>
                                uCMDB
                            </a>
                        </li>
                        <li class="<?php echo $type == 'confluence' ? 'active' : '' ?>" title='Поиск по confluence'>
                            <a href='<?php echo "display_confluence_results.php?term=$printTerm&type=confluence"; ?>'>
                                Confluence
                            </a>
                        </li>
                        <li class="<?php echo $type == 'images' ? 'active' : '' ?>" title='Поиск по изображениям роутинга'>
                            <a href='<?php echo "display_images_results.php?term=$printTerm&type=images"; ?>'>
                                Изображения
                            </a>
                        </li>
                    </ul>
                </div>
            </div>


                    <?php

                    if($type == "sites") {
                        require('../.ht.src/database/shortResults.php');
                    }
                    elseif($type == "ucmdb") {
                        include('../.ht.src/cmdb_confl/searchCmdb.php');
                    }
                    elseif($type == "confluence") {
                        include('../.ht.src/cmdb_confl/searchConfluence.php');
                    }
                    else {
                        print "<div class='imageWrap'>";
                            include('../.ht.src/database/shortResultsImages.php');
                        print "</div>";
                    }

                    ?>
    </div>
</body>
</html>
