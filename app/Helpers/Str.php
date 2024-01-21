<?php

namespace App\Helpers;

class Str
{
    public function __construct(private string $text = '')
    {
    }

    public static function make(string $text)
    {
        return new static($text);
    }

    public function toString()
    {
        return $this->text;
    }

    public function toInt(): int
    {
        return (int)$this->text;
    }

    public function trim(string $characters): self
    {
        $this->text = trim($this->text, $characters);
        return $this;
    }

    public function replace(string $search, string$replace): self
    {
        $this->text = str_replace($search, $replace, $this->text);
        return $this;
    }
}