<?php

namespace Core\Geral\Entity;

class Node
{
    public ?Node $left = null;
    public ?Node $right = null;

    public function __construct(public string $data)
    {
    }

}
