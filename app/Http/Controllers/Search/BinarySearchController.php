<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\Search\BinarySearch\IndexRequest;
use Core\Search\BinarySearch\InputDto;
use Core\Search\BinarySearch\UseCase;
use Illuminate\Http\Response;

class BinarySearchController extends Controller
{

    public function index(IndexRequest $indexRequest): Response
    {

        $needle = (int)$indexRequest->needle;
        $haystack = explode(',', $indexRequest->haystack);

        sort($haystack);
        $useCase = new UseCase($this->logger);
        $result = $useCase->execute(new InputDto($needle, $haystack));

        return $this->makeResponse(
            $result->toJson(),
            200,
            sprintf('%s - Everything it is OK', env('APP_IDENTIFIER'))
        );
    }

}
