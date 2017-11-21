<?php

namespace DPB\ElasticsearchInMemoryFilter\Filter;

use DPB\ElasticsearchInMemoryFilter\Exception\PathMissingException;

class MatchAllFilter extends AbstractFilter
{
    public function match(array $value)
    {
        return true;
    }

    protected function parseConfig(array $config)
    {
        return [];
    }
}
