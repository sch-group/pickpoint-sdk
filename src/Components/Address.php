<?php


namespace PickPointSdk\Components;


class Address
{
    /**
     * @var string
     */
    private $cityName;

    /**
     * @var string
     */
    private $regionName;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $fio;

    /**
     * @var string
     */
    private $postCode;

    /**
     * @var string
     */
    private $organization;

    /**
     * @var string
     */
    private $phoneNumber;

    /**
     * @var string
     */
    private $comment;

    /**
     * @return string
     */
    public function getCityName() : string
    {
        return $this->cityName;
    }

    /**
     * @param string $cityName
     */
    public function setCityName(string $cityName)
    {
        $this->cityName = $cityName ?? '';
    }

    /**
     * @return string
     */
    public function getRegionName() : string
    {
        return $this->regionName ?? '';
    }

    /**
     * @param string $regionName
     */
    public function setRegionName(string $regionName)
    {
        $this->regionName = $regionName;
    }

    /**
     * @return string
     */
    public function getAddress() : string
    {
        return $this->address ?? '';
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getFio() : string
    {
        return $this->fio ?? '';
    }

    /**
     * @param string $fio
     */
    public function setFio(string $fio)
    {
        $this->fio = $fio;
    }

    /**
     * @return string
     */
    public function getPostCode() : string
    {
        return $this->postCode ?? '';
    }

    /**
     * @param string $postCode
     */
    public function setPostCode(string $postCode)
    {
        $this->postCode = $postCode ?? '';
    }

    /**
     * @return string
     */
    public function getOrganization() : string
    {
        return $this->organization ?? '';
    }

    /**
     * @param string $organization
     */
    public function setOrganization(string $organization)
    {
        $this->organization = $organization;
    }

    /**
     * @return string
     */
    public function getPhoneNumber() : string
    {
        return $this->phoneNumber ?? '';
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getComment() : string
    {
        return $this->comment ?? '';
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }

    public function transformToArray() : array
    {
        return [
          'CityName' => $this->getCityName(),
          'RegionName' => $this->getRegionName(),
          'Address' => $this->getAddress(),
          'FIO' => $this->getFio(),
          'PostCode' => $this->getPostCode(),
          'Organization' => $this->getOrganization(),
          'PhoneNumber' => $this->getPhoneNumber(),
          'Comment' => $this->getComment()
        ];
    }
}