<?php
namespace pdt256\bestmatch;

class ComparablePairTest extends \PHPUnit_Framework_TestCase
{
    public function testGetBestMatchFromManualBuild()
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

        $expected = [
            new ComparablePair(new Color('blue'), new Color('blueviolet')),
            new ComparablePair(new Color('green'), new Color('bluegreen')),
            new ComparablePair(new Color('red'), new Color('reed')),
        ];

        $this->assertEquals($expected, $root->getBestMatch());
    }

    public function testBuildFromSetsEmptyTree()
    {
        $root = new ComparablePair;
        $root->buildFromSets([], []);
        $this->assertSame([], $root->getStringArray());
        $this->assertSame("root\n   [0]\n\n", $root->getTreeAsString());
    }

    public function testToStringOneChild()
    {
        $root = new ComparablePair;
        $root->buildFromSets(
            [new Color('red')],
            [new Color('blueviolet')]
        );

        $expected = [
            'red-blueviolet' => []
        ];

        $this->assertSame($expected, $root->getStringArray());
        $this->assertSame("root\n   red-blueviolet (15)\n      [15]\n\n", $root->getTreeAsString());
    }

    public function testbuildFromSetsBranchTwo()
    {
        $root = new ComparablePair;
        $root->buildFromSets(
            [new Color('red'), new Color('green')],
            [new Color('blueviolet'), new Color('bluegreen')]
        );

        $expected = [
            'red-blueviolet' => [
                'green-bluegreen' => [],
            ],
            'red-bluegreen' => [
                'green-blueviolet' => [],
            ],
        ];

        $this->assertSame($expected, $root->getStringArray());

    }

    public function testbuildFromSetsBranchThree()
    {
        $root = new ComparablePair;
        $root->buildFromSets(
            [new Color('red'), new Color('green'), new Color('blue')],
            [new Color('blueviolet'), new Color('bluegreen'), new Color('reed')]
        );

        $expected = [
            'red-blueviolet' => [
                'green-bluegreen' => [
                    'blue-reed' => [],
                ],
                'green-reed' => [
                    'blue-bluegreen' => [],
                ]
            ],
            'red-bluegreen' => [
                'green-blueviolet' => [
                    'blue-reed' => [],
                ],
                'green-reed' => [
                    'blue-blueviolet' => [],
                ]
            ],
            'red-reed' => [
                'green-blueviolet' => [
                    'blue-bluegreen' => [],
                ],
                'green-bluegreen' => [
                    'blue-blueviolet' => [],
                ]
            ],
        ];

        $this->assertSame($expected, $root->getStringArray());
    }

    public function testGetBestMatchFromBuilder()
    {
        $root = new ComparablePair;
        $root->buildFromSets(
            [new Color('red'), new Color('green'), new Color('blue')],
            [new Color('blueviolet'), new Color('bluegreen'), new Color('reed')]
        );

        $expected = [
            new ComparablePair(new Color('blue'), new Color('blueviolet')),
            new ComparablePair(new Color('green'), new Color('bluegreen')),
            new ComparablePair(new Color('red'), new Color('reed')),
        ];

        $this->assertEquals($expected, $root->getBestMatch());
    }
}
