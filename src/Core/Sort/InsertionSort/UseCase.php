<?php

namespace Core\Sort\InsertionSort;

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

        for ($currentKey = 1; $currentKey < $length; $currentKey++) {
            $previousKey = $currentKey - 1;
            $element = $elements[$currentKey];
            while ($previousKey >= 0 && $elements[$previousKey] > $element) {
                $elements[$previousKey + 1] = $elements[$previousKey];
                $previousKey--;
            }
            $elements[$previousKey + 1] = $element;
        }

        return $elements;
    }

    private function sort2(array $elements): array
    {
        $keys = count($elements) - 1;

        for ($key = 1; $key <= $keys; $key++) {
            $previousKey = $key - 1;
            $element = $elements[$key];

            while ($previousKey >= 0 && $elements[$previousKey] > $element) {
                $elements[$previousKey + 1] = $elements[$previousKey];
                $previousKey --;
            }

            $elements[$previousKey + 1] = $element;
        }

        return $elements;
    }

}
