<?php

namespace DPB\ElasticsearchInMemoryFilter\Test\Filter;

use DPB\ElasticsearchInMemoryFilter\Filter\TermFilter;

class TermFilterTest extends \PHPUnit_Framework_TestCase
{
  public function testSingle()
  {
    $subject = new TermFilter([
      'field1' => 'value1',
    ]);

    $this->assertTrue($subject->match(['field1' => 'value1']));
    $this->assertTrue($subject->match(['field2' => 'value2', 'field1' => 'value1']));

    $this->assertFalse($subject->match(['field2' => 'value2']));
    $this->assertFalse($subject->match(['field2' => 'value1', 'field1' => 'value2']));
  }

  public function testDepth()
  {
    $subject = new TermFilter([
      'top.field1' => 'value1',
    ]);

    $this->assertTrue($subject->match(['top' => [ 'field1' => 'value1'] ]));
    $this->assertTrue($subject->match(['top' => [ 'field2' => 'value2', 'field1' => 'value1'] ]));

    $this->assertFalse($subject->match(['top' => [ 'field2' => 'value2'] ]));
    $this->assertFalse($subject->match(['top' => [ 'field2' => 'value1', 'field1' => 'value2'] ]));
  }
}
