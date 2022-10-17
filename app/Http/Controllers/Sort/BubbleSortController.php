<?php

namespace App\Http\Controllers\Sort;

use App\Factories\GenerateListFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sort\BubbleSort\IndexRequest;
use Core\Sort\BubbleSort\InputDto;
use Core\Sort\BubbleSort\UseCase;
use Illuminate\Http\Response;

class BubbleSortController extends Controller
{

    public function index(IndexRequest $indexRequest): Response
    {
        if (!empty($indexRequest->rand)) {
            $elements = GenerateListFactory::generate($indexRequest->rand);
        } else {
            $elements = explode(',', $indexRequest->list);
        }

        $verbose = $indexRequest->verbose ?? false;

        $useCase = new UseCase($this->logger, $verbose);
        $result = $useCase->execute(new InputDto($elements));

        $start = microtime(true);
        sort($elements);
        $end = microtime(true);

        return $this->makeResponse(
            $result->toJson() + ['sort_php_time' => $end - $start],
            200,
            sprintf('%s - Everything it is OK', env('APP_IDENTIFIER'))
        );
    }

}
