<?php

namespace Core\Case\PrintLeftViewOfBinaryTree;



use Core\Case\PrintLeftViewOfBinaryTree\Entity\Node;
use Core\Case\PrintLeftViewOfBinaryTree\Entity\Tree;

class FactoryTree
{

    public static function create(): Tree
    {
        $tree = new Tree();

        $n1 = new Node('a');
        $n2 = new Node('+');
        $n3 = new Node('*');
        $n4 = new Node('b');
        $n5 = new Node('-');
        $n6 = new Node('/');
        $n7 = new Node('c');
        $n8 = new Node('d');
        $n9 = new Node('e');

        $n6->left = $n7;
        $n6->right = $n8;

        $n5->left = $n6;
        $n5->right = $n9;

        $n3->left = $n4;
        $n3->right = $n5;

        $n2->left = $n1;
        $n2->right = $n3;

        $tree->root = $n2;

        return $tree;
    }

}
