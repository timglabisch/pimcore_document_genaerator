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


    $getNewDocumentAreablock = function($type, $currentNummeration) {
        $tag = new \Document_Tag_Areablock('just ignore the name here...');
        $tag->setDataFromEditmode(
            array(
                array('type' => $type, 'key' => 1),
                array('type' => $type, 'key' => 2),
                array('type' => $type, 'key' => 3)
            )
        );
        return $tag;
    };

    $getNewDocumentTag = function($txt) {
        $tag = new \Document_Tag_Input('just ignore the name here...');
        $tag->setDataFromEditmode('TEXT_'.$txt);
        return $tag;
    };

    $c
        ->addChild('some-area-block', $getNewDocumentAreablock('sample', 1))
            ->addChild('IN_AREA1', $getNewDocumentTag('IN_AREA1_1'), 1)
            ->addSblng('IN_AREA2', $getNewDocumentTag('IN_AREA1_2'), 1)
            ->addSblng('IN_AREA1', $getNewDocumentTag('IN_AREA2_1'), 2)
            ->addSblng('IN_AREA2', $getNewDocumentTag('IN_AREA2_2'), 2)
            ->addSblng('IN_AREA1', $getNewDocumentTag('IN_AREA2_1'), 3)
            ->addSblng('IN_AREA2', $getNewDocumentTag('IN_AREA2_2'), 3)
    ;

    $this->document->setElements($c->getElements());

    echo $this->areablock("some-area-block",
        array(
            "allowed"=>array("sample"),
        )
    );

    
   /*
            The Area Sample looks like this:

            <?php
            echo $this->input('IN_AREA1');
            echo $this->input('IN_AREA2');
     */

?>



</p>


</body>
</html>

