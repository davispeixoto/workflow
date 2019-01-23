<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Davispeixoto\Workflow\Exceptions\InvalidTransitionException;
use Davispeixoto\Workflow\Tests\Auxiliary\SalesStates;
use Davispeixoto\Workflow\Tests\Auxiliary\SalesWorkflow;
use MyCLabs\Enum\Enum;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * @var SalesWorkflow
     */
    private $workflow;

    /**
     * @var string $exceptionMessage
     */
    private $exceptionMessage;

    /**
     * @var string $exceptionClass
     */
    private $exceptionClass;

    /**
     * @var Enum
     */
    private $currentState;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        return;
    }

    /**
     * @Given there is the following states for sales:
     */
    public function thereIsTheFollowingStatesForSales(TableNode $table)
    {
        return true;
    }

    /**
     * @Given there is the following sales lifecycle
     */
    public function thereIsTheFollowingSalesLifecycle(TableNode $table)
    {
        return true;
    }

    /**
     * @Given there is the background
     */
    public function thereIsTheBackground()
    {
        return true;
    }

    /**
     * @Given There is a sale in :arg1 state
     */
    public function thereIsASaleInState($arg1)
    {
        $values = SalesStates::values();
        $this->workflow = new SalesWorkflow($values[$arg1]);
    }

    /**
     * @When I change its state to :arg1
     */
    public function iChangeItsStateTo($arg1)
    {
        $this->exceptionMessage = '';
        $this->exceptionClass = '';

        try {
            $values = SalesStates::values();
            $this->workflow->setCurrentStatus($values[$arg1]);
        } catch (InvalidTransitionException $invalidTransitionException) {
            $this->exceptionMessage = $invalidTransitionException->getMessage();
            $this->exceptionClass = InvalidTransitionException::class;
        }
    }

    /**
     * @Then sales must be in :arg1 state
     */
    public function salesMustBeInState($arg1)
    {
        $values = SalesStates::values();
        $state = $values[$arg1];
        Assert::assertEquals($state->getValue(), $this->workflow->getCurrentStatus()->getValue());
    }

    /**
     * @Then I should receive an error message
     */
    public function iShouldReceiveAnErrorMessage()
    {
        Assert::assertEquals(InvalidTransitionException::class, $this->exceptionClass);
        Assert::assertNotEmpty($this->exceptionMessage);
    }

    /**
     * @When I check its state
     */
    public function iCheckItsState()
    {
        $this->currentState = $this->workflow->getCurrentStatus();
    }

    /**
     * @Then I should see it is not finished
     */
    public function iShouldSeeItIsNotFinished()
    {
        Assert::assertEquals(false, $this->workflow->isFinished());
    }

    /**
     * @Then I should see it is finished
     */
    public function iShouldSeeItIsFinished()
    {
        Assert::assertEquals(true, $this->workflow->isFinished());
    }
}
