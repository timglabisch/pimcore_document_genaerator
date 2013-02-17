<?php
class Pimcore_Document_Structure {
    protected $blocks = array();
    protected $numeration = array();
    protected $nodeName = '';

    protected $currentNummeration;
    protected $maxNummerations = 1;
    /** @var \Pimcore_Document_Structure */
    protected $parent = null;
    /** @var \Pimcore_Document_Structure_Config */
    protected $structure_children = array();
    protected $tag;


    function __construct($name = '', $tag = null, Pimcore_Document_Structure $parent = null, $currentNummeration = 1) {
        $this->nodeName = $name;
        $this->setParent($parent);
        $this->setCurrentNummeration($currentNummeration);
        $this->setTag($tag);

        $this->nextNodeConfig = new Pimcore_Document_Structure_Config();

        if($this->getParent())
            $this->getParent()->addStructureChild($this);
    }

    function getName() {

        $name = $this->nodeName;

        if($this->getParent())
            $blocks = $this->getParent()->getBlocks();
        else
            $blocks = array();

        $tmpNumeration = $this->getNumeration();

        if (is_array($blocks) and count($blocks) > 0) {

            $tmpBlocks = $blocks;
            array_pop($tmpBlocks);
            array_pop($tmpNumeration);

            $tmpName = $this->nodeName;
            if (is_array($tmpBlocks)) {
                $tmpName = $name . implode("_", $tmpBlocks) . implode("_", $tmpNumeration);
            }

            if ($blocks[count($blocks) - 1] == $tmpName) {
                array_pop($blocks);
                array_pop($tmpNumeration);
            }

            $name = $name . implode("_", $blocks) . implode("_", $this->getNumeration());
        }


        return $name;
    }

    function addChild($name, Document_Tag $tag = null, $nth = 1) {
        return new static($name, $tag, $this, $nth);
    }

    function addSblng($name, Document_Tag $tag = null, $nth = 1) {
        return $this->addSibling($name, $tag, $nth);
    }

    function addSibling($name, Document_Tag $tag = null, $nth = 1) {
        return new static($name, $tag, $this->getParent(), $nth);
    }

    function up() {
        return $this->getParent();
    }

    public function getNodes() {
        $nodes = $this->getStructureChildren();
        foreach($nodes as $n)
            $nodes = array_merge($nodes, $n->getNodes());

        return $nodes;
    }

    public function getElements() {
        $nodes = $this->getNodes();

        if(empty($nodes))
            return array();

        $buffer = array();
        foreach($nodes as $node) {

            if($node->getTag() instanceof \Document_Tag_Block) {
                $node->getTag()->indices = range(1, $node->maxNummerations);
            }

            if(isset($buffer[$node->getName()]) && $node->getTag() instanceof Document_Tag_Block) {
                $buffer[$node->getName()]->getTag()->indices = range(1, ++$node->maxNummerations);
                continue;
            }

            if($node->getTag())
                $node->getTag()->setName($node->getName());

            $buffer[$node->getName()] = $node;
        }

        $tagBuffer = array();
        foreach($buffer as $name => $node) {
            $tagBuffer[$name] = $node->getTag();
        }

        return $tagBuffer;
    }

    public function getBlocks() {

        $tmpBlocks = array();

        if($this->getParent())
            $tmpBlocks = $this->getParent()->getBlocks();

        if($this->getName())
            $tmpBlocks[] = $this->getName();

        return $tmpBlocks;
    }

    public function setNumeration($numeration) {
        $this->numeration = $numeration;
    }

    public function getNumeration() {

        $tmpNumeration = array();

        if($this->getDepth() > 1) {
            $tmpNumeration = $this->getParent()->getNumeration();
            $currentNummeration = $this->getCurrentNummeration();
            $tmpNumeration[] = $currentNummeration;
        }

        return $tmpNumeration;
    }

    public function setNodeName($nodeName) {
        $this->nodeName = $nodeName;
    }

    public function getNodeName() {
        return $this->nodeName;
    }

    public function setCurrentNummeration($currentNummeration) {
        $this->currentNummeration = $currentNummeration;
    }

    public function getCurrentNummeration() {
        return $this->currentNummeration;
    }

    public function getDepth() {
        if(!$this->getParent())
            return 0;

        return $this->getParent()->getDepth() + 1;
    }

    public function setParent($parent) {
        $this->parent = $parent;
    }

    public function getParent() {
        return $this->parent;
    }

    public function addStructureChild(Pimcore_Document_Structure $child) {
        $this->structure_children[] = $child;
    }

    /** @return Pimcore_Document_Structure[] */
    public function getStructureChildren() {
        return $this->structure_children;
    }

    public function setTag($tag) {
        $this->tag = $tag;
    }

    public function getTag() {
        return $this->tag;
    }

}

