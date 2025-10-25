<?php
$s=file_get_contents(__DIR__ . '/../routes/web.php');
echo "len=".strlen($s)."\n";
echo substr($s,7400,200);