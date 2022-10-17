<?php

namespace Core\Sort\SelectionSort;

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

        $newList = $this->sort($elements);
        $this->validateSort($elements, $newList);

        $this->logger->info('ended UseCase');
        $end = microtime(true);

        return new OutputDto($elements, $newList, ($end - $start));
    }

    private function sort(array $elements): array
    {
        $length = count($elements);

        for ($i = 0; $i < $length; $i++) {
            $minValueIndex = $i;
            for ($j = $i + 1; $j < $length; $j++) {
                if ($elements[$j] < $elements[$minValueIndex]) {
                    $minValueIndex = $j;
                }
            }

            if ($elements[$minValueIndex] < $elements[$i]) {
                $aux = $elements[$minValueIndex];
                $elements[$minValueIndex] = $elements[$i];
                $elements[$i] = $aux;
            }
        }

        return $elements;
    }
}
