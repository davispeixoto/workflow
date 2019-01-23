<?php
/**
 * Created by PhpStorm.
 * User: davis
 * Date: 1/23/19
 * Time: 10:20 AM
 */

namespace Davispeixoto\Workflow\Tests;

use Davispeixoto\Workflow\Exceptions\InvalidTransitionException;
use Davispeixoto\Workflow\Tests\Auxiliary\SalesStates;
use Davispeixoto\Workflow\Tests\Auxiliary\SalesWorkflow;
use PHPUnit\Framework\TestCase;

class WorkflowTest extends TestCase
{
    /**
     * @param SalesWorkflow $workflow
     * @param SalesStates $expected
     * @dataProvider getCurrentStatusProvider
     */
    public function testGetCurrentStatus(SalesWorkflow $workflow, SalesStates $expected)
    {
        $this->assertEquals($expected, $workflow->getCurrentStatus());
    }

    /**
     * @param SalesWorkflow $workflow
     * @param bool $expected
     * @dataProvider isFinishedProvider
     */
    public function testIsFinished(SalesWorkflow $workflow, bool $expected)
    {
        $this->assertEquals($expected, $workflow->isFinished());
    }

    /**
     * @param SalesStates $initialState
     * @param SalesStates $newState
     * @throws InvalidTransitionException
     * @dataProvider setCurrentStatusProvider
     */
    public function testSetCurrentStatus(SalesStates $initialState, SalesStates $newState)
    {
        $workflow = new SalesWorkflow($initialState);
        $workflow->setCurrentStatus($newState);
        $this->assertEquals($newState, $workflow->getCurrentStatus());
    }

    /**
     * @param SalesStates $initialState
     * @param SalesStates $newState
     * @throws InvalidTransitionException
     * @dataProvider setCurrentStatusExceptionProvider
     */
    public function testSetCurrentStatusException(SalesStates $initialState, SalesStates $newState)
    {
        $this->expectException(InvalidTransitionException::class);
        $workflow = new SalesWorkflow($initialState);
        $workflow->setCurrentStatus($newState);
    }

    // data providers

    public function getCurrentStatusProvider()
    {
        $status1 = new SalesStates(SalesStates::NEW);
        $status2 = new SalesStates(SalesStates::DEALING);
        $status3 = new SalesStates(SalesStates::WON);
        $status4 = new SalesStates(SalesStates::LOST);

        return [
            [new SalesWorkflow($status1), $status1],
            [new SalesWorkflow($status2), $status2],
            [new SalesWorkflow($status3), $status3],
            [new SalesWorkflow($status4), $status4]
        ];
    }

    public function isFinishedProvider()
    {
        $status1 = new SalesStates(SalesStates::NEW);
        $status2 = new SalesStates(SalesStates::DEALING);
        $status3 = new SalesStates(SalesStates::WON);
        $status4 = new SalesStates(SalesStates::LOST);

        return [
            [new SalesWorkflow($status1), false],
            [new SalesWorkflow($status2), false],
            [new SalesWorkflow($status3), true],
            [new SalesWorkflow($status4), true]
        ];
    }

    public function setCurrentStatusProvider()
    {
        $status1 = new SalesStates(SalesStates::NEW);
        $status2 = new SalesStates(SalesStates::DEALING);
        $status3 = new SalesStates(SalesStates::WON);
        $status4 = new SalesStates(SalesStates::LOST);

        return [
            [$status1, $status2],
            [$status2, $status3],
            [$status2, $status4]
        ];
    }

    public function setCurrentStatusExceptionProvider()
    {
        $status1 = new SalesStates(SalesStates::NEW);
        $status2 = new SalesStates(SalesStates::DEALING);
        $status3 = new SalesStates(SalesStates::WON);
        $status4 = new SalesStates(SalesStates::LOST);

        return [
            [$status1, $status3],
            [$status1, $status4],
            [$status2, $status1],
            [$status3, $status1],
            [$status3, $status2],
            [$status3, $status4],
            [$status4, $status1],
            [$status4, $status2],
            [$status4, $status3]
        ];
    }
}
