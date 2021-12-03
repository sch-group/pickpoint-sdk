<?php

declare(strict_types=1);

namespace PickPointSdk\Tests\UnitTests;

use PickPointSdk\Tests\InitTest;
use PickPointSdk\Components\State;

final class SortStatesTest extends InitTest
{
    public function testSortStates()
    {
        $class = new \ReflectionClass('PickPointSdk\PickPoint\PickPointConnector');
        $method = $class->getMethod('sortArrayOfStatesByDateAsc');
        $method->setAccessible(true);

        $dateFormat = 'Y-m-d H:i:s';

        $states = [
            new State(0, '', new \DateTime('2021-12-03 12:00:00')),
            new State(0, '', new \DateTime('2021-12-01 17:00:00')),
            new State(0, '', new \DateTime('2021-12-02 21:00:00')),
            new State(0, '', new \DateTime('2021-10-15 06:00:00')),
            new State(0, '', new \DateTime('2021-11-30 08:00:00')),
        ];

        $sortedStates = $method->invokeArgs($this->client, [$states]);

        $this->assertEquals('2021-10-15 06:00:00', $sortedStates[0]->getChangeDate()->format($dateFormat));
        $this->assertEquals('2021-11-30 08:00:00', $sortedStates[1]->getChangeDate()->format($dateFormat));
        $this->assertEquals('2021-12-01 17:00:00', $sortedStates[2]->getChangeDate()->format($dateFormat));
        $this->assertEquals('2021-12-02 21:00:00', $sortedStates[3]->getChangeDate()->format($dateFormat));
        $this->assertEquals('2021-12-03 12:00:00', $sortedStates[4]->getChangeDate()->format($dateFormat));
    }
}
