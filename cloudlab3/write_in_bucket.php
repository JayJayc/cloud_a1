<?php

$test = fopen("gs://s3600396-storage/test.txt",'w');
$number = (int)htmlspecialchars($_POST["name"]);
echo "my number is $number";
$file_name = "gs://s3600396-storage/fibonacci_{$number}.txt";
echo "file name is $file_name";
$handle = fopen("$file_name",'w');
fwrite($handle, $number);
$f1 = 0;
$f2 = 1;
for($i = 1; $i <= $number; $i = $i ++) {
    fwrite($handle, ", ".$f2);
    $next = $f1 + $f2;
    $f1 = $f2;
    $f2 = $next;
}

fclose($handle);
