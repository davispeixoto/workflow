<?php
/**
 * Created by PhpStorm.
 * User: davis
 * Date: 1/22/19
 * Time: 3:32 PM
 */

namespace Davispeixoto\Workflow;

use MyCLabs\Enum\Enum;

class Transition
{
    /**
     * @var Enum
     */
    private $from;

    /**
     * @var Enum
     */
    private $to;

    public function __construct(Enum $from, Enum $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return Enum
     */
    public function getFrom(): Enum
    {
        return $this->from;
    }

    /**
     * @return Enum
     */
    public function getTo(): Enum
    {
        return $this->to;
    }
}
