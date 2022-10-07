<?php

namespace Core\Sort\Merge;

class OutputDto
{
    public function __construct(
        public array $originalList,
        public array $sortedList,
        public       $time
    )
    {
    }

    public function getOriginalList(): array
    {
        return $this->originalList;
    }

    public function getSortedList(): array
    {
        return $this->sortedList;
    }

    public function toJson(): array
    {
        return [
//            'originalList' => $this->originalList,
//            'sortedList' => $this->sortedList,
            'time' => $this->time
        ];
    }
}
