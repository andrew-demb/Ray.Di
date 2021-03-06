<?php

declare(strict_types=1);

namespace Ray\Compiler;

class FakeLogger implements FakeLoggerInterface
{
    public $name;
    public $type;

    public function __construct($name, $type)
    {
        $this->name = $name;
        $this->type = $type;
    }
}
