<?php

namespace Core\Sort\BubbleSort;

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
        $continue = false;
        for ($i = 0; $i < count($elements) - 1; $i++) {
            if ($elements[$i] > $elements[$i + 1]) {
                $continue = true;
                $aux = $elements[$i];
                $elements[$i] = $elements[$i + 1];
                $elements[$i + 1] = $aux;
            }
        }

        if ($continue) {
            return $this->sort($elements);
        }

        return $elements;
    }
}
