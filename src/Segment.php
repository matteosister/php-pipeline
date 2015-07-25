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
        if (is_array($subject)) {
            return call_user_func($this->func, ...$subject);
        }
        return call_user_func($this->func, $subject);
    }
}
