<?php
assert_options(ASSERT_WARNING, 0);
// Include the api class
Require('vendor/autoload.php');
// Include the file which contains the function to display results
$client = new SphinxClient();
// Set search options
$client->SetServer('127.0.0.1', 9312);
$client->SetConnectTimeout(1);
$client->SetArrayResult(true);

// SPH_MATCH_ALL mode will be used by default
// and we need not set it explicitly
$client->SetMatchMode(SPH_MATCH_BOOLEAN);
$page = 1;

if (isset($_GET['page'])) { $page = $_GET['page']; }

$numRecPerPage = 12;

if ($page > 0) { $startFrom = ($page-1) * $numRecPerPage; }
$client->SetLimits($page, $numRecPerPage, 0, 0);
$q = !empty($_GET['term']) ? $_GET['term'] : '';

display_results(
    $result = $client->Query($q));
if ( !$result )
{
// handle errors
    print "<div class='errorLast'>ERROR: " . $client->GetLastError() . "</div>";

}
else
{
    $totalRecords = $result[total_found];
// query OK, pretty-print the result set
// begin with general statistics
// $got = count ( $result["matches"] );
    print "<div class='resultCount'>Найдено результатов: $totalRecords.\n";
    //   print "Показаны совпадения: с 1 по $got из $result[total].\n</div>";
// print out matches themselves now
    $n = 1;
}

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
                <div id='searchResult'>
                    <div class='searchResultHead'>
                        <div class='titleLink'><a class='result' href='$url'>$title</a></div>";
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

// Pagination Logic start from here
if ($totalRecords > $numRecPerPage) {
    $totalPages = ceil($totalRecords / $numRecPerPage);
    $startLoop = 1;
     $endLoop = $totalPages;
    if ( $totalPages > 6) {
        $endLoop = 6;
    }
    $page = $_GET['page'];
    $endPage = $page+1;
    if ($page >= 4) {
        $startLoop = $page - 3;
        $endLoop = $page + 3;
        if ($endLoop > $totalPages) {
            $startLoop = $totalPages - 6;
            $endLoop = $totalPages;
        }
        if ($startLoop < 1) {
            $startLoop = 1;

        }
    }
    if ($page > 1) {
        $prePage = $page - 1;
        echo "<a href='display_results.php?type=sites&term=$printTerm&page=1'>".'<<'."</a> ";
        echo "<a href='display_results.php?type=sites&term=$printTerm&page=$prePage'>".'<'."</a> ";
    }
    for ($i=$startLoop; $i<=$endLoop; $i++) {
        $class ="";

        if ($i == $page) { $class ="class='activeClass'"; }

        if ($page == $i ) { echo "<a href='javascript:void(0);' $class> ".$i; } else { echo "<a href='display_results.php?type=sites&term=$printTerm&page=".$i."' $class> ".$i; }

        if ($i < $endLoop) { echo  "  </a> ";  } else { echo "</a>"; }
    }
    if ($endPage <= $totalPages  ) {
        echo "<a href='display_results.php?type=sites&term=$printTerm&page=$endPage'>".'>'."</a> "; // Goto last page
        echo "<a href='display_results.php?type=sites&term=$printTerm&page=$totalPages'>".'>>'."</a> ";
    }
    echo '<br/>';
    echo '<br/>';
}
echo 'Total Number of Records: '. $totalRecords;
// Pagination Logic end from here
