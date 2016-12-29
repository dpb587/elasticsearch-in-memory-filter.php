<?php

namespace DPB\ElasticsearchInMemoryFilter;

class Transformer
{
    const CLASSMAP = [
    'and' => 'DPB\\ElasticsearchInMemoryFilter\\Filter\\AndFilter',
    'nested' => 'DPB\\ElasticsearchInMemoryFilter\\Filter\\NestedFilter',
    'or' => 'DPB\\ElasticsearchInMemoryFilter\\Filter\\OrFilter',
    'term' => 'DPB\\ElasticsearchInMemoryFilter\\Filter\\TermFilter',
  ];

    private function __construct()
    {
    }

    public static function transform(array $filter)
    {
        if (count($filter) != 1) {
            throw new \InvalidArgumentException('Expected one and only one element in filter');
        }

        $filterType = key($filter);

        if (!array_key_exists($filterType, static::CLASSMAP)) {
            throw new \InvalidArgumentException(sprintf('Unknown filter type: %s', $filterType));
        }

        return call_user_func([static::CLASSMAP[$filterType], 'transform'], current($filter));
    }
}
