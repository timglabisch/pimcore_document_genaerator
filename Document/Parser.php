<?php
class Pimcore_Document_Parser {

    protected $name;

    function __construct($name) {
        $this->setName($name);
    }

    function getDepth() {
        $nameArr = array_reverse(explode('_', $this->getName()));

        $i = 1;

        foreach($nameArr as $v) {
            if(!is_numeric($v))
                break;
            $i++;
        }

        return $i;
    }

    function getStructure() {
        $nameStrlen = strlen($this->getName());
        $nameRev = $this->getName();

        $buffer = array();

        // step 1. get all possible combinations
        for($depth = 1; $depth <= $this->getDepth() + 2; $depth++) {
            for($offset = 0; $offset < $nameStrlen; $offset++) {
                for($length = 1; $length < $nameStrlen; $length++) {

                    $substr = substr($nameRev, $offset, $length);

                    if(substr_count($nameRev, $substr) == $depth) {

                        if(!isset($buffer[$depth]))
                            $buffer[$depth] = array();

                        $buffer[$depth][] = $substr;
                    }
                }
            }

            if(isset($buffer[$depth]))
                $buffer[$depth] = array_unique($buffer[$depth]);
        }

        // now we try every combination that

        $_1c = count($buffer[1]) -1;
        $_2c = count($buffer[2]) -1;
        $_3c = count($buffer[3]) -1;
        $_4c = count($buffer[4]) -1;

        for($_1 = 0; $_1 < $_1c; $_1++){
            for($_2 = 0; $_2 < $_2c; $_2++){
                for($_3 = 0; $_3 < $_3c; $_3++){
                    for($_4 = 0; $_4 < $_4c; $_4++){
                        if(
                            strlen($buffer[1][$_1]) * 4 +
                            strlen($buffer[2][$_2]) * 3 +
                            strlen($buffer[3][$_3]) * 2 +
                            strlen($buffer[4][$_4])
                            < $nameStrlen
                            ) {
                            echo 'MATCH!';
                            var_dump($buffer[1], $buffer[2], $buffer[3], $buffer[4]);
                        }
                    }
                }
            }
        }

        return $buffer;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

}