<?php

namespace Cypress\Pipeline;

use PhpCollection\Sequence;
use Functional as F;

class Pipeline
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Sequence
     */
    private $segments;

    /**
     * Pipeline builder
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->segments = new Sequence();
        $this->name = $name;
    }

    /**
     * @param callable $func a php callable
     * @param mixed    $args you can pass as many args as you want, they will be partially right applied to the function
     */
    public function addSegment(callable $func, ...$args)
    {
        $this->segments->add(new Segment($func, $args));
    }

    /**
     * @param mixed $subject
     * @return array
     */
    public function feed($subject)
    {
        return F\reduce_left($this->segments, function (Segment $segment, $i, $c, $subject) {
            return $segment->handle($subject);
        }, $subject);
    }
}
