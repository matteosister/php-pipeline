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
     */
    public function addSegment(callable $func)
    {
        $this->segments->add(new Segment($func, $this->rest(func_get_args())));
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

    /**
     * @param array $args
     * @return array
     */
    private function rest(array $args)
    {
        return array_slice($args, 1);
    }
}
