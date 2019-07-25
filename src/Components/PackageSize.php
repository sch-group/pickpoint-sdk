<?php


namespace PickPointSdk\Components;


class PackageSize
{
    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $depth;

    /**
     * @var int
     */
    private $length;

    /**
     * @var int
     */
    private $weight;

    /**
     * ProductSize constructor.
     * @param $width
     * @param $depth
     * @param $length
     * @param $weight
     */
    public function __construct(int $width, int $length, int $depth, int $weight = 1)
    {
        $this->width = $width;
        $this->depth = $depth;
        $this->length = $length;
        $this->weight = $weight;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }
}