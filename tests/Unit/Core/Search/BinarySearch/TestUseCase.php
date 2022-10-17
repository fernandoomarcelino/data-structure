<?php

namespace Tests\Unit\Core\Search\BinarySearch;

use App\Factories\GenerateListFactory;
use Core\Geral\Interface\LoggerInterface;
use Core\Search\BinarySearch\InputDto;
use Core\Search\BinarySearch\UseCase;
use PHPUnit\Framework\TestCase;

class TestUseCase extends TestCase
{

    /**
     * @dataProvider useCaseDataprovider
     */
    public function testUseCase($expecedValue, $needle, $haystack)
    {
        $mockLogger = $this->createMock(LoggerInterface::class);

        $useCase = new UseCase($mockLogger);
        $response = $useCase->execute(new InputDto($needle, $haystack));

        $this->assertEquals($expecedValue, $response->getIndex());
    }

    protected function useCaseDataprovider()
    {
        $listPair = [-50, -49, 0, 49, 50, 51];
        $listOdd = [-50, -49, 0, 49, 50];
        $listRepeated = [-50, -49, 0 , 0, 0, 49, 50];
        return [
            'empty_haystack' => [
                'expected_result' => null,
                'needle' => -60,
                'haystack' => [],
            ],
            'found_haystack_one_element' => [
                'expected_result' => null,
                'needle' => 1,
                'haystack' => [1],
            ],
            'not_found_less_than_minimum' => [
                'expected_result' => null,
                'needle' => -60,
                'haystack' => $listPair,
            ],
            'not_found_greater_than_maximum' => [
                'expected_result' => null,
                'needle' => 60,
                'haystack' => $listPair,
            ],
            'found_is_first_pair' => [
                'expected_result' => 0,
                'needle' => -50,
                'haystack' => $listPair,
            ],
            'found_is_last_pair' => [
                'expected_result' => 5,
                'needle' => 51,
                'haystack' => $listPair,
            ],
            'found_is_first_odd' => [
                'expected_result' => 0,
                'needle' => -50,
                'haystack' => $listOdd,
            ],
            'found_is_last_odd' => [
                'expected_result' => 4,
                'needle' => 50,
                'haystack' => $listOdd,
            ],
            'found_in_repeated_list' => [
                'expected_result' => 3,
                'needle' => 0,
                'haystack' => $listRepeated,
            ]
        ];
    }
}
