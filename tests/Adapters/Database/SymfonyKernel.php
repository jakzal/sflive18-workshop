<?php
declare(strict_types=1);

namespace App\Tests\Adapters\Database;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Kernel;
use App\Kernel as AppKernel;

trait SymfonyKernel
{
    /**
     * @var Kernel
     */
    protected $kernel;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @before
     */
    protected function setUpSymfonyKernel()
    {
        $this->kernel = $this->createKernel();
        $this->kernel->boot();

        $this->container = $this->kernel->getContainer();
    }

    protected function createKernel(): Kernel
    {
        $class = $this->getKernelClass();
        $options = $this->getKernelOptions();

        return new $class(
            isset($options['environment']) ? $options['environment'] : 'test',
            isset($options['debug']) ? $options['debug'] : true
        );
    }

    protected function getKernelClass(): string
    {
        return AppKernel::class;
    }

    protected function getKernelOptions(): array
    {
        return ['environment' => 'test', 'debug' => true];
    }

    /**
     * @after
     */
    protected function tearDownSymfonyKernel()
    {
        if (null !== $this->kernel) {
            $this->kernel->shutdown();
        }
    }
}
