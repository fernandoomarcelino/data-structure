<?php

namespace Core\Case\PrintLeftViewOfBinaryTree;

use Core\Geral\Entity\Node;
use Core\Geral\Interface\LoggerInterface;
use Core\Geral\Trait\ValidateSort;
use Core\Geral\FactoryTree;

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

        $tree = FactoryTree::create();

        $result = [];
        $maxLevel = 0;
        $this->leftView($inputDto->tree->root, $result, 0,$maxLevel);

        $this->logger->info('ended UseCase', $result);
        $end = microtime(true);

        return new OutputDto($tree->showPostorder(), $result, ($end - $start));
    }


    private function leftView(?Node $node, array &$result, $level, &$maxLevel): void
    {
        if (is_null($node)) {
            return;
        }

        if ($maxLevel < $level) {
            $result[] = $node->data;
            $maxLevel = $level;
        }

        $level ++;

        $this->leftView($node->left, $result, $level, $maxLevel);
        $this->leftView($node->right, $result, $level, $maxLevel);
    }
}
