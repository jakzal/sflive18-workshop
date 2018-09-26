<?php
declare(strict_types=1);

namespace App\Tests\Adapters\Database;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Tools\SchemaTool;
use RuntimeException;

trait Doctrine
{
    /**
     * @var ManagerRegistry
     */
    protected $doctrine;

    /**
     * @var ObjectManager
     */
    protected $manager;

    /**
     * @before
     */
    protected function createSchema()
    {
        if ($metadata = $this->getMetadata()) {
            $schemaTool = new SchemaTool($this->manager);
            $schemaTool->dropSchema($metadata);
            $schemaTool->createSchema($metadata);
        }
    }
    /**
     * @before
     */
    protected function setUpDoctrine()
    {
        $this->doctrine = $this->createDoctrineRegistry();
        $this->manager = $this->doctrine->getManager();
    }

    /**
     * Returns all metadata by default.
     *
     * Override to only build selected metadata.
     * Return an empty array to prevent building the schema.
     *
     * @return array
     */
    protected function getMetadata(): array
    {
        return $this->manager->getMetadataFactory()->getAllMetadata();
    }

    /**
     * Override to build doctrine registry yourself.
     *
     * By default a Symfony container is used to create it. It requires the SymfonyKernel trait.
     *
     * @return ManagerRegistry
     */
    protected function createDoctrineRegistry(): ManagerRegistry
    {
        if (isset($this->kernel)) {
            return $this->kernel->getContainer()->get('doctrine');
        }

        throw new RuntimeException(sprintf('Override %s to create a ManagerRegistry or use the SymfonyKernel trait.', __METHOD__));
    }
}
