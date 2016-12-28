<?php

namespace DPB\ElasticsearchInMemoryFilter;

interface FilterInterface
{
  public function match(array $value);
}
