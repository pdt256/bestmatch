<?php
namespace pdt256\bestmatch;

interface ComparableInterface
{
    /**
     * @param ComparableInterface $comparable
     * @return int Percent (0-100) probability the comparable object matches this object
     */
    public function compareTo(ComparableInterface $comparable);
}
