<?php


namespace PickPointSdk\Components;

class ReceiverDestination
{
    /**
     * @var string
     */
    protected $city;

    /***
     * @var string
     */
    protected $region;

    /**
     * @var string
     */
    protected $postamatNumber;

    /**
     * ReceiverDestination constructor.
     * @param $city
     * @param $region
     * @param $postamatNumber
     */
    public function __construct(string $city, string $region, string $postamatNumber = '')
    {
        $this->city = $city;
        $this->region = $region;
        $this->postamatNumber = $postamatNumber;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @return string
     */
    public function getPostamatNumber(): string
    {
        return $this->postamatNumber;
    }
}