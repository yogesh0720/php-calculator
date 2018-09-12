<?php

require __DIR__ . "/vendor/autoload.php";

use Tarsana\Command\Command;

class calculatorController extends Command {

  /**
   * calculator function will allow to mathematics operation as per logic
   * @param $argv
   */
  public function calculator($argv) {
    $action = isset($argv[1]) ? $argv[1] : '';
    $numString = isset($argv[2]) ? $argv[2] : 0;

    $isValidate = $this->isValidate($numString);
    $isFlag = isset($isValidate['flag']) ? $isValidate['flag'] : '';
    $isValidateString = isset($isValidate['validateString']) ? $isValidate['validateString'] : '';

    if ($isFlag) {

      switch ($action) {
        case 'sum' :
          $validArr = explode(',', $isValidateString);
          if (count($validArr) > 2) {
            $this->console->error("Maximum two parameters allow in Sum");
            $this->console->line('<info>Hint : You can use add method for more than two parameters instead of sum </info>');
          } else {
            $sumArr = array_sum($validArr);
            $this->console->line("<background:15><color:19>Output : {$sumArr} <reset>");
          }
          break;

        case 'add' :
          $isValidateString = preg_replace('/[^,0-9\-]/', ',', $isValidateString);
          $sumArr = array_sum(explode(',', $isValidateString));
          $this->console->line("<background:15><color:19>Output : {$sumArr} <reset>");
          break;

        case 'multiply' :
          $isValidateString = preg_replace('/[^,0-9\-]/', ',', $isValidateString);
          $sumArr = array_product(array_filter(explode(',', $isValidateString)));
          $this->console->line("<background:15><color:19>Output : {$sumArr} <reset>");
          break;

        default;
      }
    }
  }


  /**
   * isValidate function check positive and negative with error.
   * @param $value
   * @return array
   */
  public function isValidate($value) {
    $valArr = explode(',', $value);

    //ignore the numbers above 1000 and return less than 1000
    $ignoreArr = array_filter($valArr, function ($x) {
      return $x < 1000;
    });

    //return only positive numbers
    $posArr = array_filter($ignoreArr, function ($y) {
      return $y >= 0;
    });

    //ignore the negative numbers and return positive numbers
    $negArr = array_filter($ignoreArr, function ($y) {
      return $y < 0;
    });

    $array = [];
    if (count($negArr) > 0) {
      $negValue = implode(',', $negArr);
      $this->console->error("Negative numbers ({$negValue}) not allowed");
    } else if (count($posArr) > 0) {
      $posValue = implode(',', $posArr);
      $array['flag'] = true;
      $array['validateString'] = $posValue;
    } else {
      $array['flag'] = false;
    }
    return $array;
  }

}

/*
 * Execute the calculatorController by own with command line args.
 *
 * */
(new calculatorController)->calculator($argv);




