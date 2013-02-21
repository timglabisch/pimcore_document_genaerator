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
                        ->addChild('D')
                            ->addChild('A');

        $elements = $c->getElements();
        $names = array_keys($elements);
        $names = array_map('strrev', $names);
        $names_c = count($names);

        usort($names, function($a, $b) {
            return (strlen($a) < strlen($b) ? -1 : 1);
        });

        do {
            $matches = 0;
            echo "\n-------------------\n";

            for($i=0; $i < $names_c; $i++) {
                for($j=0; $j < $names_c; $j++) {

                    if(!$ret = preg_replace('/^[0-9\_]*'.preg_quote($names[$i]).'/i', '', $names[$j], 1))
                        continue;

                    echo "$names[$j] ($ret) is child of $names[$i] \n";

                    if($names[$j] == $ret)
                        continue;

                    $names[$j] = $ret;

                    $matches++;
                }
            }
        } while($matches);

        var_dump($names);

    }


}