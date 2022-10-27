<?php

namespace Core\Geral\Entity;

class Tree
{
    public function __construct(public ?Node $root = null)
    {
    }

    public function showPostorder(Node $node = null): array
    {
        if (!$node) {
            $node = $this->root;
        }

        $result = [];
        if (!is_null($node->left)) {
            $left = $this->showPostorder($node->left);
            $result = array_merge($result, $left);
        }

        if (!is_null($node->right)) {
            $right = $this->showPostorder($node->right);
            $result = array_merge($result, $right);
        }

        $result[] = $node->data;

        return $result;
    }

    public function height(Node $node = null): int
    {
        if (!$node) {
            $node = $this->root;
        }

        $hLeft = 0;
        if ($node->left) {
            $hLeft = $this->height($node->left);
        }

        $hRight = 0;
        if ($node->right) {
            $hRight = $this->height($node->right);
        }

        return max($hLeft, $hRight) + 1;
    }
}
