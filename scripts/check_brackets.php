<?php
$path = __DIR__ . '/../routes/web.php';
$content = file_get_contents($path);
$stack = [];
$pairs = [')'=>'(', ']'=>'[', '}'=>'{'];
$len = strlen($content);
for ($i=0;$i<$len;$i++){
    $ch = $content[$i];
    if ($ch==='('||$ch==='['||$ch==='{'){
        $stack[] = ['char'=>$ch,'pos'=>$i];
    } elseif ($ch===')'||$ch===']'||$ch==='}'){
        if (empty($stack)){
            echo "Unmatched closing $ch at position $i\n";
            exit(1);
        }
        $top = array_pop($stack);
        if ($pairs[$ch] !== $top['char']){
            echo "Mismatched closing $ch at position $i (expected closing for {$top['char']})\n";
            // show context
            $before = substr($content, max(0,$top['pos']-40), min(80, $i-$top['pos']+40));
            echo "Context around opening: ...$before...\n";
            exit(1);
        }
    }
}
if (!empty($stack)){
    foreach($stack as $s){
        echo "Unclosed {$s['char']} at byte position {$s['pos']}\n";
    }
    exit(1);
}
echo "Brackets look balanced.\n";
