<?php
/**
 * Created by PhpStorm.
 * User: davis
 * Date: 1/22/19
 * Time: 2:58 PM
 */

namespace Davispeixoto\Workflow;

use Davispeixoto\Workflow\Exceptions\InvalidTransitionException;
use Davispeixoto\Workflow\Interfaces\WorkflowInterface;
use MyCLabs\Enum\Enum;

abstract class AbstractWorkflow implements WorkflowInterface
{
    /**
     * @var Transition[]
     */
    protected $allowedTransitions;

    /**
     * @var Enum[]
     */
    protected $finishedStatus;

    /**
     * @var Enum
     */
    protected $currentStatus;

    /**
     * WorkflowInterface constructor.
     * @param Enum $initialStatus
     */
    public function __construct(Enum $initialStatus)
    {
        $this->currentStatus = $initialStatus;
    }

    /**
     * @return Enum
     */
    public function getCurrentStatus(): Enum
    {
        return $this->currentStatus;
    }

    /**
     * @return bool
     */
    public function isFinished(): bool
    {
        return in_array($this->currentStatus, $this->finishedStatus);
    }

    /**
     * @param Enum $status
     * @throws InvalidTransitionException
     */
    public function setCurrentStatus(Enum $status): void
    {
        $isTransitionAllowed = false;

        foreach ($this->allowedTransitions as $transition) {
            if ($transition->getFrom()->getValue() === $this->currentStatus->getValue()
                && $transition->getTo()->getValue() === $status->getValue()
            ) {
                $this->currentStatus = $status;
                $isTransitionAllowed = true;
                break;
            }
        }

        if (!$isTransitionAllowed) {
            throw new InvalidTransitionException('Transition not allowed');
        }
    }
}
