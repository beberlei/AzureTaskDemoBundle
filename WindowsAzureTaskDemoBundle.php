<?php

namespace WindowsAzure\TaskDemoBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use WindowsAzure\TaskDemoBundle\DependencyInjection\CompilerPass\ShardingPass;

class WindowsAzureTaskDemoBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ShardingPass());
    }
}
