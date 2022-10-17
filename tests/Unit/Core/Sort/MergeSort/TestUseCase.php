<?php

namespace Tests\Unit\Core\Sort\MergeSort;

use Core\Geral\Interface\LoggerInterface;
use Core\Sort\Merge\InputDto;
use Core\Sort\Merge\UseCase;
use PHPUnit\Framework\TestCase;

class TestUseCase extends TestCase
{

    public function testUseCase()
    {
        $mockLogger = $this->createMock(LoggerInterface::class);

        $elements = [1, 5, 6, 1, 2, 5];
        $useCase = new UseCase($mockLogger);
        $response = $useCase->execute(new InputDto($elements));

        sort($elements);
        $this->assertEquals(json_encode($elements), json_encode($response->getSortedList()));
    }
}
