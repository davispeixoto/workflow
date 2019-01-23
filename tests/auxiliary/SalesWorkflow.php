<?php
/**
 * Created by PhpStorm.
 * User: davis
 * Date: 1/23/19
 * Time: 10:31 AM
 */

namespace Davispeixoto\Workflow\Tests\Auxiliary;

use Davispeixoto\Workflow\Transition;
use Davispeixoto\Workflow\Workflow;
use MyCLabs\Enum\Enum;

class SalesWorkflow extends Workflow
{
    public function __construct(Enum $initialStatus)
    {
        parent::__construct($initialStatus);

        $transitions = [];

        $transitions[] = new Transition(
            new SalesStates(SalesStates::NEW),
            new SalesStates(SalesStates::DEALING)
        );

        $transitions[] = new Transition(
            new SalesStates(SalesStates::DEALING),
            new SalesStates(SalesStates::WON)
        );

        $transitions[] = new Transition(
            new SalesStates(SalesStates::DEALING),
            new SalesStates(SalesStates::LOST)
        );

        $this->allowedTransitions = $transitions;

        $finished = [];

        $finished[] = new SalesStates(SalesStates::WON);
        $finished[] = new SalesStates(SalesStates::LOST);

        $this->finishedStatus = $finished;
    }
}
