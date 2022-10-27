<?php

namespace Core\Sort\HeapSort;

use Core\Geral\Entity\LogOperation;

class OutputDto
{
    const ALGORITHM = 'HeapSort';

    public function __construct(
        public array         $originalList,
        public array         $sortedList,
        public               $time,
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
//            'originalList' => $this->originalList,
//            'sortedList' => $this->sortedList,
            'time' => $this->time,
            'operationLog' => $this->operationLog ? $this->operationLog->toJson() : []
        ];
    }
}
