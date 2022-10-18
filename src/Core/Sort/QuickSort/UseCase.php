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
        $this->quickSort($elements, 0, count($elements) -1, $logOperation);

        $this->logger->info('ended UseCase');
        $end = microtime(true);

        $this->validateSort($inputDto->getElement(), $elements);

        return new OutputDto($inputDto->getElement(), $elements, ($end - $start), $logOperation);
    }

    private function quickSort(array &$elements, $start, $end, LogOperation $logOperation = null): void
    {
        if ($start > $end) {
            return ;
        }

        $pivotIndex = $this->run($elements, $start, $end);

        $logOperation = $logOperation?->setLeft(new LogOperation(array_slice($elements, $start, $pivotIndex - $start)));
        $this->quickSort($elements, $start, $pivotIndex - 1, $logOperation?->getLeft());

        $logOperation = $logOperation?->setRight(new LogOperation(array_slice($elements, $pivotIndex, $end - $pivotIndex+1)));
        $this->quickSort($elements, $pivotIndex + 1, $end, $logOperation?->getRight());
    }

    private function run(array &$elements, $start, $end): int
    {
        $pivot = $elements[$end];

        $iLeft = $start;
        for ($i = $start; $i < $end; $i++) {
            if ($elements[$i] <= $pivot) {
                $aux = $elements[$i];
                $elements[$i] = $elements[$iLeft];
                $elements[$iLeft] = $aux;
                $iLeft ++;
            }
        }

        $elements[$end] = $elements[$iLeft];
        $elements[$iLeft] = $pivot;

        return $iLeft;
    }

}
