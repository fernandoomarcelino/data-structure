<?php

namespace Core\Sort\MergeSort;

class InputDto
{

    public function __construct(public array $element)
    {
    }

    public function getElement(): array
    {
        return $this->element;
    }

    public function amount(): int
    {
        return count($this->getElement());
    }


}
