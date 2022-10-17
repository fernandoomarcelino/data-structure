<?php

namespace Core\Sort\InsertionSort;

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

        $newList = $this->sort($elements);
        $this->validateSort($elements, $newList);

        $this->logger->info('ended UseCase');
        $end = microtime(true);

        return new OutputDto($elements, $newList, ($end - $start));
    }

    private function sort(array $elements): array
    {
        $length = count($elements);

        for ($i = 1; $i <= $length -1; $i++) {
            $chave = $elements[$i];
            $j = $i -1;
            while ($j >= 0 && $elements[$j] > $chave) {
                $elements[$j+1] = $elements[$j];
                $j--;
            }
            $elements[$j+1] = $chave;
        }

        return $elements;
    }

}
