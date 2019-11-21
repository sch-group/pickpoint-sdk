<?php


namespace PickPointSdk\Components;


class TariffPrice
{
    const STANDARD_DELIVERY_TARIFF = 'Standard';

    const PRIORITY_DELIVERY_TARIFF = 'Priority';

    const DELIVERY_TARIFFS = ['Standard', 'Priority'];
    /**
     * @var int
     */
    private $priorityMaxDay;

    /**
     * @var int
     */
    private $priorityMinDay;
    /**
     * @var int
     */
    private $standardMaxDay;

    /**
     * @var int
     */
    private $standardMinDay;

    /**
     * @var int
     */
    private $zone;

    /**
     * @var string
     */
    private $errorMessage;

    /**
     * @var int
     */
    private $errorCode;

    /**
     * @var array
     */
    private $prices;

    /**
     * @var string
     */
    private $tariffType;

    /**
     * TariffPrice constructor.
     * @param array $prices
     * @param int $priorityMaxDay
     * @param int $priorityMinDay
     * @param int $standardMaxDay
     * @param int $standardMinDay
     * @param int $zone
     * @param string $errorMessage
     * @param int $errorCode
     * @param string $tariffType
     */
    public function __construct(array $prices = [], int $priorityMaxDay = 0, int $priorityMinDay = 0, int $standardMaxDay = 0, int $standardMinDay = 0, int $zone = 0, string $errorMessage = '', int $errorCode = 0, string $tariffType = 'standart')
    {
        $this->prices = $prices;
        $this->priorityMaxDay = $priorityMaxDay;
        $this->priorityMinDay = $priorityMinDay;
        $this->standardMaxDay = $standardMaxDay;
        $this->standardMinDay = $standardMinDay;
        $this->zone = $zone;
        $this->errorMessage = $errorMessage;
        $this->errorCode = $errorCode;
        $this->tariffType = $tariffType;
    }

    /**
     * @param string $tariffType
     */
    public function setTariffType(string $tariffType)
    {
        $this->tariffType = $tariffType;
    }

    /**
     * @return string
     */
    public function getTariffType(): string
    {
        return $this->tariffType;
    }

    /**
     * @return int
     */
    public function getPriorityMaxDay(): int
    {
        return $this->priorityMaxDay;
    }

    /**
     * @return int
     */
    public function getPriorityMinDay(): int
    {
        return $this->priorityMinDay;
    }

    /**
     * @return int
     */
    public function getStandardMaxDay(): int
    {
        return $this->standardMaxDay;
    }

    /**
     * @return int
     */
    public function getStandardMinDay(): int
    {
        return $this->standardMinDay;
    }

    /**
     * @return int
     */
    public function getZone(): int
    {
        return $this->zone;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    /**
     * @return array
     */
    public function getPrices(): array
    {
        return $this->prices;
    }

    /**
     * Returns commons sum of standard tariff
     * @return float
     */
    public function getStandardCommonPrice()
    {
        return $this->getPriceByType(self::STANDARD_DELIVERY_TARIFF);
    }

    /**
     * @return int|mixed
     */
    public function getPriorityCommonPrice()
    {
        return $this->getPriceByType(self::PRIORITY_DELIVERY_TARIFF);
    }

    /**
     * @param $type
     * @return int|mixed
     */
    private function getPriceByType($type)
    {
        if (!in_array($type, self::DELIVERY_TARIFFS)) {
            return 0;
        }
        $sum = 0;
        foreach ($this->prices as $price) {
            if ($price['DeliveryMode'] == $type) {
                $sum += $price['Tariff'];
            }
        }
        return $sum;
    }

    /**
     * @return bool
     */
    public function existsPriorityType(): bool
    {
        foreach ($this->prices as $price) {
            if ($price['DeliveryMode'] == self::PRIORITY_DELIVERY_TARIFF) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return float|int|mixed
     */
    public function getPrice()
    {
        if ($this->tariffType == self::STANDARD_DELIVERY_TARIFF) {
            return $this->getStandardCommonPrice();
        }
        return $this->getPriorityCommonPrice();
    }

    /**
     * @return int
     */
    public function getDeliveryPeriodMin()
    {
        if ($this->tariffType == self::STANDARD_DELIVERY_TARIFF) {
            return $this->getStandardMinDay();
        }
        return $this->getPriorityMinDay();
    }

    /**
     * @return int
     */
    public function getDeliveryPeriodMax()
    {
        if ($this->tariffType == self::STANDARD_DELIVERY_TARIFF) {
            return $this->getStandardMaxDay();
        }
        return $this->getPriorityMaxDay();
    }

}