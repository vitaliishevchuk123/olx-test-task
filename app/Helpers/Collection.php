<?php

namespace App\Helpers;

class Collection
{
    public function __construct(private array $items = [])
    {
    }

    public function isEmpty(): bool
    {
        return !count($this->items);
    }

    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    public function add($item): void
    {
        $this->items[] = $item;
    }

    public function all(): array
    {
        return $this->items;
    }

    public function where(string $key, $value): Collection
    {
        $filteredItems = array_filter($this->items, function ($item) use ($key, $value) {
            $method = 'get' . ucfirst($key);
            return isset($item->$key) && $item->$key == $value || method_exists($item, $method) && $item->{$method}() == $value;
        });

        return new static($filteredItems);
    }

    public function first()
    {
        return array_values($this->items)[0] ?? null;
    }

}