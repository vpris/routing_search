<?php

    if(isset($_GET["term"])) {
        $printTerm = $_GET["term"];
    }
    else {
        exit("Нужно вернуться к поиску и ввести поисковую фразу." . "<br>" . "<a href='http://localhost/foundationProject/display_confluence_results.php?term=&type=confluence'>Назад к поиску</a>" );
    }
    $type = isset($_GET["type"]) ? $_GET["type"] : "sites";
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;

    $getChbx = $_GET['chbx'];
    $getChbxAtt = $_GET['chbxAtt'];

    // Скрипт чекбокса
    if(isset($getChbx) &&
        $getChbx == 'Yes')
    {
        $chbx = 'title';
    }
    else
    {
        $chbx = 'text';
    }

    if(isset($getChbxAtt) &&
        $getChbxAtt == 'Yes')
    {
        $chbxAtt = 'attachment';
    }
    else
    {
        $chbxAtt = 'page';
    }


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Routing Search</title>
    <script src="assets/js/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome-4.7.0/css/font-awesome.css">
    <script src="assets/js/jquery-3.3.1.slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.fancybox.min.js"></script>
</head>
<body>
<div class="wrapper">
        <div class="header confl">
            <div class="headerContent">
                <div class="logoContainer">
                    <a href="index.php">
                        <H2>ROUTING</H2>
                    </a>
                    <a href="https://confluence.raiffeisen.ru/display/SDesk/Routing" target="_blank"><button class="forkOnConfl">Страница обсуждения в Confluence</button></a>
                </div>
                <div class="searchContainer">
                    <form action="display_confluence_results.php" method="GET" class="searchContainerForm">
                        <div class="searchBarContainer">
                            <input type="hidden" name="type" value="<?php echo $type; ?>">
                            <input class="searchBox" id="autocomplete_input" type="search" name="term" value="<?php echo $_GET["term"]; ?>" autocomplete="off">
                            <button class="searchPageButton" type="submit"></button>
                        </div>
                        <div class='checkBoxes'>
                            Поиск по названию:
                            <div class="material-switch pull-right">
                                <input id="someSwitchOptionInfo" name="chbx" type="checkbox" value="Yes"/>
                                <label for="someSwitchOptionInfo" class="label-info"></label>
                            </div>
                            Поиск по вложениям:
                            <div class="material-switch pull-right">
                                <input id="someSwitchOptionInfoAtt" name="chbxAtt" type="checkbox" value="Yes"/>
                                <label for="someSwitchOptionInfoAtt" class="label-info"></label>
                            </div>
                        </div>
                    </form>
                    <div class="tabsConflContainer">
                        <ul class="tabList">
                            <li class="<?php echo $type == 'sites' ? 'active' : '' ?>" title='Поиск по роутингу'>
                                <a href='<?php echo "display_results.php?term=$printTerm&type=sites"; ?>'>
                                    Страницы
                                </a>
                            </li>
                            <li class="<?php echo $type == 'ucmdb' ? 'active' : '' ?>" title='Поиск по ucmdb'>
                                <a href='<?= "display_ucmdb_results.php?term=$printTerm&type=ucmdb"; ?>'>
                                    uCMDB
                                </a>
                            </li>
                            <li class="<?php echo $type == 'confluence' ? 'active' : '' ?>" title='Поиск по confluence'>
                                <a href='<?= "display_confluence_results.php?term=$printTerm&type=confluence"; ?>'>
                                    Confluence
                                </a>
                            </li>
                            <li class="<?= $type == 'images' ? 'active' : '' ?>" title='Поиск по изображениям роутинга'>
                                <a href='<?= "display_images_results.php?term=$printTerm&type=images"; ?>'>
                                    Изображения
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modalSearchHelp">
                    <!-- Button trigger modal -->
                    <button type="button" class="toolTips" data-toggle="modal" data-target="#exampleModal">
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
                                        Вы можете искать как полное слово, так и его часть. К примеру, если ввести: <kbd>mcaf</kbd> - найдет <kbd>mcafee</kbd>.
                                    </div>
                                    <hr>
                                    <div class="operatorsDefault">
                                        Также, можно искать основное слово и дополнительное по тексту.  К примеру, если ввести: <kbd>siebel лид</kbd> - найдет все статьи спейса, где указаны эти слова.
                                    </div>
                                    <hr>
                                    <div class="operatorsDefault">
                                        В поиске по Confluence работает оператор Not. Он позволяет исключать из поисковой выдачи статьи, где есть это слово.  К примеру, если ввести: <kbd>siebel !corporate</kbd> - найдет все статьи со словом Siebel, но в которых нет слова corporate.
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            if($type == "sites") {
                require('database/shortResults.php');
            }
            elseif($type == "ucmdb") {
                include('database/cmdb_confl/searchCmdb.php');
            }
            elseif($type == "confluence") {
                include('database/cmdb_confl/searchConfluence.php');
            }   
            else {
                include('database/shortResultsImages.php');
            }
        ?>
</body>
</html>
