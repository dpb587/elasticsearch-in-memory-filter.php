# elasticsearch-in-memory-filter.php

Reuse elasticsearch filters for matching in-memory arrays.

## Example

```php
use DPB\ElasticsearchInMemoryFilter as _;

$doc = [
  'name' => 'Dublin Pizza Company',
  'type' => 'restaurant',
  'categories' => [
    [
      'id' => 12345,
      'name' => 'pizza',
    ],
  ],
];

$esFilter = [
  'and' => [
    [
      'term' => [
        'type' => 'restaurant',
      ],
    ],
    [
      'nested' => [
        'path' => 'categories',
        'filter' => [
          'term' => [
            'name' => 'pizza',
          ],
        ],
      ],
    ],
  ],
];

$filter = _\Transformer::transform($esFilter);

var_export($filter->match($doc));
// true

$filter = new _\Filter\TermFilter([ 'type' => 'restaurant' ]);

var_export($filter->match($doc));
// true

var_export($filter->match([ 'type' => 'cafe' ]));
// false
```

## License

[MIT License](./LICENSE)
