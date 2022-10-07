<?php

namespace App\Http\Controllers\Sort;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sort\Merge\IndexRequest;
use Core\Sort\Merge\InputDto;
use Core\Sort\Merge\UseCase;
use Illuminate\Http\Response;
use Mockery\Exception;

class MergeSortController extends Controller
{

    public function index(IndexRequest $indexRequest)
    {
        $startIndex = microtime(true);
        if (!empty($indexRequest->rand)) {
            $elements = self::listFactory($indexRequest->rand);
        } else {
            $elements = explode(',', $indexRequest->list);
        }

        $useCase = new UseCase($this->logger);
        $result = $useCase->execute(new InputDto($elements));

        $start = microtime(true);
        sort ($elements);
        $end = microtime(true);

        $endIndex = microtime(true);

        return new Response(
            [
                'data' => $result->toJson() + ['sort_php_time' => $end-$start],
                'status' => [
                    'code' => 200,
                    'message' => sprintf('%s - Everything it is OK', env('APP_IDENTIFIER')),
                    'processing_time' => $endIndex - $startIndex
                ],
            ],
            200
        );
    }

    public static function listFactory(int $length): array
    {
        if ($length <= 0) {
            throw new Exception('invalid length');
        }

        $result = [];
        $i = 0;
        while ($i <= $length) {
            $result[] = rand(0, 999999999);
            $i++;
        }

        return $result;
    }

}
