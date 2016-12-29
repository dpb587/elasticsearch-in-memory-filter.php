<?php

namespace DPB\ElasticsearchInMemoryFilter\Filter;

use DPB\ElasticsearchInMemoryFilter\Exception\PathMissingException;
use DPB\ElasticsearchInMemoryFilter\FilterInterface;
use DPB\ElasticsearchInMemoryFilter\Transformer;

class NestedFilter extends AbstractFilter
{
    public static function transform(array $config)
    {
        if (isset($config['filter'])) {
            $config['filter'] = Transformer::transform($config['filter']);
        }
        
        return parent::transform($config);
    }

    public function match(array $value)
    {
        try {
            $nestedValues = $this->traversePath($value, $this->config['path']);
        } catch (PathMissingException $e) {
            return false;
        }

        if (!is_array($nestedValues)) {
            throw new \UnexpectedValueException(sprintf('Expected array at %s', $this->config['path']));
        }

        foreach ($nestedValues as $nestedValue) {
            if ($this->config['filter']->match($this->overridePath($value, $this->config['path'], $nestedValue))) {
                return true;
            }
        }

        return false;
    }

    protected function parseConfig(array $config)
    {
        if (!isset($config['path'])) {
            throw new \InvalidArgumentException('Expected path to be set for filter');
        } elseif (!is_string($config['path'])) {
            throw new \InvalidArgumentException('Expected path to be string for filter');
        } elseif (!isset($config['filter'])) {
            throw new \InvalidArgumentException('Expected filter to be set for filter');
        } elseif (!$config['filter'] instanceof FilterInterface) {
            throw new \InvalidArgumentException(sprintf('Expected instance of FilterInterface, but got %s', get_class($config['filter'])));
        }

        return $config;
    }

    protected function overridePath(array $value, $path, $replace)
    {
        $pathParts = explode('.', $path);
        $pathLast = array_pop($pathParts);

        $root = $value;
        $context =& $root;

        foreach ($pathParts as $pathPart) {
            $context =& $context[$pathPart];
        }

        $context[$pathLast] = $replace;

        return $root;
    }
}
