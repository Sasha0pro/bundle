<?php

namespace DTOService\Bundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class DTOService extends AbstractBundle
{
    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
                ->arrayNode('twitter')
                    ->children()
                        ->integerNode('client_id')->end()
                        ->scalarNode('client_secret')->end()
                    ->end()
                 ->end() // twitter
            ->end()
        ;
    }

    public function loadExtension(array $config, ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void
    {
        $containerConfigurator->import('../config/services.yaml');

        $containerConfigurator->parameters()
            ->set('acme_hello.phrase', $config['phrase'])
        ;

        if ($config['scream']) {
            $containerConfigurator->services()
                ->get('acme_hello.printer')
                ->class(ScreamingPrinter::class)
            ;
        }
    }

    public function getPath(): string
    {
        return dirname(__DIR__);
    }

}