<?php

namespace Core\Case\BinaryTree;

use Core\Geral\Entity\Node;
use Core\Geral\Interface\LoggerInterface;
use Core\Geral\Trait\ValidateSort;

class UseCase
{
    use ValidateSort;

    public function __construct(
        public LoggerInterface $logger,
        public bool            $verbose = false
    )
    {
    }

    public function execute(InputDto $inputDto): OutputDto
    {
        $this->logger->info('started UseCase');
        $start = microtime(true);

        $result = [];

        $this->inorder($inputDto->tree->root, $result);

        $this->logger->info('ended UseCase');
        $end = microtime(true);

        return new OutputDto($inputDto->tree->showPostorder(), $result, $inputDto->tree->height(), ($end - $start));
    }


    private function inorder(?Node $root, array &$result): void
    {
        if (!is_null($root->left)) {
            $result[] = '(';
            $this->inorder($root->left, $result);
        }

        $result[] = $root->data;

        if (!is_null($root->right)) {
            $this->inorder($root->right, $result);
            $result[] = ')';
        }
    }
}
