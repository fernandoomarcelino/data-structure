<?php

namespace Core\Search\BinarySearch;

class OutputDto
{
    const ALGORITHM = 'BinarySearch';

    public function __construct(
        public int   $needle,
        public array $haystack,
        public ?int  $index,
        public       $time,
    )
    {
    }

    public function getNeedle(): int
    {
        return $this->needle;
    }

    public function getHaystack(): array
    {
        return $this->haystack;
    }

    public function getIndex(): ?int
    {
        return $this->index;
    }

    public function toJson(): array
    {
        return [
            'algorithm' => self::ALGORITHM,
            'index needle' => is_null($this->getIndex()) ? 'element doesnt founded' : sprintf('element founded at position: %s', $this->getIndex()),
//            'needle' => $this->getNeedle(),
//            'haystack' => $this->getHaystack(),
            'time' => $this->time,
        ];
    }
}
