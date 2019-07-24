<?php


namespace PickPointSdk\Components;

class ReceiverDestination
{
    protected $city;

    protected $region;

    protected $postamatNumber;

    /**
     * ReceiverDestination constructor.
     * @param $city
     * @param $region
     * @param $postamatNumber
     */
    public function __construct($city, $region, $postamatNumber = '')
    {
        $this->city = $city;
        $this->region = $region;
        $this->postamatNumber = $postamatNumber;
    }
    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getRegion()
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