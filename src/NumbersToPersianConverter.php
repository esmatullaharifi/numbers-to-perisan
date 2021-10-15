<?php
namespace Arifi;

class NumbersToPersianConverter
{
    private $numbersToWord = array (
        '0' => 'و' ,

        '1' => 'يك' ,
        '2' => 'دو' ,
        '3' => 'سه' ,
        '4' => 'چهار' ,
        '5' => 'پنج' ,
        '6' => 'شش' ,
        '7' => 'هفت' ,
        '8' => 'هشت' ,
        '9' => 'نه' ,

        '11' => 'يازده' ,
        '12' => 'دوازده' ,
        '13' => 'سيزده' ,
        '14' => 'چهارده' ,
        '15' => 'پانزده' ,
        '16' => 'شانزده' ,
        '17' => 'هفده' ,
        '18' => 'هجده' ,
        '19' => 'نوزده' ,

        '10' => 'ده' ,
        '20' => 'بيست' ,
        '30' => 'سی' ,
        '40' => 'چهل' ,
        '50' => 'پنجاه' ,
        '60' => 'شصت' ,
        '70' => 'هفتاد' ,
        '80' => 'هشتاد' ,
        '90' => 'نود' ,

        '100' => 'يك‌صد' ,
        '200' => 'دو‌صد' ,
        '300' => 'سه‌صد' ,
        '400' => 'چهار‌صد' ,
        '500' => 'پنج‌صد' ,
        '600' => 'شش‌صد' ,
        '700' => 'هفت‌صد' ,
        '800' => 'هشت‌صد' ,
        '900' => 'نه‌صد' ,

        't' => 'هزار' ,
        'm' => 'ميليون' ,
        'b' => 'ميليارد' ,
        'tr' => 'تريليون'
    );

    private function oneDigit($number)
    {
        return $this->numbersToWord[$number];
    }

    private function twoDigits($number)
    {
        if (fmod($number, 10) == 0 || ($number >= 11 && $number <= 19)) {
            $words =  $this->numbersToWord[$number];
        } else {
            $first = fmod($number, 10);
            $second = floor(($number / 10));
            $second *= 10 ;
            $words = $this->numbersToWord[$second] . ' ' . $this->numbersToWord[0] . ' ' . $this->numbersToWord[$first];
        }
        return $words;
    }

    private function threeDigits($number)
    {
        if (fmod($number, 100) == 0) {
            $words =  $this->numbersToWord[$number];
        } else {
            $first = fmod($number, 100);
            $second = floor(($number / 100));
            $second *= 100 ;
            if ($first >= 1 && $first <= 9) {
                $firstWord = $this->oneDigit($first);
            } else {
                $firstWord = $this->twoDigits($first);
            }
            $words = $this->numbersToWord[$second] . ' ' . $this->numbersToWord[0] . ' ' . $firstWord;
        }
        return $words;
    }

    private function oneToThreeDigits($number)
    {
        if ($number >= 1 && $number <= 9) {
            $words = $this->oneDigit($number);
        } elseif ($number >= 10 && $number <= 99) {
            $words = $this->twoDigits($number);
        } elseif ($number >= 100 && $number <= 999) {
            $words = $this->threeDigits($number);
        }
        return $words;
    }

    private function fourDigits($number)
    {
        if (fmod($number, 1000) == 0) {
            $number2 = $number/1000;
            $number3 = $this->oneToThreeDigits($number2);
            $words =  $number3 . ' ' . $this->numbersToWord['t'];
        } else {
            $first = fmod($number, 1000);
            $firstWord = $this->oneToThreeDigits($first);
            $second = floor(($number / 1000));
            $secondWord = $this->oneToThreeDigits($second);
            $words = $secondWord . ' ' . $this->numbersToWord['t'] . ' ' . $this->numbersToWord[0] . ' ' . $firstWord;
        }
        return $words;
    }

