<?php

use Cypress\Pipeline\Pipeline;

class PipelineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Pipeline
     */
    private $pipeline;

    function setup()
    {
        $this->pipeline = new Pipeline();
    }

    function test_empty_pipeline()
    {
        $this->assertEquals('subject', $this->pipeline->feed('subject'));
    }

    function test_single_section_pipeline()
    {
        $segment = new SectionA();
        $this->pipeline->addSegment(array($segment, 'flow'));
        $this->assertEquals('subject', $this->pipeline->feed('subject'));
    }

    function test_double_section_pipeline()
    {
        $segment = new SectionA();
        $this->pipeline->addSegment(array($segment, 'append'), '!');
        $this->assertEquals('subject!', $this->pipeline->feed('subject'));
    }

    function test_section_with_multiple_returns()
    {
        $segment = new SectionA();
        $this->pipeline->addSegment(array($segment, 'addChar'), '!');
        $this->pipeline->addSegment(array($segment, 'append'));
        $this->assertEquals('subject!', $this->pipeline->feed('subject'));
    }

    function test_feed_with_multiple_values()
    {
        $segment = new SectionA();
        $this->pipeline->addSegment(array($segment, 'append'));
        $this->pipeline->addSegment(array($segment, 'addChar'), '!');
        $this->pipeline->addSegment(array($segment, 'append'));
        $this->assertEquals('subject!!', $this->pipeline->feed(array('subject', '!')));
    }
}

class SectionA
{
    function flow($elem) {
        return $elem;
    }

    function change($elem) {
        return str_repeat($elem, 2);
    }

    function append($elem, $char) {
        return $elem.$char;
    }

    function addChar($elem, $char)
    {
        return array($elem, $char);
    }
}