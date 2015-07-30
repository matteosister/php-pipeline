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
    public function __construct(callable $func)
    {
        $args = array_slice(func_get_args(), 1);
        $this->func = empty($args) ? $func : C\curry_right_args($func, $args);
    }

    /**
     * @param $subject
     * @return mixed
     */
    public function handle($subject)
    {
        return call_user_func_array($this->func, is_array($subject) ? $subject : array($subject));
    }
}
