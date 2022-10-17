<?php

namespace Core\Sort\QuickSort;

use Core\Geral\Entity\LogOperation;
use Core\Geral\Interface\LoggerInterface;
use Core\Geral\Trait\ValidateSort;

class UseCase
{
    use ValidateSort;

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
        $newList = $this->quickSort($elements, $logOperation);

        $this->logger->info('ended UseCase');
        $end = microtime(true);

        $this->validateSort($elements, $newList);

        return new OutputDto($elements, $newList, ($end - $start), $logOperation);
    }

    private function quickSort(array $elements, LogOperation $logOperation = null): array
    {

        if (count($elements) <= 1) {
            return $elements;
        }
        $pivotIndex = $this->run($elements);

        $leftElements = array_slice($elements, 0, $pivotIndex);
        $logOperation = $logOperation?->setLeft(new LogOperation($leftElements))->getLeft();
        $left = $this->quickSort($leftElements, $logOperation);

        $rightElements = array_slice($elements, $pivotIndex);
        $logOperation = $logOperation?->setRight(new LogOperation($rightElements))->getRight();
        $right = $this->quickSort($rightElements, $logOperation);

        return array_merge($left, $right);
    }

    private function run(array &$elements): int
    {
        $lastIndex = count($elements) - 1;
        $pivot = $elements[$lastIndex];

        $iLeft = 0;
        foreach ($elements as $iRight => $element) {
            if ($element <= $pivot) {
                $elements[$iRight] = $elements[$iLeft];
                $elements[$iLeft] = $element;
                $iLeft++;
            }
        }

        if ($iLeft > $lastIndex) {
            $iLeft = $lastIndex;
        }

        $aux = $elements[$lastIndex];
        $elements[$lastIndex] = $elements[$iLeft];
        $elements[$iLeft] = $aux;

        return $iLeft;
    }

}
