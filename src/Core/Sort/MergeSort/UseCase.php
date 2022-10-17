<?php

namespace Core\Sort\MergeSort;

use Core\Geral\Entity\LogOperation;
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

        $elements = $inputDto->getElement();

        $logOperation = null;
        if ($this->verbose) {
            $logOperation = new LogOperation($elements);
        }

        $newList = $this->mergeSort($inputDto->getElement(), $logOperation);

        $this->logger->info('ended UseCase');
        $end = microtime(true);

        return new OutputDto($inputDto->getElement(), $newList, ($end - $start), $logOperation);
    }

    private function mergeSort(array $elements, LogOperation $logOperation = null): array
    {
        if (count($elements) == 1) {
            return $elements;
        }

        $middle = floor(count($elements) / 2);

        $leftElements = array_slice($elements, 0, $middle);
        $logOperation = $logOperation?->setLeft(new LogOperation($leftElements))->getLeft();
        $left = $this->mergeSort($leftElements, $logOperation);

        $rightElements = array_slice($elements, $middle);
        $logOperation = $logOperation?->setRight(new LogOperation($rightElements))->getRight();
        $right = $this->mergeSort($rightElements, $logOperation);

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
