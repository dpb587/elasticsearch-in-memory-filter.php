<?php

namespace DPB\ElasticsearchInMemoryFilter\Filter;

use DPB\ElasticsearchInMemoryFilter\Exception\PathMissingException;
use DPB\ElasticsearchInMemoryFilter\FilterInterface;

abstract class AbstractFilter implements FilterInterface
{
  protected $config;

  static public function transform(array $config)
  {
    return new static($config);
  }

  public function __construct(array $config)
  {
    $this->config = $this->parseConfig($config);
  }

  public function getConfig()
  {
    return $this->config;
  }

  abstract protected function parseConfig(array $config);

  protected function traversePath(array $value, $path, $contextPath = '')
  {
    $pathParts = explode('.', $path, 2);

    if (!isset($value[$pathParts[0]])) {
      // check if this is an array value; lazy preg
        if (preg_match('/^\d+$/', implode('', array_keys($value)))) {
            $results = [];

            foreach ($value as $valueElement) {
                $results[] = $this->traversePath($valueElement, $path, $contextPath);
            }

            return $results;
        }

      throw new PathMissingException($contextPath . $pathParts[0]);
    }

    if (!isset($pathParts[1])) {
      return $value[$pathParts[0]];
    }

    return $this->traversePath($value[$pathParts[0]], $pathParts[1], $contextPath . $pathParts[0] . '.');
  }
}
