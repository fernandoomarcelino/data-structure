<?php

namespace App\Http\Controllers\Sort;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sort\Merge\IndexRequest;
use Core\Sort\Merge\InputDto;
use Core\Sort\Merge\UseCase;
use \Illuminate\Http\Response;

class MergeSortController extends Controller
{

    public function index(IndexRequest $indexRequest)
    {
        $this->logger::debug($indexRequest->list);

        $elements = explode(',', $indexRequest->list);

        $useCase = new UseCase($this->logger);
        $useCase->execute(new InputDto($elements));

        return new Response(
            [
                'data' => [],
                'status' => [
                    'code' => 200,
                    'message' => sprintf('%s - Everything it is OK', env('APP_IDENTIFIER'))
                ],
            ],
            200
        );

    }

}
