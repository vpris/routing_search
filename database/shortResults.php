<?php

assert_options(ASSERT_WARNING, 0);

// Include the api class
Require('vendor/autoload.php');

$perpage = 50;

// Include the file which contains the function to display results
$client = new SphinxClient();

// Set search options
$client->SetServer('127.0.0.1', 9312);
$client->SetRetries(1);
$client->SetConnectTimeout(1);
$client->SetMatchMode(SPH_MATCH_BOOLEAN);
$client->SetArrayResult(true);
$client->SetLimits (($page-1)*$perpage,$perpage);

$q = !empty($_GET['term']) ? $_GET['term'] : '';

// Compute the pagination
$client->setLimits(0,$perpage*20);

display_results(
    $result = $client->Query($q));
if ( !$result )
{
    print "<div class='errorLast'>ERROR: " . $client->GetLastError() . "</div>";
}
    else
{
    $totalRecords = $result[total_found];
    print "<div class='resultCount'>Найдено результатов: $totalRecords.\n" . "</div>";
    $n = 1;
}

$current_page = 1;
$tot_pages = 10;





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
    $post_stmt->bindParam(':id', $result['id'], PDO::PARAM_INT);
    $post_stmt->execute();
    $post = $post_stmt->fetch(PDO::FETCH_ASSOC);

    // Переменные, чтобы меньше текста писать и сохранить красивый html-код.
    $clicks           = "{$post['clicks']}";
    $url              = "{$post['url']}";
    $title            = "{$post['title']}";
    $AdOrOther        = "{$post['AdOrOther']}";
    $autorizationMeth = "{$post['autorizationMeth']}";
    $groupsApp        = "{$post['groupsApp']}";
    $keywords         = "{$post['keywords']}";
    $content          = "{$post['content']}";

    // Вывод title, content и любых других полей по желанию
    $resultH = "
    <div class='mainResultsSection'>
            <div class='searchResult'>
                <div class='searchResultHead'>
                    <div class='titleLink'><a class='result' href='$url'>$title</a></div>
                    <button class='showMore btn btn-info'><i class='fa fa-ellipsis-h' aria-hidden='true'></i></button>";
    if ($clicks >= 100) {
        $resultH .= " <img title='Популярная запись' src='assets/icons/burn.png' alt='Огонек 1' class='resultImage'> ";
    }
    $resultH .= "   <div class='rightBlocks'>
                        <div class='adOrOther'>$AdOrOther</div>
                        <div class='autorizationMeth'>$autorizationMeth</div>
                        <div class='groupsApp' title='$groupsApp'>$groupsApp</div>
                    </div>
                </div>
                <span class='postContent'>Теги: $keywords</span><br>
                <span class='content'>$content</span>

            </div>
    </div>
    ";
    print $resultH;
}

}



    ?>
