<?php
/**
 * Created by PhpStorm.
 * User: davis
 * Date: 1/23/19
 * Time: 10:28 AM
 */

namespace Davispeixoto\Workflow\Tests\Auxiliary;

use MyCLabs\Enum\Enum;

class SalesStates extends Enum
{
    public const NEW = 'new';
    public const DEALING = 'dealing';
    public const WON = 'won';
    public const LOST = 'lost';
}
