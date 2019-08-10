<?php


namespace PickPointSdk\Tests;


use PickPointSdk\Components\State;

class GetStatesTest extends InitTest
{

    public function testGetStates()
    {
        $states = $this->client->getStates();
        /**
         * @var State $firstState
         */
        $firstState = current($states);

        $this->assertInstanceOf(State::class, $firstState);

        $this->assertEquals(101, $firstState->getStateCode());
    }
}