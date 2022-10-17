<?php

namespace Core\Geral\Trait;

trait ValidateSort
{
    public function validateSort(array $elements1, array $elements2): void
    {
        sort($elements1);
        if ($elements1 != $elements2) {
            var_dump(implode(',', $elements1));
            var_dump(implode(',', $elements2));
            throw new \Exception('error sorting elements in class: ' . get_class());
        }
    }
}
