<?php

namespace Core\Search\BinarySearch;

use Core\Geral\Interface\LoggerInterface;

class UseCase
{
    public function __construct(
        public LoggerInterface $logger,
        public bool            $verbose = false
    )
    {
    }

    public function execute(InputDto $inputDto): OutputDto
    {
        $this->logger->info('started UseCase');
        $start = microtime(true);

        $index = $this->search($inputDto->getNeedle(), $inputDto->getHaystack(), 0, $inputDto->amount() - 1);

        $this->logger->info('ended UseCase');
        $end = microtime(true);

        return new OutputDto($inputDto->getNeedle(), $inputDto->getHaystack(), $index, ($end - $start));
    }

    private function search(int $needle, array $haystack, int $start, int $end): ?int
    {
        if ($end < $start) {
            return null;
        }

        $middle = floor(($start + $end) / 2);

        if ($haystack[$middle] == $needle) {
            return $middle;
        } elseif ($needle > $haystack[$middle]) {
            return $this->search($needle, $haystack, $middle + 1, $end);
        } else {
            return $this->search($needle, $haystack, $start, $middle - 1);
        }
    }


}
