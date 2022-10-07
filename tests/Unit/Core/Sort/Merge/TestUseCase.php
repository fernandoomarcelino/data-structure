<?php

namespace Tests\Unit\Core\Sort\Merge;

use Core\Geral\Interface\LoggerInterface;
use Core\Sort\Merge\InputDto;
use Core\Sort\Merge\UseCase;
use PHPUnit\Framework\TestCase;

class TestUseCase extends TestCase
{


    public function testExplodeElements()
    {
        $mockLogger = $this->createMock(LoggerInterface::class)
            ->expects($this->atLeast(1))
            ->method('info');
        $useCase = new UseCase($mockLogger);
        $response = $useCase->execute(new InputDto([1,2,3]));

        $this->assertEquals([1,2,3], $response->getElement());
    }
}
