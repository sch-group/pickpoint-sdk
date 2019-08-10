<?php


namespace PickPointSdk\Components;


use phpDocumentor\Reflection\Types\Self_;

class State
{
    /**
     * @var int
     */
    private $state;

    /**
     * @var string
     */
    private $stateText;

    /**
     * @var \DateTime
     */
    private $changeDate;

    const PRETTY_STATES = [
            101 => 'Отправитель зарегистрировал заказ',
            102 => 'Заказ в стадии комплектации и отгрузки',
            106 => 'PickPoint принял заказ',
            107 => 'Заказ отправлен в город доставки',
            108 => 'Заказ выдан курьеру для доставки',
            109 => 'Заказ в постамате/пункте выдачи',
            111 => 'Заказ получен'
        ];

    const FAILED_STATES = [
        112 => 'Срок хранения заказа истек',
        114 => 'Получатель отказался от заказа',
        113 => 'Заказ возвращен оптправителю',
        115 => 'Заказ принят на сортировочный центр для возврата отправителю',
        116 => 'Заказ передан на сортировочный центр для возврата отправителю',
        117 => 'Передано в логистическую компанию',
        118 => 'Заказ подготовлен для отправки',
        122 => 'Передано в логистическую компанию',
        123 => 'Сконсолидировано для пересылки'
    ];

    /**
     * State constructor.
     * @param int $state
     * @param string $stateText
     */
    public function __construct(int $state, string $stateText, \DateTime $changeDate = null)
    {
        $this->state = $state;
        $this->stateText = $stateText;
        $this->changeDate = $changeDate;
    }

    /**
     * @return int
     */
    public function getState(): int
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getStateText(): string
    {
        return $this->stateText;
    }

    /**
     * @return \DateTime
     */
    public function getChangeDate(): \DateTime
    {
        return $this->changeDate;
    }

    /**
     * @return string
     */
    public function getPrettyStateText() : string
    {
        $interpretedStates = array_merge(self::PRETTY_STATES, self::FAILED_STATES);
        return !empty($interpretedStates[$this->state]) ? $interpretedStates[$this->state] : $this->stateText;
    }
}