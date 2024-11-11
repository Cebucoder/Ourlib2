<?php
function get_includes($part) {
    $file_path = __DIR__ . "/includes/" . $part . ".php";
    if (file_exists($file_path)) {
        include $file_path;
    } else {
        echo "Error: Could not find file $file_path";
    }
}

function get_library($part) {
    $file_path = __DIR__ . "/library/" . $part . ".php";
    if (file_exists($file_path)) {
        include $file_path;
    } else {
        echo "Error: Could not find file $file_path";
    }
}
?>
