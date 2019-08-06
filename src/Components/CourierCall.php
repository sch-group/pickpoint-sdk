<?php


namespace PickPointSdk\Components;


class CourierCall
{
    const MIN_COUNT_MINUTES_OF_TIME_INTERVAL = 240;

    const MINUTES_EQUALS_TO_NINE_HOURS = 540;

    const MINUTES_EQUALS_TO_EIGHTEEN_HOURS = 1080;

    /**
     * @var int
     */
    private $callOrderNumber;

    /**
     * @var string
     */
    private $cityName;

    /**
     * @var int
     */
    private $cityId;

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
    private $phone;

    /**
     * @var string
     */
    private $date;

    /**
     * @var int
     */
    private $timeStart;
    /**
     * @var int
     */
    private $timeEnd;
    /**
     * @var int
     */
    private $numberOfInvoices;

    /**
     * @var int
     */
    private $weight;

    /**
     * @var string
     */
    private $comment;

    /***
     * @var string
     */
    private $error;

    /**
     * CourierCall constructor.
     * @param string $cityName
     * @param int $cityId
     * @param string $address
     * @param string $fio
     * @param string $phone
     * @param \DateTime $date
     * @param int $timeStart
     * @param int $timeEnd
     * @param int $numberOfInvoices
     * @param int $weight
     * @param string $comment
     * @throws \Exception
     */
    public function __construct(string $cityName, int $cityId, string $address, string $fio,string $phone, \DateTime $date, int $timeStart = self::MINUTES_EQUALS_TO_NINE_HOURS, int $timeEnd = self::MINUTES_EQUALS_TO_EIGHTEEN_HOURS,  int $numberOfInvoices = 0, int $weight = 1,string $comment = '')
    {
        $this->cityName = $cityName;
        $this->cityId = $cityId;
        $this->address = $address;
        $this->fio = $fio;
        $this->phone = $phone;
        $this->date = $date->format('Y.m.d');
        if ($timeEnd - $timeStart < self::MIN_COUNT_MINUTES_OF_TIME_INTERVAL) {
            throw new \Exception("Time start/end should be more than " . self::MIN_COUNT_MINUTES_OF_TIME_INTERVAL. " minutes");
        }
        $this->timeStart = $timeStart;
        $this->timeEnd = $timeEnd;
        $this->numberOfInvoices = $numberOfInvoices;
        $this->weight = $weight;
        $this->comment = $comment;
    }
    /**
     * @return string
     */
    public function getCityName(): string
    {
        return $this->cityName;
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

    /**
     * @return string
     */
    public function getFio(): string
    {
        return $this->fio;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getTimeStart(): int
    {
        return $this->timeStart;
    }

    /**
     * @return int
     */
    public function getTimeEnd(): int
    {
        return $this->timeEnd;
    }

    /**
     * @return int
     */
    public function getNumberOfInvoices(): int
    {
        return $this->numberOfInvoices;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @return mixed
     */
    public function getCallOrderNumber()
    {
        return $this->callOrderNumber;
    }

    /**
     * @param mixed $callOrderNumber
     */
    public function setCallOrderNumber($callOrderNumber)
    {
        $this->callOrderNumber = $callOrderNumber;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    public function setError(string $error)
    {
        $this->error = $error;
    }
}