<?php
function getTotalRow($dbh, $sql) {
    $stmt = $dbh -> prepare($sql);
    $stmt -> execute();
    $row = $stmt -> fetch();
    return $row['Total'];
}

function getTotalPage($totalRow, $limit) {
    return $totalRow == 0 ? 1 : ceil($totalRow / $limit); 
}

function getBeginPage($segment, $numPage) {
    return $segment == 1 ? 1 : ($segment - 1) * $numPage + 1;
}

function getEndPage($beginPage, $numPage, $totalPage) {
    return $beginPage + $numPage - 1 < $totalPage ? $beginPage + $numPage - 1 : $totalPage;
}

function getCurrentPage($currentPage, $beginPage) {
    return $currentPage < $beginPage ? $beginPage : $currentPage;
}

function getStartRow($currentPage, $limit) {
    return $currentPage == 1 ? 0 : ($currentPage - 1) * $limit;
}
?>