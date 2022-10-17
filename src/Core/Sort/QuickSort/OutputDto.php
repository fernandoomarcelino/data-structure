<?php

namespace Core\Sort\QuickSort;

use Core\Geral\Entity\LogOperation;

class OutputDto
{

    const ALGORITHM = 'QuickSort';

    public function __construct(
        public array $originalList,
        public array $sortedList,
        public       $time,
        public ?LogOperation $operationLog
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
//            'originalList' => implode(', ', $this->originalList),
//            'sortedList' => implode(', ', $this->sortedList),
            'time' => $this->time,
//            'operationLog' => $this->operationLog->toJson()
        ];
    }
}
