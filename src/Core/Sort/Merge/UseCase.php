<?php

namespace Core\Sort\Merge;

use Core\Geral\Interface\LoggerInterface;

class UseCase
{

    public function __construct(
        public LoggerInterface $logger
    )
    {
    }

    public function execute(InputDto $inputDto): OutputDto
    {
        $this->logger->info('started UseCase');
        $start = microtime(true);

        $newList = $this->mergeSort($inputDto->getElement(), 0, $inputDto->amount() -1);

        $this->logger->info('ended UseCase');
        $end = microtime(true);

        return new OutputDto($inputDto->getElement(), $newList, ($end-$start));
    }

    private function mergeSort(array $elements): array
    {
        if (count($elements) == 1) {
            return $elements;
        }

        $middle = floor(count($elements) / 2);

        $left = $this->mergeSort(array_slice($elements, 0 ,$middle));
        $right = $this->mergeSort(array_slice($elements, $middle));
        return $this->implodeElements($left, $right);
    }

    private function implodeElements($lefts, $rights): array
    {
        $i = 0;
        $countElements = (count($lefts) + count($rights)) - 1;

        $firstLeft = 0;
        $firstRight = 0;
        $result = [];
        while ($i <= $countElements) {
            if ($firstLeft >= count($lefts)) {
                $result[] = $rights[$firstRight];
                $firstRight++;
            } elseif ($firstRight >= count($rights)) {
                $result[] = $lefts[$firstLeft];
                $firstLeft++;
            } elseif ($lefts[$firstLeft] < $rights[$firstRight]) {
                $result[] = $lefts[$firstLeft];
                $firstLeft++;
            } else {
                $result[] = $rights[$firstRight];
                $firstRight++;
            }

            $i++;
        }

        return $result;
    }
}
