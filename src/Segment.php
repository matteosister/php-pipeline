<?php

namespace Cypress\Pipeline;

use Cypress\Curry as C;

class Segment
{
    /**
     * @var callable
     */
    private $func;

    /**
     * @param callable $func
     * @param ...$args
     */
    public function __construct(callable $func, $args)
    {
        $this->func = empty($args) ? $func : C\curry_right($func, ...$args);
    }

    /**
     * @param $subject
     * @return mixed
     */
    public function handle($subject)
    {
        return call_user_func_array($this->func, is_array($subject) ? $subject : [$subject]);
    }
}
