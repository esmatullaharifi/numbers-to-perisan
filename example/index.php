<?php

include('../src/NumbersToPersianConverter.php');

use Arifi\NumbersToPersianConverter;

$string = new NumbersToPersianConverter();
$number = 123.43;
echo $string->convert($number);
