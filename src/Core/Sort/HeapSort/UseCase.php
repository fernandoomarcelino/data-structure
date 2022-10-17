<?php

namespace Core\Sort\HeapSort;

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

        $newList = $this->heapSort($elements, $logOperation);
        $this->validateSort($elements, $newList);

        $this->logger->info('ended UseCase');
        $end = microtime(true);

        return new OutputDto($elements, $newList, ($end - $start), $logOperation);
    }

    private function heapSort(array $elements, LogOperation $logOperation = null): array
    {
        $length = count($elements);

        if ($length <= 1) {
            return $elements;
        }

        for ($i = $length / 2 - 1; $i >= 0; $i--) {
            $logOperation = $logOperation?->setLeft(new LogOperation([$elements[$i]]))->getLeft();
            $this->run($elements, $length, $i, $logOperation);
        }

        for ($i = $length - 1; $i > 0; $i--) {
            $this->reverseOrdem($elements, 0, $i);
            $this->run($elements, $i, 0, $logOperation);
        }

        return $elements;
    }

    private function run(array &$elements, $length, $source, LogOperation $logOperation = null): void
    {
        $newSource = $source;
        $left = $source * 2 + 1;
        $right = $source * 2 + 2;

        if ($left < $length && $elements[$left] > $elements[$newSource]) {
            $newSource = $left;
        }

        if ($right < $length && $elements[$right] > $elements[$newSource]) {
            $newSource = $right;
        }

        $logOperation = $logOperation?->setLeft(new LogOperation([$elements[$newSource]]))->getLeft();

        if ($newSource != $source) {
            $this->reverseOrdem($elements, $source, $newSource);
            $this->run($elements, $length, $newSource, $logOperation);
        }
    }

    private function reverseOrdem(&$elements, $first, $second): void
    {
        $aux = $elements[$first];
        $elements[$first] = $elements[$second];
        $elements[$second] = $aux;
    }


}
