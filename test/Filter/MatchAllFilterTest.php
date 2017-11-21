<?php

namespace DPB\ElasticsearchInMemoryFilter\Test\Filter;

use DPB\ElasticsearchInMemoryFilter\Filter\MatchAllFilter;

class MatchAllFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testSimple()
    {
        $subject = new MatchAllFilter([]);

        $this->assertTrue($subject->match(['field1' => 'value1']));
        $this->assertTrue($subject->match(['field2' => false]));
    }
}
