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

    /**
     * @param ComparableInterface[] $set1
     * @param ComparableInterface[] $set2
     * @return ComparablePair
     */
    public function buildFromSets(array $set1, array $set2)
    {
        if (empty($set1)) {
            return $this;
        }

        reset($set1);
        $key1 = key($set1);
        $item1 = current($set1);

        foreach ($set2 as $key2 => $item2) {
            $pair = new ComparablePair($item1, $item2);

            $subset1 = $set1;
            $subset2 = $set2;
            unset($subset1[$key1]);
            unset($subset2[$key2]);

            $this->addChild($pair->buildFromSets($subset1, $subset2));
        }

        return $this;
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
    private function getBranchSet()
    {
        $nodes = [];
        if ($this->parent !== null) {
            $nodes = array_merge([$this->getBaseComparablePair()], $this->parent->getBranchSet());
        }

        return $nodes;
    }

    private function getBaseComparablePair()
    {
        return new ComparablePair($this->left, $this->right);
    }

    public function getTreeAsString($depth = 0)
    {
        $buff = $this->getPaddedDepth($depth);

        if ($this->parent === null) {
            $buff .= 'root' . PHP_EOL;
        } else {
            $buff .= (string) $this . ' (' . $this->left->compareTo($this->right) .')' . PHP_EOL;
        }

        foreach ($this->children as $child) {
            $buff .= $child->getTreeAsString($depth + 1);
        }

        if ($this->isLeafNode()) {
            $buff .= $this->getPaddedDepth($depth + 1) . '[' . $this->getBranchTotal() . ']' . PHP_EOL . PHP_EOL;
        }

        return $buff;
    }

    private function isLeafNode()
    {
        return empty($this->children);
    }

    /**
     * @param int $depth
     * @return string
     */
    private function getPaddedDepth($depth)
    {
        $buff = '';
        for ($i = 0; $i < $depth; $i++) {
            $buff .= "   ";
        }
        return $buff;
    }

    /**
     * @return int
     */
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

    public function getStringArray()
    {
        $array = [];

        foreach ($this->children as $child) {
            $array[(string) $child] = $child->getStringArray();
        }

        return $array;
    }

    public function __toString()
    {
        return (string) $this->left . '-' . (string) $this->right;
    }
}
