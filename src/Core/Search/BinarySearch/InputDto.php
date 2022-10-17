<?php

namespace Core\Search\BinarySearch;

class InputDto
{

    public function __construct(
        protected int   $needle,
        protected array $haystack,
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

    public function amount(): int
    {
        return count($this->getHaystack());
    }


}
