<?php

namespace DPB\ElasticsearchInMemoryFilter\Test\Filter;

use DPB\ElasticsearchInMemoryFilter\Filter\NestedFilter;
use DPB\ElasticsearchInMemoryFilter\Filter\TermFilter;

class NestedFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testSingle()
    {
        $subject = new NestedFilter([
      'path' => 'multi',
      'filter' => new TermFilter([
        'multi.field1' => 'value1',
      ]),
    ]);

        $this->assertTrue($subject->match([
      'multi' => [
        [
          'field1' => 'value1',
        ],
      ],
    ]));

        $this->assertTrue($subject->match([
      'multi' => [
        [
          'field2' => 'value2',
        ],
        [
          'field1' => 'value1',
        ],
      ],
    ]));

        $this->assertFalse($subject->match([
      [
        'field1' => 'value1',
      ],
    ]));

        $this->assertFalse($subject->match([
      'multi' => [
        [
          'field2' => 'value2',
        ],
      ],
    ]));
    }
}
