<?php
/**
 * Go! AOP framework
 *
 * @copyright Copyright 2015, Lisachenko Alexander <lisachenko.it@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Go\Symfony\GoAopBundle\Tests;

use Go\Symfony\GoAopBundle\DependencyInjection\Compiler\AspectCollectorPass;
use Go\Symfony\GoAopBundle\GoAopBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class GoAopBundleTest extends TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function itThrowsExceptionWhenBundleIsNotRegisteredFirst()
    {
        $container = $this->getMockBuilder(ContainerBuilder::class)->getMock();

        $container
            ->method('getParameter')
            ->with('kernel.bundles')
            ->willReturn(['ArbitraryBundleName' => 'A bundle']);

        $bundle = new GoAopBundle();
        
        $bundle->getName(); // invoke resolution of bundle name

        $bundle->build($container);
    }

    /**
     * @test
     */
    public function itRegistersAspectCollectorPassPass()
    {
        $container = $this->getMockBuilder(ContainerBuilder::class)->getMock();

        $container
            ->method('getParameter')
            ->with('kernel.bundles')
            ->willReturn(['GoAopBundle' => 'A bundle']);

        $container
            ->expects($spy = $this->once())
            ->method('addCompilerPass');

        $bundle = new GoAopBundle();

        $bundle->getName(); // invoke resolution of bundle name

        $bundle->build($container);

        $invocation = $spy->getInvocations()[0];

        $this->assertInstanceOf(AspectCollectorPass::class, $invocation->parameters[0]);
    }
}
