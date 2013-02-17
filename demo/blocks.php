<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Example</title>
</head>

<body>

<h1>Hello World!</h1>
<p>
    This is just a simple example.


<?php

    $c = new Pimcore_Document_Structure();

    $getNewDocumentTag = function($txt) {
        $tag = new \Document_Tag_Input('just ignore the name here...');
        $tag->setDataFromEditmode('TEXT_'.$txt);
        return $tag;
    };

    $getNewDocumentTagBlock = function($txt) {
        $tag = new \Document_Tag_Block('just ignore the name here...');
        $tag->setDataFromEditmode('TEXT_'.$txt);
        return $tag;
    };

    $c
        ->addChild('_ROOT-INP_', $getNewDocumentTag('_ROOT-INP_'))
        ->addSblng('_ROOT-INP2_', $getNewDocumentTag('_ROOT-INP2_'))
        ->addSblng('_ROOT-BLOCK3_', $getNewDocumentTagBlock('_ROOT-BLOCK3_'))
            ->addChild('_ROOT-BLOCK3-INP1_', $getNewDocumentTag('_ROOT-BLOCK3-INP1_'))
            ->addSblng('_ROOT-BLOCK3-INP2_', $getNewDocumentTag('_ROOT-BLOCK3-INP2_'))
            ->addSblng('_ROOT-BLOCK3-INP3_', $getNewDocumentTag('_ROOT-BLOCK3-INP3_'))
            ->addSblng('_ROOT-BLOCK3-BLOCK4_', $getNewDocumentTagBlock('_ROOT-BLOCK3-BLOCK4_'))
                ->addChild('_ROOT-BLOCK3-BLOCK4-BLOCK5_', $getNewDocumentTagBlock('_ROOT-BLOCK3-BLOCK4-BLOCK5_'))
                    ->addChild('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP1_', $getNewDocumentTag('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP1_'))
                    ->addSblng('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP2_', $getNewDocumentTag('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP2_'))
                ->Up()
                ->addSblng('_ROOT-BLOCK3-BLOCK4-INP1_', $getNewDocumentTag('_ROOT-BLOCK3-BLOCK4-INP1_'))
                ->addSblng('_ROOT-BLOCK3-BLOCK4-INP2_', $getNewDocumentTag('_ROOT-BLOCK3-BLOCK4-INP2_'))
            ->Up()
        ->Up()
        ->addSblng('_ROOT-BLOCK3_', $getNewDocumentTagBlock('_ROOT-BLOCK3_'))
            ->addChild('_ROOT-BLOCK3-INP1_', $getNewDocumentTag('_ROOT-BLOCK3-INP1_2'), 2)
            ->addSblng('_ROOT-BLOCK3-INP2_', $getNewDocumentTag('_ROOT-BLOCK3-INP2_2'), 2)
            ->addSblng('_ROOT-BLOCK3-INP3_', $getNewDocumentTag('_ROOT-BLOCK3-INP3_2'), 2)
            ->addSblng('_ROOT-BLOCK3-BLOCK4_', $getNewDocumentTagBlock('_ROOT-BLOCK3-BLOCK4_2'), 2)
                ->addChild('_ROOT-BLOCK3-BLOCK4-BLOCK5_', $getNewDocumentTagBlock('_ROOT-BLOCK3-BLOCK4-BLOCK5_2'))
                    ->addChild('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP1_', $getNewDocumentTag('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP1_2'))
                    ->addSblng('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP2_', $getNewDocumentTag('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP2_2'))
                ->Up()
                ->addSblng('_ROOT-BLOCK3-BLOCK4-BLOCK5_', $getNewDocumentTagBlock('_ROOT-BLOCK3-BLOCK4-BLOCK5_2'))
                    ->addChild('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP1_', $getNewDocumentTag('_NEXT_ROOT-BLOCK3-BLOCK4-BLOCK5-INP1_2'), 2)
                    ->addSblng('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP2_', $getNewDocumentTag('_NEXT_ROOT-BLOCK3-BLOCK4-BLOCK5-INP2_2'), 2)
                ->Up()
                ->addSblng('_ROOT-BLOCK3-BLOCK4-INP1_', $getNewDocumentTag('_ROOT-BLOCK3-BLOCK4-INP1_2'))
                ->addSblng('_ROOT-BLOCK3-BLOCK4-INP2_', $getNewDocumentTag('_ROOT-BLOCK3-BLOCK4-INP2_2'))
        ;


    $this->document->setElements($c->getElements());

?>


    <?=$this->input('_ROOT-INP_')?>
    <?=$this->input('_ROOT-INP2_')?>

    <?
    echo '<div style="padding-left:20px">';
    while($this->block('_ROOT-BLOCK3_')->loop()) {

        echo '<hr/><br/><br/><br/>';

        echo $this->input('_ROOT-BLOCK3-INP1_');
        echo $this->input('_ROOT-BLOCK3-INP2_');
        echo $this->input('_ROOT-BLOCK3-INP3_');

        echo '<div style="padding-left:20px">';
        while($this->block('_ROOT-BLOCK3-BLOCK4_')->loop()) {
            echo $this->input('_ROOT-BLOCK3-BLOCK4-INP1_');
            echo $this->input('_ROOT-BLOCK3-BLOCK4-INP2_');

            echo '<div style="padding-left:20px">';
            while($this->block('_ROOT-BLOCK3-BLOCK4-BLOCK5_')->loop()) {
                echo $this->input('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP1_');
                echo $this->input('_ROOT-BLOCK3-BLOCK4-BLOCK5-INP2_');
            }
            echo '</div>';

        }
        echo '</div>';
    }
    echo '</div>';

    $el = $this->document->getElements();

    ?>

</p>


</body>
</html>

