<?php

function renderPagination($total, $limit, $page) {
    $totalPages = ceil($total / $limit);

    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $page) {
            echo "<strong>$i</strong> ";
        } else {
            echo "<a href='public_entry.php?url=users&page=$i'>$i</a> ";
        }
    }
}