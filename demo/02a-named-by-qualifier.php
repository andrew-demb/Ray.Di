<?php

declare(strict_types=1);
/**
 * This file is part of the Ray.Di package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
use Ray\Di\AbstractModule;
use Ray\Di\Di\Qualifier;
use Ray\Di\Injector;

require __DIR__ . '/bootstrap.php';

interface FinderInterface
{
}

class LegacyFinder implements FinderInterface
{
}

class ModernFinder implements FinderInterface
{
}

class FinderModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind(FinderInterface::class)->annotatedWith(Legacy::class)->to(LegacyFinder::class);
        $this->bind(MovieListerInterface::class)->to(MovieLister::class);
    }
}

interface MovieListerInterface
{
}

/**
 * @Annotation
 * @Target("METHOD")
 * @Qualifier
 */
class Legacy
{
}

class MovieLister implements MovieListerInterface
{
    public $finder;

    /**
     * @Legacy
     */
    public function __construct(FinderInterface $finder)
    {
        $this->finder = $finder;
    }
}

$injector = new Injector(new FinderModule);
$movieLister = $injector->getInstance(MovieListerInterface::class);
/* @var $movieLister MovieLister */
$works = ($movieLister->finder instanceof LegacyFinder);

echo($works ? 'It works!' : 'It DOES NOT work!') . PHP_EOL;
