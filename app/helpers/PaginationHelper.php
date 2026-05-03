<?php

function renderPagination($total, $limit, $page) {
    $totalPages = ceil($total / $limit);

    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<a href='public_entry.php?url=users&page=$i'> $i </a> ";
    }
}