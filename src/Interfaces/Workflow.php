<?php
/**
 * Created by PhpStorm.
 * User: davis
 * Date: 1/22/19
 * Time: 2:29 PM
 */

namespace Davispeixoto\Workflow\Interfaces;

use Davispeixoto\Workflow\Exceptions\InvalidTransitionException;
use MyCLabs\Enum\Enum;

interface Workflow
{
    /**
     * @return Enum
     */
    public function getCurrentStatus() :Enum;

    /**
     * @param Enum $status
     * @throws InvalidTransitionException
     */
    public function setCurrentStatus(Enum $status) :void;

    /**
     * @return bool
     */
    public function isFinished() :bool ;
}
