<?php

// Include the api class
Require('D:/server/data/htdocs/routing/vendor/autoload.php');
// Include the file which contains the function to display results
$client = new SphinxClient();
// Set search options
$client->SetServer('127.0.0.1', 9312);
$client->SetConnectTimeout(1);
$client->SetArrayResult(true);
// SPH_MATCH_ALL mode will be used by default
// and we need not set it explicitly
$client->SetMatchMode(SPH_MATCH_BOOLEAN);
(isset($_GET['page']) && int_check($_GET['page']) && $_GET['page'] > 0) ? $page = $_GET['page'] - 1 : $page = 0;
$client->SetLimits($page, 28);
$q = !empty($_GET['term']) ? $_GET['term'] : '';
display_results(
    $result = $client->Query($q));

// Функция показа результатов в красивом формате
function display_results($results, $message = null)
{
    global $post_stmt, $cat_stmt;
    if ($message) {
        print "<h3>$message</h3>";
    }
    if (!isset($results['matches'])) {
        print "<div class='mainResultsSection'>
                    <div class='notFound'>
                        Ошибка! Попробуйте изменить запрос. Допускается поиск неполного слова.
                    </div>
                </div>
                ";
        return;
    }

    foreach ($results['matches'] as $result) {
        // Получение данных для этого документа (поста) из базы данных
        $post_stmt->bindParam(':id',
            $result['id'],
            PDO::PARAM_INT);
        $post_stmt->execute();
        $post = $post_stmt->fetch(PDO::FETCH_ASSOC);

        // Переменные, чтобы меньше текста писать и сохранить красивый html-код.
        $clicks = "{$post['clicks']}";
        $url = "{$post['url']}";
        $title = "{$post['title']}";
        $imageLink = "{$post['imageLink']}";
        $alt = "{$post['alt']}";


        // Вывод title, content и любых других полей по желанию

        $resultImage = "<div class='imageResults'>";

        $resultImage .= "
                            <a href='$imageLink' target='_blank'>
                                <img src='$imageLink' alt='$alt'>
                            </a>
                            ";

        $resultImage .= "</div>";


        if(!empty ($imageLink)) {
            print $resultImage;
        }
    }
}