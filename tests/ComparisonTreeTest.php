<?php
namespace pdt256\bestmatch;

class ComparisonTreeTest extends \PHPUnit_Framework_TestCase
{
    public function testGetBestMatch()
    {
        $root = new ComparablePair;
        $root->addChild(
            new ComparablePair(new Color('red'), new Color('blueviolet'), [
                new ComparablePair(new Color('green'), new Color('bluegreen'), [
                    new ComparablePair(new Color('blue'), new Color('reed'))
                ]),
                new ComparablePair(new Color('green'), new Color('reed'), [
                    new ComparablePair(new Color('blue'), new Color('bluegreen'))
                ]),
            ])
        );
        $root->addChild(
            new ComparablePair(new Color('red'), new Color('bluegreen'), [
                new ComparablePair(new Color('green'), new Color('blueviolet'), [
                    new ComparablePair(new Color('blue'), new Color('reed'))
                ]),
                new ComparablePair(new Color('green'), new Color('reed'), [
                    new ComparablePair(new Color('blue'), new Color('blueviolet'))
                ]),
            ])
        );
        $root->addChild(
            new ComparablePair(new Color('red'), new Color('reed'), [
                new ComparablePair(new Color('green'), new Color('blueviolet'), [
                    new ComparablePair(new Color('blue'), new Color('bluegreen'))
                ]),
                new ComparablePair(new Color('green'), new Color('bluegreen'), [
                    new ComparablePair(new Color('blue'), new Color('blueviolet'))
                ]),
            ])
        );

        $expectedPairList = [
            new ComparablePair(new Color('blue'), new Color('blueviolet')),
            new ComparablePair(new Color('green'), new Color('bluegreen')),
            new ComparablePair(new Color('red'), new Color('reed')),
        ];

        $this->assertEquals($expectedPairList, $root->getBestMatch());
    }

    public function testToStringEmpty()
    {
        $root = new ComparablePair;
        $this->assertSame("root\n   [0]\n", (string) $root);
    }

    public function testToStringOneChild()
    {
        $root = new ComparablePair;
        $root->addChild(
            new ComparablePair(new Color('red'), new Color('blueviolet'))
        );

        $this->assertSame("root\n   red-blueviolet (15)\n      [15]\n", (string) $root);
    }
}
