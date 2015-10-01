<?php
namespace pdt256\bestmatch;

class ColorTest extends \PHPUnit_Framework_TestCase
{
    public function testColor()
    {
        $redColor = new Color('red');
        $blueColor = new Color('blue');

        $this->assertSame('red', (string) $redColor);
        $this->assertSame(100, $redColor->compareTo($redColor));
        $this->assertSame(29, $redColor->compareTo($blueColor));
    }
}
