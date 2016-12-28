<?php

namespace DPB\ElasticsearchInMemoryFilter\Test;

use DPB\ElasticsearchInMemoryFilter\Transformer;

class TransformerTest extends \PHPUnit_Framework_TestCase
{
  public function testSimple()
  {
    $subject = Transformer::transform([
      'and' => [
        [
          'term' => [
            'field1' => 'value1',
          ],
        ],
        [
          'term' => [
            'field2' => 'value2',
          ],
        ],
      ]
    ]);

    $this->assertTrue($subject->match(['field1' => 'value1', 'field2' => 'value2']));

    $this->assertFalse($subject->match(['field2' => 'value2']));
  }
}
