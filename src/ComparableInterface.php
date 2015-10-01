<?php
namespace pdt256\bestmatch;

interface ComparableInterface
{
    /**
     * @param ComparableInterface $comparable
     * @return int The probability the $comparable object matches $this object (0-100)
     */
    public function compareTo(ComparableInterface $comparable);
}
