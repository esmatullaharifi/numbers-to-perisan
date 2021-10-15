# Numbers to Persian/Dari words converter
Convert any number from 1 to 13 digits to Persian words

## Installation
You can install this package using composer.
```
$ composer require arifi/numbers-to-perisan
```

## Usage
Genrate random password.
```php
<?php

use Arifi\NumbersToPersianConverter;

$string = new NumbersToPersianConverter();
$number = 123;
echo $string->convert($number); // یک‌صد و بيست و سه

$number = 123.43;
echo $string->convert($number); // يك‌صد و بيست و سه عشاریه چهار سه
```