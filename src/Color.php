<?php
namespace pdt256\bestmatch;

class Color implements ComparableInterface
{
    /** @var string */
    private $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = (string) $name;
    }

    public function compareTo(ComparableInterface $otherColor)
    {
        similar_text((string) $this, (string) $otherColor, $percent);
        return (int) round($percent);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
