<?php

namespace App\Http\Controllers\Sort;

use App\Factories\GenerateListFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sort\QuickSort\IndexRequest;
use Core\Sort\HeapSort\InputDto as HeapSortInputDto;
use Core\Sort\HeapSort\UseCase as HeapSortUseCase;
use Core\Sort\InsertionSort\InputDto as InsertionSortInputDto;
use Core\Sort\InsertionSort\UseCase as InsertionSortUseCase;
use Core\Sort\MergeSort\InputDto as MergeSortInputDto;
use Core\Sort\MergeSort\UseCase as MergeSortUseCase;
use Core\Sort\QuickSort\InputDto as QuickSortInputDto;
use Core\Sort\QuickSort\UseCase as QuickSortUseCase;
use Core\Sort\SelectionSort\InputDto as SelectionSortInputDto;
use Core\Sort\SelectionSort\UseCase as SelectionSortUseCase;
use Core\Sort\BubbleSort\InputDto as BubbleSortInputDto;
use Core\Sort\BubbleSort\UseCase as BubbleSortUseCase;
use Illuminate\Http\Response;

class SortController extends Controller
{

    public function index(IndexRequest $indexRequest): Response
    {

        if (!empty($indexRequest->rand)) {
            $elements = GenerateListFactory::generate($indexRequest->rand);
        } else {
            $elements = explode(',', $indexRequest->list);
        }

        $quickSortResult = (new QuickSortUseCase($this->logger))->execute(new QuickSortInputDto($elements));
        $mergeSortResult = (new MergeSortUseCase($this->logger))->execute(new MergeSortInputDto($elements));
        $heapSortResult = (new HeapSortUseCase($this->logger))->execute(new HeapSortInputDto($elements));
        $insertionSortResult = (new InsertionSortUseCase($this->logger))->execute(new InsertionSortInputDto($elements));
        $selectionSortResult = (new SelectionSortUseCase($this->logger))->execute(new SelectionSortInputDto($elements));
        $bubbleSortResult = (new BubbleSortUseCase($this->logger))->execute(new BubbleSortInputDto($elements));

        $data = [
            $quickSortResult->toJson(),
            $mergeSortResult->toJson(),
            $heapSortResult->toJson(),
            $insertionSortResult->toJson(),
            $selectionSortResult->toJson(),
            $bubbleSortResult->toJson(),
            [
                'algorithm' => 'php.sort()',
                'time' => self::phpSort($elements)
            ],
            [
//                'originalList' => implode(', ', $heapSortResult->originalList),
//                'sortedList' => implode(', ', $heapSortResult->sortedList),
            ]
        ];
        return $this->makeResponse(
            array_values($data),
            200,
            sprintf('%s - Everything it is OK', env('APP_IDENTIFIER'))
        );
    }


    public static function phpSort($elements)
    {
        $start = microtime(true);
        sort($elements);
        $end = microtime(true);

        return $end - $start;
    }


}
