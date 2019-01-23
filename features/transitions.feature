Feature: Lifecycle transitions
  In order to change a state in a lifecycle
  As a user
  I need to be able validate the transition is allowed

  Rules:
  - Valid transitions must be allowed
  - Invalid transitions must throw an exception
  - I can check if a state represents an end in a lifecycle

  Background:
    Given there is the following states for sales:
    | State   | Finished |
    | NEW     | 0        |
    | DEALING | 0        |
    | WON     | 1        |
    | LOST    | 1        |
    And there is the following sales lifecycle
    | X       | NEW | DEALING | WON | LOST |
    | NEW     | X   | 1       | 0   | 0    |
    | DEALING | 0   | X       | 1   | 1    |
    | WON     | 0   | 0       | X   | 0    |
    | LOST    | 0   | 0       | 0   | X    |
    And there is the background

  Scenario: Making a valid transition
    Given There is a sale in NEW state
    When I change its state to DEALING
    Then sales must be in DEALING state

  Scenario: Trying to make an invalid transition
    Given There is a sale in LOST state
    When I change its state to DEALING
    Then sales must be in LOST state
    And I should receive an error message

  Scenario: Checking sales is not finished if it is still DEALING
    Given There is a sale in DEALING state
    When I check its state
    Then I should see it is not finished

  Scenario: Checking sales is finished if it is WON
    Given There is a sale in WON state
    When I check its state
    Then I should see it is finished
