<?php


namespace PickPointSdk\Components;


class SenderDestination extends ReceiverDestination
{
    /**
     * @var int
     */
    private $cityId;

    /**
     * @var string
     */
    private $address;

    public function __construct(string $city, string $region, string $postamatNumber = '', int $cityId = 0, string $address = '')
    {
        parent::__construct($city, $region, $postamatNumber);
        $this->cityId = $cityId;
        $this->address = $address;
    }

    /**
     * @return int
     */
    public function getCityId(): int
    {
        return $this->cityId;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

}