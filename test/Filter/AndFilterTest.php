<?php

namespace DPB\ElasticsearchInMemoryFilter\Test\Filter;

use DPB\ElasticsearchInMemoryFilter\Filter\AndFilter;
use DPB\ElasticsearchInMemoryFilter\Filter\TermFilter;

class AndFilterTest extends \PHPUnit_Framework_TestCase
{
  public function testSingle()
  {
    $subject = new AndFilter([
      new TermFilter([
        'field1' => 'value1',
      ]),
      new TermFilter([
        'top.field2' => 'value2',
      ]),
    ]);

    $this->assertTrue($subject->match(['field1' => 'value1', 'top' => [ 'field2' => 'value2' ]]));

    $this->assertFalse($subject->match(['field1' => 'value1', 'field2' => 'value2']));
  }
}
