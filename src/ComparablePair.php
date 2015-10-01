<?php
namespace pdt256\bestmatch;

class ComparablePair
{
    /** @var ComparablePair|null */
    private $parent;

    /** @var ComparablePair[] */
    private $children = [];

    /** @var ComparableInterface */
    private $left;

    /** @var ComparableInterface */
    private $right;

    /**
     * @param ComparableInterface|null $left
     * @param ComparableInterface|null $right
     * @param ComparablePair[] $children
     */
    public function __construct(ComparableInterface $left = null, ComparableInterface $right = null, $children = [])
    {
        if ($left === null || $right === null) {
            $this->parent = null;
            return;
        }

        $this->left = $left;
        $this->right = $right;

        foreach ($children as $child) {
            $this->addChild($child);
        }
    }

    public function addChild(ComparablePair $pair)
    {
        $pair->setParent($this);
        $this->children[] = $pair;
    }

    private function setParent(ComparablePair $parent)
    {
        $this->parent = $parent;
    }

    public function __toString()
    {
        return $this->getString();
    }

    public function getString($depth = 0)
    {
        $buff = $this->getPaddedDepth($depth);

        if ($this->parent === null) {
            $buff .= 'root' . PHP_EOL;
        } else {
            $buff .= $this->getPairString() . ' (' . $this->left->compareTo($this->right) .')' . PHP_EOL;
        }

        foreach ($this->children as $child) {
            $buff .= $child->getString($depth + 1);
        }

        if ($this->isLeafNode()) {
            $buff .= $this->getPaddedDepth($depth + 1) . '[' . $this->getBranchTotal() . ']' . PHP_EOL;
        }

        return $buff;
    }

    /**
     * @return bool
     */
    protected function isLeafNode()
    {
        return empty($this->children);
    }

    /**
     * @param int $depth
     * @return string
     */
    protected function getPaddedDepth($depth)
    {
        $buff = '';
        for ($i = 0; $i < $depth; $i++) {
            $buff .= "   ";
        }
        return $buff;
    }

    private function getBranchTotal()
    {
        if ($this->parent === null) {
            return 0;
        }

        return $this->getPairTotal() + $this->parent->getBranchTotal();
    }

    /**
     * @return int
     */
    private function getPairTotal()
    {
        return $this->left->compareTo($this->right);
    }

    public function getBestMatch()
    {
        $leafNodes = $this->getLeafNodes();
        $bestBranchTotal = 0;
        $bestLeaf = $leafNodes[0];

        foreach ($leafNodes as $leaf) {
            $branchTotal = $leaf->getBranchTotal();
            if ($branchTotal > $bestBranchTotal) {
                $bestBranchTotal = $branchTotal;
                $bestLeaf = $leaf;
            }
        }

        return $bestLeaf->getBranchSet();
    }

    /**
     * @return ComparablePair[]
     */
    private function getLeafNodes()
    {
        $leafs = [];
        foreach ($this->children as $child) {
            $leafs = array_merge($leafs, $child->getLeafNodes());
        }

        if ($this->isLeafNode()) {
            return [$this];
        } else {
            return $leafs;
        }
    }

    private function getBranchSet()
    {
        $nodes = [];
        if ($this->parent !== null) {
            $nodes = array_merge([$this->getBaseComparablePair()], $this->parent->getBranchSet());
        }

        return $nodes;
    }

    /**
     * @return string
     */
    private function getPairString()
    {
        return (string)$this->left . '-' . (string)$this->right;
    }

    /**
     * @return ComparablePair
     */
    private function getBaseComparablePair()
    {
        return new ComparablePair($this->left, $this->right);
    }
}
