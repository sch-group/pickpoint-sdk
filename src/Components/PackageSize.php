<?php


namespace PickPointSdk\Components;


class PackageSize
{
    private $width;

    private $depth;

    private $length;

    private $weight;

    /**
     * ProductSize constructor.
     * @param $width
     * @param $depth
     * @param $length
     * @param $weight
     */
    public function __construct($width, $length, $depth, $weight = 1)
    {
        $this->width = $width;
        $this->depth = $depth;
        $this->length = $length;
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }
}