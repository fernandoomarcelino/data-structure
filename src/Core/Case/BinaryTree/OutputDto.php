<?php

namespace Core\Case\BinaryTree;

class OutputDto
{
    const ALGORITHM = 'BinaryTree';

    public function __construct(
        public array $originalList,
        public array $sortedList,
        public int $height,
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
            'originalList' => implode(',', $this->originalList),
            'sortedList' => implode('', $this->sortedList),
            'height' => $this->height,
            'time' => $this->time,
        ];
    }
}
