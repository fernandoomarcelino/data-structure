<?php

namespace Core\Sort\BubbleSort;

class OutputDto
{
    const ALGORITHM = 'BubbleSort';

    public function __construct(
        public array $originalList,
        public array $sortedList,
        public       $time,
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
            'algorithm' => self::ALGORITHM,
//            'originalList' => implode(',', $this->originalList),
//            'sortedList' => implode(',', $this->sortedList),
            'time' => $this->time,
        ];
    }
}
