# WorkflowInterface
A PHP package for dealing with state transitions.

[![Latest Stable Version](https://img.shields.io/packagist/v/davispeixoto/workflow.svg)](https://packagist.org/packages/davispeixoto/workflow)
[![Total Downloads](https://img.shields.io/packagist/dt/davispeixoto/workflow.svg)](https://packagist.org/packages/davispeixoto/workflow)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/davispeixoto/workflow/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/davispeixoto/workflow/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/davispeixoto/workflow/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/davispeixoto/workflow/?branch=master)
[![Build Status](https://travis-ci.org/davispeixoto/workflow.svg?branch=master)](https://travis-ci.org/davispeixoto/workflow)

State transitions are a good way to manage lifecycles and pipelines 
on applications, as for example:

- Order and payment status on an e-commerce
- Invoice Status on a finance system
- Ticket Status on ticket service desk system
- Sales status on a CRM

## Installation
The workflow package can be installed via [Composer](http://getcomposer.org) by requiring the
`davispeixoto/workflow` package in your project's `composer.json`.

```json
{
    "require": {
        "davispeixoto/workflow": "~1.0"
    }
}
```

Or

```sh
$ php composer.phar require davispeixoto/workflow
```

And running a composer update from your terminal:
```sh
php composer.phar update
```

## Usage
To use it, first you need to create the status you are going to use 
for representing your states.

```php
<?php
use MyCLabs\Enum\Enum;

class SalesStates extends Enum
{
    public const NEW = 'new';
    public const DEALING = 'dealing';
    public const WON = 'won';
    public const LOST = 'lost';
}
```

Then you can create your workflow based on valid transitions

```php
<?php
use Davispeixoto\WorkflowInterface\Transition;
use Davispeixoto\WorkflowInterface\WorkflowInterface;

class SalesWorkflow extends WorkflowInterface
{
    public function __construct(SalesStates $initialStatus)
    {
        parent::__construct($initialStatus);

        // setup the transitions
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

        // setup the finished status, if any/needed
        $finished = [];

        $finished[] = new SalesStates(SalesStates::WON);
        $finished[] = new SalesStates(SalesStates::LOST);

        $this->finishedStatus = $finished;
    }
}
```

Now you can use this workflow to manage state transitions on you applications.

## License
This software is licensed under the [MIT license](http://opensource.org/licenses/MIT)

## Versioning
This project follows the [Semantic Versioning](http://semver.org/)

## Thanks
For all PHP community
