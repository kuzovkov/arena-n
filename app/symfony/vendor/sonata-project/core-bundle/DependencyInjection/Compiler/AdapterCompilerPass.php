<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Sonata\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class StatusRendererCompilerPass
 *
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class AdapterCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {

        $definition = $container->getDefinition('sonata.core.model.adapter.chain');

        if ($container->has('doctrine')) {
            $definition->addMethodCall('addAdapter', array(new Reference('sonata.core.model.adapter.doctrine_orm')));
        } else {
            $container->removeDefinition('sonata.core.model.adapter.doctrine_orm');
        }

        if ($container->has('doctrine_phpcr')) {
            $definition->addMethodCall('addAdapter', array(new Reference('sonata.core.model.adapter.doctrine_phpcr')));
        } else {
            $container->removeDefinition('sonata.core.model.adapter.doctrine_phpcr');
        }
    }
}