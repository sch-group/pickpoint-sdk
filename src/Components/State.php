<?php


namespace PickPointSdk\Components;


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
     * State constructor.
     * @param int $state
     * @param string $stateText
     */
    public function __construct(int $state, string $stateText)
    {
        $this->state = $state;
        $this->stateText = $stateText;
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

}