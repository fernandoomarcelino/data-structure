<?php

namespace App\Http\Controllers;

use App\Adapter\Geral\LoggerAdapter;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected $startIndex;
    public function __construct(protected LoggerAdapter $logger)
    {
        $this->startIndex = microtime(true);
    }

    protected function makeResponse(array $data, int $statusCode, string $statusMessage): Response
    {
        $endIndex = microtime(true);
        return new Response(
            [
                'data' => $data,
                'status' => [
                    'code' => $statusCode,
                    'message' => $statusMessage,
                    'processing_time' => $endIndex - $this->startIndex
                ],
            ],
            200
        );
    }


}
