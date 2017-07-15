<?php
/**
 * Go! AOP framework
 *
 * @copyright Copyright 2015, Lisachenko Alexander <lisachenko.it@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Go\Symfony\GoAopBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class DoctrineSupportPass
 *
 * Registers \Go\Bridge\Doctrine\MetadataLoadInterceptor in order to support weaving of Doctrine entities.
 */
class DoctrineSupportPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (
            !$container->hasDefinition('goaop.bridge.doctrine.metadata_load_interceptor')
            ||
            !$container->hasDefinition('doctrine.orm.entity_manager')
            ||
            !$container->hasParameter('goaop.bridge.doctrine_support')
            ||
            !$container->getParameter('goaop.bridge.doctrine_support')
        ) {
            return;
        }

        $container
            ->getDefinition('goaop.bridge.doctrine.metadata_load_interceptor')
            ->addTag('doctrine.event_subscriber');
    }
}
