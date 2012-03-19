<?php
/**
 * WindowsAzure TaskDemoBundle
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace WindowsAzure\TaskDemoBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * This will end up in the DoctrineBundle some day, but for now we have to
 * register the sharding manager here in an extra compiler pass.
 */
class ShardingPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ( ! $container->hasDefinition('doctrine.dbal.default_connection')) {
            return;
        }

        $def = $container->findDefinition('doctrine.dbal.default_connection');
        $args = $def->getArguments();

        if ( ! isset($args[0]['driver']) || strpos($args[0]['driver'], 'sqlsrv') === false) {
            return;
        }

        $args[0]['sharding'] = array(
            'federationName' => 'User_Federation',
            'distributionKey' => 'user_id',
            'filteringEnabled' => false
        );
        $def->setArguments($args);

        $def = new Definition('Doctrine\Shards\DBAL\SQLAzure\SQLAureShardManager');
        $def->addArgument(new Reference('doctrine.dbal.default_connection'));

        $container->setDefinition('windows_azure_task_demo.shard_manager', $def);
    }
}

