<?php
/**
 * Go! AOP framework
 *
 * @copyright Copyright 2015, Lisachenko Alexander <lisachenko.it@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Go\Symfony\GoAopBundle\Tests\DependencyInjection;

use Go\Symfony\GoAopBundle\DependencyInjection\GoAopExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

/**
 * Class GoAopExtensionTest
 */
class GoAopExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @test
     */
    public function itLoadsServices()
    {
        $this->load();

        $services = [
            'goaop.aspect.kernel',
            'goaop.aspect.container',
            'goaop.cache.path.manager',
            'goaop.cache.warmer'
        ];

        foreach ($services as $id) {
            $this->assertContainerBuilderHasService($id);
        }
    }

    /**
     * @test
     */
    public function itNormalizesAndSetsAspectKernelOptions()
    {
        $this->load();

        $this->assertEquals([
            'features' => 0,
            'appDir' => '%kernel.root_dir%/../src',
            'cacheDir' => '%kernel.cache_dir%/aspect',
            'debug' => '%kernel.debug%',
            'includePaths' => [],
            'excludePaths' => []
        ], $this->container->getParameter('goaop.options'));
    }

    /**
     * @test
     */
    public function itDisablesCacheWarmer()
    {
        $this->load([
            'cache_warmer' => false
        ]);

        $definition = $this->container->getDefinition('goaop.cache.warmer');

        $this->assertFalse($definition->hasTag('kernel.cache_warmer'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return [
            new GoAopExtension()
        ];
    }
}
