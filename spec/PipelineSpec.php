<?php

namespace spec\Cypress\Pipeline;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PipelineSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Cypress\Pipeline\Pipeline');
    }
}
