<?php

$primes = explode(",",
  file_get_contents('gs://sxxxxxx-storage/prime_numbers.txt')
);

$arrlength=count($primes);

for($x=0;$x<$arrlength;$x++)
{
  echo "The ". $x ."-th prime number is: ".$primes[$x]."<br>";

}