    private function sevenDigits($number)
    {
        if (fmod($number, 1000000) == 0) {
            $number2 = $number/1000000;
            $number3 = $this->oneToThreeDigits($number2);
            $words =  $number3 . ' ' . $this->numbersToWord['m'];
        } else {
            $first = fmod($number, 1000000);
            if ($first >= 1 && $first <= 999) {
                $firstWord = $this->oneToThreeDigits($first);
            } else {
                $firstWord = $this->fourDigits($first);
            }
            $second = floor(($number / 1000000));
            $secondWord = $this->oneToThreeDigits($second);
            $words = $secondWord . ' ' . $this->numbersToWord['m'] . ' ' . $this->numbersToWord[0] . ' ' . $firstWord;
        }
        return $words;
    }

    private function tenDigits($number)
    {
        if (fmod($number, 1000000000) == 0) {
            $number2 = $number/1000000000;
            $number3 = $this->oneToThreeDigits($number2);
            $words =  $number3 . ' ' . $this->numbersToWord['b'];
        } else {
            $first = fmod($number, 1000000000);
            if ($first >= 1 && $first <= 999) {
                $firstWord = $this->oneToThreeDigits($first);
            } elseif($first >= 1000 && $first <= 999999) {
                $firstWord = $this->fourDigits($first);
            } else {
                $firstWord = $this->sevenDigits($first);
            }
            $second = floor(($number / 1000000000));
            $secondWord = $this->oneToThreeDigits($second);
            $words = $secondWord . ' ' . $this->numbersToWord['b'] . ' ' . $this->numbersToWord[0] . ' ' . $firstWord;
        }
        return $words;
    }

    private function thirteenDigits($number)
    {
        if (fmod($number, 1000000000000) == 0) {
            $number2 = $number/1000000000000;
            $number3 = $this->oneToThreeDigits($number2);
            $words =  $number3 . ' ' . $this->numbersToWord['tr'];
        } else {
            $first = fmod($number, 1000000000000);
            if ($first >= 1 && $first <= 999) {
                $firstWord = $this->oneToThreeDigits($first);
            } elseif($first >= 1000 && $first <= 999999) {
                $firstWord = $this->fourDigits($first);
            } elseif($first >= 1000000 && $first <= 999999999) {
                $firstWord = $this->sevenDigits($first);
            } else {
                $firstWord = $this->tenDigits($first);
            }
            $second = floor(($number / 1000000000000));
            $secondWord = $this->oneToThreeDigits($second);
            $words = $secondWord . ' ' . $this->numbersToWord['tr'] . ' ' . $this->numbersToWord[0] . ' ' . $firstWord;
        }
        return $words;
    }

    private function convertParts ($number) {
        if ($number >= 1 && $number <= 9) {
            $words = $this->oneDigit($number);
        } elseif ($number >= 10 && $number <= 99) {
            $words = $this->twoDigits($number);
        } elseif ($number >= 100 && $number <= 999) {
            $words = $this->threeDigits($number);
        } elseif ($number >= 1000 && $number <= 999999) {
            $words = $this->fourDigits($number);
        } elseif ($number >= 1000000 && $number <= 999999999) {
            $words = $this->sevenDigits($number);
        } elseif ($number >= 1000000000 && $number <= 999999999999) {
            $words = $this->tenDigits($number);
        } elseif ($number >= 1000000000000 && $number <= 999999999999999) {
            $words = $this->thirteenDigits($number);
        } else {
            $words = 'Out of range';
        }
        return $words;
    }

    /**
     * Convert numeric input into words
     *
     * @param $number 13 digits number only
     * @return string
     */
    public function convert($number)
    {
        $numberParts = explode('.', $number);

        $words = $this->convertParts($numberParts[0]);
        if (isset($numberParts[1])) {
            $words .= ' عشاریه ';
            $numberArray = str_split($numberParts[1]);
            foreach ($numberArray as $num) {
                $words .= $this->oneDigit($num) . (next($numberArray) ? ' ' : '');
            }
        }

        return $words;
    }
}
