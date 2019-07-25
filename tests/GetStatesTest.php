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
        $firstState = $states[0];
        $this->assertInstanceOf(State::class, $firstState);

        $this->assertEquals(101, $firstState->getState());
    }
}