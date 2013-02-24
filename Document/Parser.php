<?php
class Pimcore_Document_Parser {

    protected $name;

    function __construct() {

    }

    function getDepth($elementName) {
        $nameArr = array_reverse(explode('_', $elementName));

        $i = 1;

        foreach($nameArr as $v) {
            if(!is_numeric($v))
                break;
            $i++;
        }

        return $i;
    }

    function getElementsNames($elements) {
        $names = array_keys($elements);
        $names = array_map('strrev', $names);
        $names_c = count($names);

        do {
            $matches = 0;

            for($i=0; $i < $names_c; $i++) {

                usort($names, function($a, $b) {
                    return (strlen($a) > strlen($b) ? -1 : 1);
                });

                for($j=0; $j < $names_c; $j++) {

                    $c = 0;
                    if(!$ret = preg_replace('/^[0-9\_]*'.preg_quote($names[$i]).'/i', '', $names[$j], 1, $c)) {
                        continue;
                    }

                    if(!$c)
                        continue;

                    $names[$j] = $ret;

                    $matches++;
                }
            }
        } while($matches);

        return $names;
    }

    function getElementsTree($elements) {

        $originalNames = array_keys($elements);
        $originalNames_c = count($originalNames);

        $names = $this->getElementsNames($elements);
        $names_c = count($names);

        usort($originalNames, function($a, $b) {
            return (strlen($a) > strlen($b) ? -1 : 1);
        });

        $originalNames_copy = array();
        foreach($originalNames as $v)
            $originalNames_copy[] = array(
                'name' => $v,
                'matches' => array()
            );

        do {
            $matches = 0;

            for($i=0; $i < $names_c; $i++) {

                for($j=0; $j < $originalNames_c; $j++) {

                    $c = 0;

                    if(!$ret = preg_replace('/^[0-9\_]*'.preg_quote($names[$i]).'/i', '', $originalNames[$j], 1, $c))
                        continue;

                    if(!$c)
                        continue;

                    $originalNames_copy[$j]['matches'][] = $names[$i];
                    $originalNames[$j] = $ret;

                    $matches++;
                }
            }
        } while($matches);


        $skips = array(
            0,
            0,
            1,
            0,
            1,
            1,
            1,
            0,
            0,
            0,
            0
        );

        $buffer = array();

        foreach($originalNames_copy as $m) {

            $rounds = -1;

            // may its a root node
            if(count($m['matches']) == 0)
                $buffer[$m['name']][] = $m['name'];

            for($i = count($m['matches']) - 1; $i >= 0; $i--) {

                $rounds++;

                if($skips[$rounds])
                    continue;

                if(!isset($m['matches'][$i]))
                    continue;

                if(!isset($buffer[$m['name']]))
                    $buffer[$m['name']] = array();

                $buffer[$m['name']][] = $m['matches'][$i];
            }
        }

        return $buffer;
    }

}