<?php
namespace pdt256\bestmatch;

class StringBestMatchTest extends \PHPUnit_Framework_TestCase
{

    public function testLevenshtein()
    {
        $this->assertSame(0, levenshtein('A', 'A'));
        $this->assertSame(1, levenshtein('A', 'a'));
        $this->assertSame(1, levenshtein('A', 'B'));
        $this->assertSame(1, levenshtein('A1', 'B1'));
        $this->assertSame(4, levenshtein('bat', 'nose'));
    }

    public function provider()
    {
        return [
            [100,   'a', 'a'],
            [92,    'abcdef', 'abcdef1'],
            [86,    'abc1', 'ab1'],
            [50,    'a1', 'b1'],
            [0,     'a', 'b'],
            [0,     'bat', 'nose'],
            [15,     'red', 'blueviolet'],
            [33,     'red', 'bluegreen'],
            [86,     'red', 'reed'],
            [27,     'green', 'blueviolet'],
            [71,     'green', 'bluegreen'],
            [67,     'green', 'reed'],
            [57,     'blue', 'blueviolet'],
            [62,     'blue', 'bluegreen'],
            [25,     'blue', 'reed'],
        ];
    }

    /**
     * @dataProvider provider
     * @param int $expectedPercent
     * @param string $a
     * @param string $b
     */
    public function testSimilarText($expectedPercent, $a, $b)
    {
        similar_text($a, $b, $percent);
        $this->assertSame($expectedPercent, (int) round($percent), print_r(get_defined_vars(), true));
    }
}
