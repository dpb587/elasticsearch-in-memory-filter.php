<?php

namespace DPB\ElasticsearchInMemoryFilter\Filter;

use DPB\ElasticsearchInMemoryFilter\Exception\PathMissingException;

class TermFilter extends AbstractFilter
{
  public function match(array $value)
  {
    try {
      $fieldValue = $this->traversePath($value, $this->config['field']);
    } catch (PathMissingException $e) {
      return false;
    }

    foreach ((array) $fieldValue as $fieldValueInner) {
      if ($fieldValueInner == $this->config['value']) {
        return true;
      }
    }

    return false;
  }

  protected function parseConfig(array $config) {
    if (count($config) != 1) {
      throw new \InvalidArgumentException('Expected one and only one element in term config');
    }

    return [
      'field' => key($config),
      'value' => current($config),
    ];
  }
}
