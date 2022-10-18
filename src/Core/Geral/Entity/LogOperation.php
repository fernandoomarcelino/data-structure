<?php

namespace Core\Geral\Entity;

class LogOperation
{

    protected ?LogOperation $previous = null;
    protected ?LogOperation $left = null;
    protected ?LogOperation $right = null;
    protected array $children = [];

    public function __construct(public array $elements)
    {
    }

    public function getLeft(): ?LogOperation
    {
        return $this->left;
    }

    public function setLeft(LogOperation $left): self
    {
        if (!empty($left->elements)) {
            $left->setPrevious($this);
            $this->left = $left;
            $this->addChildren($left);
        }

        return $this;
    }

    public function getRight(): ?LogOperation
    {
        return $this->right;
    }

    public function setRight(LogOperation $right): self
    {
        if (!empty($right->elements)) {
            $right->setPrevious($this);
            $this->right = $right;
            $this->addChildren($right);
        }

        return $this;
    }

    public function addChildren(LogOperation $children): void
    {
        $this->children[] = $children;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function getPrevious(): ?LogOperation
    {
        return $this->previous;
    }

    public function setPrevious(?LogOperation $previous): void
    {
        $this->previous = $previous;
    }

    public function toJson(): array
    {
        $results[] = $this->addRow();
//
//        foreach ($this->getChildren() as $children) {
//            if ($children->getChildren()) {
//                foreach ($children->getChildren() as $children2) {
//                    $results = array_merge($results, $children2->toJson());
//                }
//            } else {
//                $results[] = $this->addRow();
//            }
//        }

        if ($this->getLeft()) {
            $results = array_merge($results, $this->getLeft()->toJson());
        } else {
            $results[] = $this->addRow();
        }

        if ($this->getRight()) {
            $results = array_merge($results, $this->getRight()->toJson());
        } else {
            $results[] = $this->addRow();
        }
        return (array_values($results));
    }

    private function addRow(): array
    {
        $current = (object)[
            'v' => (string)spl_object_id($this),
            'f' => implode(',', $this->elements)
        ];

        $previous = '';
        if ($this->getPrevious()) {
            $previous = (string)spl_object_id($this->getPrevious());
        }

        return [$current, $previous, ''];
    }
}
