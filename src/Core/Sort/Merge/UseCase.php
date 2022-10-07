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
        $this->logger->info('start UseCase');

//        $newList = $this->mergeSort($inputDto->getElement(), 0, $inputDto->amount());

        $this->logger->info('end UseCase');

        return new OutputDto($inputDto->getElement());
    }

    private function mergeSort(array $list, int $start, int $end): array
    {
        $middle = floor(($start + $end) / 2);

        $list = $this->mergeSort($list, $start, $middle);
        $list = $this->mergeSort($list, $middle, $end);
    }

    private function explodeElements($elements)
    {
        // [1,2]

        if (count($elements) == 1) {
            return $elements;
        }

        $newList = [];

        foreach ($elements as $element) {
            $newList[] = $this->explodeElements($element);
        }

        return $newList;
    }
}
