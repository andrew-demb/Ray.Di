<?php

declare(strict_types=1);

namespace Ray\Compiler;

use Ray\Di\InjectionPointInterface;
use Ray\Di\ProviderInterface;

class FakeLoggerPointProvider implements ProviderInterface
{
    public $qualifiers;

    /** @var InjectionPointInterface */
    private $ip;

    public function __construct(InjectionPointInterface $ip)
    {
        $this->ip = $ip;
    }

    public function get()
    {
        $class = $this->ip->getClass()->getName();
        $this->qualifiers = $this->ip->getQualifiers();
        $fakeLoggerInject = $this->qualifiers[0];

        /** @var FakeLoggerInject $fakeLoggerInject */
        return new FakeLogger($class, $fakeLoggerInject->type);
    }
}
