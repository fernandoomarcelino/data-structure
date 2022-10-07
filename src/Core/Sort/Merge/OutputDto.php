<?php

namespace Core\Sort\Merge;

class OutputDto
{
    public function __construct(public array $element)
    {
    }

    public function getElement(): array
    {
        return $this->element;
    }
}
