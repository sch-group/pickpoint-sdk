<?php


namespace PickPointSdk\Components;


class TariffPrice
{

    private $priorityMaxDay;

    private $priorityMinDay;

    private $standardMaxDay;

    private $standardMinDay;

    private $zone;

    private $errorMessage;

    private $errorCode;

    private $prices;

    public function __construct(array $response)
    {
        $this->standardMinDay = $response['DPMin'] ?? 0;
        $this->standardMaxDay = $response['DPMin'] ?? 0;
        $this->priorityMinDay = $response['DPMinPriority'] ?? 0;
        $this->priorityMaxDay = $response['DPMaxPriority'] ?? 0;
        $this->zone = $response['Zone'] ?? '';
        $this->errorCode = $response['ErrorCode'] ?? '';
        $this->prices = $response['Services'] ?? [];
    }

    /**
     * @return mixed
     */
    public function getPriorityMaxDay()
    {
        return $this->priorityMaxDay;
    }

    /**
     * @param mixed $priorityMaxDay
     */
    public function setPriorityMaxDay($priorityMaxDay)
    {
        $this->priorityMaxDay = $priorityMaxDay;
    }

    /**
     * @return mixed
     */
    public function getPriorityMinDay()
    {
        return $this->priorityMinDay;
    }


    /**
     * @return mixed
     */
    public function getStandardMaxDay()
    {
        return $this->standardMaxDay;
    }

    /**
     * @return mixed
     */
    public function getStandardMinDay()
    {
        return $this->standardMinDay;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->errorMessage;
    }


    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @return mixed
     */
    public function getPrices()
    {
        return $this->prices;
    }


    /**
     * @return mixed
     */
    public function getZone()
    {
        return $this->zone;
    }


    /**
     * Returns commons sum of standard tariff
     * @return float
     */
    public function getStandardCommonPrice()
    {
        return $this->getPriceByType('Standard');
    }

    public function getPriorityPrice()
    {
        return $this->getPriceByType('Priority');
    }

    private function getPriceByType($type)
    {
        if (!in_array($type, ['Standard', 'Priority'])) {
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

    public function existsPriorityType(): bool
    {
        foreach ($this->prices as $price) {
            if ($price['DeliveryMode'] == 'Priority') {
                return true;
            }
        }
        return false;
    }

}