<?php
/**
 * Created by PhpStorm.
 * User: davis
 * Date: 1/23/19
 * Time: 10:22 AM
 */

namespace Davispeixoto\Workflow\Tests;

use Davispeixoto\Workflow\Tests\Auxiliary\SalesStates;
use Davispeixoto\Workflow\Transition;
use PHPUnit\Framework\TestCase;

class TransitionTest extends TestCase
{
    /**
     * @var SalesStates
     */
    private $from;

    /**
     * @var SalesStates
     */
    private $to;

    /**
     * @var Transition
     */
    private $transition;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->from = new SalesStates(SalesStates::NEW);
        $this->to = new SalesStates(SalesStates::DEALING);
        $this->transition = new Transition($this->from, $this->to);
    }

    /**
     * @param SalesStates $from
     * @param SalesStates $to
     * @param Transition $expected
     * @dataProvider constructorProvider
     */
    public function testConstructor(SalesStates $from, SalesStates $to, Transition $expected)
    {
        $transition = new Transition($from, $to);
        $this->assertEquals($expected, $transition);
    }

    /**
     * @param Transition $transition
     * @param SalesStates $expected
     * @dataProvider getFromProvider
     */
    public function testGetFrom(Transition $transition, SalesStates $expected)
    {
        $this->assertEquals($expected, $transition->getFrom());
    }

    /**
     * @param Transition $transition
     * @param SalesStates $expected
     * @dataProvider getToProvider
     */
    public function testGetTo(Transition $transition, SalesStates $expected)
    {
        $this->assertEquals($expected, $transition->getTo());
    }

    // Data providers
    public function constructorProvider()
    {
        return [
            [$this->from, $this->to, $this->transition]
        ];
    }

    public function getFromProvider()
    {
        return [
            [$this->transition, $this->from]
        ];
    }

    public function getToProvider()
    {
        return [
            [$this->transition, $this->to]
        ];
    }
}
