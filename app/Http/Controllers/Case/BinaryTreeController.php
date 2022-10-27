<?php

namespace App\Http\Controllers\Case;

use App\Factories\GenerateListFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sort\BubbleSort\IndexRequest;
use Core\Case\BinaryTree\InputDto;
use Core\Case\BinaryTree\UseCase;
use Core\Geral\FactoryTree;
use Illuminate\Http\Response;

class BinaryTreeController extends Controller
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

        $tree = FactoryTree::create();
        $result = $useCase->execute(new InputDto($tree));

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
