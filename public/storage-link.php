<?php
// Run this only once, then delete the file for security.

$target = __DIR__ . '/storage/app/public';
$link = __DIR__ . '/public/storage';

if (file_exists($link)) {
    echo "Symlink already exists: $link";
} else {
    if (symlink($target, $link)) {
        echo "Symlink created successfully!<br>";
        echo "Target: $target<br>";
        echo "Link: $link<br>";
    } else {
        echo "Failed to create symlink. Your hosting may not allow it.";
    }
}
