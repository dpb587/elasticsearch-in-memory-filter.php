<?php

namespace DPB\ElasticsearchInMemoryFilter\Filter;

use DPB\ElasticsearchInMemoryFilter\FilterInterface;
use DPB\ElasticsearchInMemoryFilter\Transformer;

class OrFilter extends AbstractFilter
{
    public static function transform(array $config)
    {
        return parent::transform(
      array_map(
        function ($config) {
            return Transformer::transform($config);
        },
        $config
      )
    );
    }

    public function match(array $value)
    {
        foreach ($this->config as $filter) {
            if ($filter->match($value)) {
                return true;
            }
        }

        return false;
    }

    protected function parseConfig(array $config)
    {
        foreach ($config as $filter) {
            if (!$filter instanceof FilterInterface) {
                throw new \InvalidArgumentException(sprintf('Expected instance of FilterInterface, but got %s', get_class($filter)));
            }
        }

        return $config;
    }
}
