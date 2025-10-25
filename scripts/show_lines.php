<?php
$path = __DIR__ . '/../routes/web.php';
$lines = file($path);
$start = 130; $end = 165;
for ($i = $start - 1; $i < $end; $i++) {
    printf("%4d: %s", $i+1, $lines[$i]);
}
