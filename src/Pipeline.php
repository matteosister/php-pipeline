<?php

namespace Cypress\Pipeline;

use PhpCollection\Sequence;
use Functional as F;

class Pipeline
{
    /**
     * @var Sequence
     */
    private $segments;

    /**
     * Pipeline builder
     */
    public function __construct()
    {
        $this->segments = new Sequence();
    }

    /**
     * @param callable $func a php callable
     */
    public function addSegment(callable $func)
    {
        $args = array_slice(func_get_args(), 1);
        if (empty($args)) {
            $this->segments->add(new Segment($func));
            return;
        }
        $this->segments->add(new Segment($func, $args[0]));
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
