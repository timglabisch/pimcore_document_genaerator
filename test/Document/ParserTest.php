<?php

require_once __DIR__ . '/../../Document/Parser.php';


class Document_Parser_Test extends PHPUnit_Framework_TestCase {

    function testNested() {

        $c = new Pimcore_Document_Structure();

        $c
            ->addChild('ROOT-BLOCK3')
                ->addChild('_ROOT-BLOCK3-BLOCK4_')
                    ->addChild('ROOT-BLOCK3-BLOCK4-BLOCK5')
                        ->addChild('_ROOT-BLOCK3-BLOCK4-INP2');

        $elements = $c->getElements();
        $element = array_pop(array_keys($elements));
        $parser = new Pimcore_Document_Parser($element);
        $this->assertEquals($parser->getDepth(), 4);
    }

    function testFoo() {

        $c = new Pimcore_Document_Structure();

        $c
            ->addChild('A')
                ->addChild('B')
                    ->addChild('C')
                        ->addChild('D');

        $c
            ->addChild('E')
            ->addChild('F')
            ->addChild('G')
            ->addChild('H');



        $elements = $c->getElements();
        $names = array_keys($elements);
        $names = array_map('strrev', $names);
        $names_c = count($names);

        usort($names, function($a, $b) {
            return (strlen($a) < strlen($b) ? -1 : 1);
        });

        $children = array();

        do {
            $matches = 0;
            $buffer = array();
            echo "\n-------------------\n";

            for($i=0; $i < $names_c; $i++) {
                for($j=0; $j < $names_c; $j++) {

                    $c = 0;
                    $ret = preg_replace('/^[0-9\_]*'.preg_quote($names[$i]).'/i', '', $names[$j], 1, $c);


                    if(!$c) {
                        continue;
                    }


                    echo "$names[$j] ($ret) is child of $names[$i] \n";

                    if(!isset($children[$names[$i]]))
                        $children[$names[$i]] = array('extends' => array());

                    if(!isset($children[$names[$j]]))
                        $children[$names[$j]] = array('extends' => array());

                    $children[$names[$j]]['extends'][] = $ret;

                    $children[$names[$j]][$ret] = $names[$i];

                    if(!$ret) {
                        continue;
                    }

                    $names[$j] = $ret;

                    $matches++;
                }
            }
        } while($matches);

        foreach($children as $k => $child) {
            foreach($child as $ik => $ichild) {
                if($ik !== 'extends')
                    continue;

                foreach($ichild as $iik => $iichild) {
                    if(!isset($children[$iichild]))
                        continue;

                    $children[$k] = array_merge($children[$k], $children[$iichild]);
                }
            }

        }

        foreach($children as $k => $child) {
            if(!in_array($k, $names))
                unset($children[$k]);

            foreach($child as $ik => $node) {
                if(!in_array($ik, $names))
                    unset($children[$k][$ik]);
            }
        }

        var_dump($names);

    }


}