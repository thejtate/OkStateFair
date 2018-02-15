<?php
define('OKSTATEFAIR_CALENDAR_CODER_ALPHABET', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');

/**
 * Convert number to string
 *
 * @param $number
 * @return string
 */
function okstatefair_calendar_encode($number) {
  $alphabet = str_split(OKSTATEFAIR_CALENDAR_CODER_ALPHABET);
  $word = _okstatefair_calendar_encode($number, $alphabet);
  $strWord = implode('', $word);
  return $strWord;

}

/**
 * Convert back string to number
 *
 * @param $strWord
 * @return string
 */
function okstatefair_calendar_decode($strWord) {
  $alphabet = str_split(OKSTATEFAIR_CALENDAR_CODER_ALPHABET);
  $word = str_split($strWord);
  $number = _okstatefair_calendar_decode($word, $alphabet);
  return $number;
}

function _okstatefair_calendar_encode($number, $alphabet) {
  $size = count($alphabet);
  $world = "";
  while ($number >= $size) {
    $world[] = $alphabet[($number % $size)];
    $number = floor($number / $size) ;
  }
  $world[] = $alphabet[($number)];
  return array_reverse($world);
}

function _okstatefair_calendar_decode($world, $alphabet) {
  $size = count($alphabet);
  $num = 0;
  while (count($world) > 1) {
    $num += array_search(array_shift($world), $alphabet);
    $num *= $size;
  }
  $num += array_search(array_shift($world), $alphabet);
  return $num;
}



