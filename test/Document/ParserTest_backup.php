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

        $originalNames = $names;
        $names = array_map('strrev', $names);


        $names_c = count($names);

        do {
            $matches = 0;

            for($i=0; $i < $names_c; $i++) {

                usort($names, function($a, $b) {
                    return (strlen($a) < strlen($b) ? -1 : 1);
                });


                for($j=0; $j < $names_c; $j++) {

                    $c = 0;
                    if(!$ret = preg_replace('/^[0-9\_]*'.preg_quote($names[$i]).'/i', '', $names[$j], 1, $c))
                        continue;

                    if(!$c)
                        continue;

                    $names[$j] = $ret;

                    $matches++;
                }
            }
        } while($matches);



        var_dump($names);


        $originalNames_c = count($originalNames);
        $names_c = count($names);

        usort($originalNames, function($a, $b) {
            return (strlen($a) > strlen($b) ? -1 : 1);
        });

        $originalNames_copy = $originalNames;

        do {
            $matches = 0;

            for($i=0; $i < $names_c; $i++) {

                echo "\n- $originalNames[$i] -\n";


                for($j=0; $j < $originalNames_c; $j++) {

                    $c = 0;

                    echo 'try '.$names[$i].' in '.$originalNames[$j].' ('.$originalNames_copy[$j].')';

                    if(!$ret = preg_replace('/^[0-9\_]*'.preg_quote($names[$i]).'/i', '', $originalNames[$j], 1, $c)) {
                        echo "\n";
                        continue;
                    }

                    if(!$c) {
                        echo "\n";
                        continue;
                    }

                    echo " MATCH \n";
                    if(!is_array($originalNames_copy[$j]['matches']))  {
                        $originalNames_copy[$j] = array(
                            'name' => $originalNames_copy[$j],
                            'matches' => array()
                        );
                    }

                    $originalNames_copy[$j]['matches'][] = $names[$i];

                    $originalNames[$j] = $ret;

                    $matches++;
                }
            }
        } while($matches);

        // yay

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

        $rounds = 0;
        foreach($originalNames_copy as $m) {

            echo $m['name'] . '------'."\n";

            $rounds = -1;
            for($i = count($m['matches']) - 1; $i >= 0; $i--) {

                $rounds++;

                if($skips[$rounds]) {
                    echo $rounds. ' skip'."\n";
                    continue;
                }

                if(!isset($m['matches'][$i]))
                    continue;

                echo $rounds. ' take'." ".$m['matches'][$i]."\n";
            }

        }

    }


}