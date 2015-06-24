<?php

namespace Ray\Di\Demo;

use Ray\Di\Exception\Unbound;
use Ray\Di\Exception\Untargetted;
use Ray\Di\Injector;
use Ray\Di\AbstractModule;

require __DIR__ . '/bootstrap.php';

class DeepLinkedClassBindingModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind(A::class)->to(A::class);
        $this->bind(B::class)->to(B::class);
        $this->bind(C::class)->to(C::class);
        $this->bind(D::class)->to(D::class);
        // purposefully not bound.
        // D will require E to be injected, but
        // E is not bound and an Unbound exception is thrown.
        // $this->bind(E::class)->to(E::class);
    }
}




$injector = new Injector(new DeepLinkedClassBindingModule);
// this will fail with an exception as E is not bound
try {
    $injector->getInstance(A::class);
} catch (Unbound $e) {
    echo $e;
//    Ray\Di\Demo\E
//    -required by Ray\Di\Demo\B with name "" in Ray.Di/docs/demo/src/A.php:7
//    -required by Ray\Di\Demo\C with name "" in Ray.Di/docs/demo/src/B.php:7
//    -required by Ray\Di\Demo\D with name "" in Ray.Di/docs/demo/src/C.php:7
//    -required by Ray\Di\Demo\E with name "" in Ray.Di/docs/demo/src/D.php:7

//    do {
//        echo get_class($e) . ':' . $e->getMessage() . PHP_EOL;
//    } while ($e = $e->getPrevious());

//    Ray\Di\Exception\Unbound:required by Ray\Di\Demo\B with name "" in Ray.Di/docs/demo/src/A.php:7
//    Ray\Di\Exception\Unbound:required by Ray\Di\Demo\C with name "" in Ray.Di/docs/demo/src/B.php:7
//    Ray\Di\Exception\Unbound:required by Ray\Di\Demo\D with name "" in Ray.Di/docs/demo/src/C.php:7
//    Ray\Di\Exception\Unbound:required by Ray\Di\Demo\E with name "" in Ray.Di/docs/demo/src/D.php:7
//    Ray\Di\Exception\Untargetted:Ray\Di\Demo\E
}

