<?php

namespace SymfonyContrib\Bundle\SessionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('session');

        $rootNode->children()
            ->arrayNode('database')
                ->canBeDisabled()
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('host')
                        ->defaultValue('%database_host%')
                        ->cannotBeEmpty()
                        ->isRequired()
                    ->end()
                    ->integerNode('port')
                        ->defaultValue('%database_port%')
                        ->isRequired()
                    ->end()
                    ->scalarNode('name')
                        ->defaultValue('%database_name%')
                        ->cannotBeEmpty()
                        ->isRequired()
                    ->end()
                    ->scalarNode('user')
                        ->defaultValue('%database_user%')
                        ->cannotBeEmpty()
                        ->isRequired()
                    ->end()
                    ->scalarNode('pass')
                        ->defaultValue('%database_password%')
                        ->cannotBeEmpty()
                        ->isRequired()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('memcached')
                ->canBeEnabled()
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('servers')
                        ->defaultValue([['host' => '127.0.0.1', 'port' => 11211, 'weight' => 0]])
                        ->cannotBeEmpty()
                        ->requiresAtLeastOneElement()
                        ->prototype('array')
                            ->children()
                                ->scalarNode('host')
                                    ->cannotBeEmpty()
                                    ->defaultValue('127.0.0.1')
                                ->end()
                                ->integerNode('port')
                                    ->defaultValue(11211)
                                ->end()
                                ->integerNode('weight')
                                    ->defaultValue(0)
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->scalarNode('persistent')
                        ->defaultValue('session')
                        ->treatFalseLike(false)
                        ->treatTrueLike('session')
                        ->treatNullLike('session')
                    ->end()
                    ->scalarNode('prefix')
                        ->defaultValue('sess')
                        ->cannotBeEmpty()
                    ->end()
                    ->integerNode('ttl')
                        ->defaultValue('3600')
                    ->end()
                    ->booleanNode('compression')
                        ->defaultTrue()
                    ->end()
                    ->enumNode('serializer')
                        ->values([
                            'php',
                            'igbinary',
                            'json',
                        ])
                        ->defaultValue('php')
                        ->cannotBeEmpty()
                    ->end()
                    ->enumNode('hash')
                        ->values([
                            'default',
                            'md5',
                            'crc',
                            'fnv1_64',
                            'fnv1a_64',
                            'fnv1_32',
                            'fnv1a_32',
                            'hsieh',
                            'murmur',
                        ])
                        ->defaultValue('default')
                        ->cannotBeEmpty()
                    ->end()
                    ->enumNode('distribution')
                        ->values([
                            'modula',
                            'consistent',
                        ])
                        ->defaultValue('consistent')
                        ->cannotBeEmpty()
                    ->end()
                    ->booleanNode('libketama')
                        ->defaultTrue()
                    ->end()
                    ->booleanNode('buffer_writes')
                        ->defaultFalse()
                    ->end()
                    ->booleanNode('binary_protocol')
                        ->defaultFalse()
                    ->end()
                    ->booleanNode('no_block')
                        ->defaultFalse()
                    ->end()
                    ->booleanNode('tcp_nodelay')
                        ->defaultFalse()
                    ->end()
                    ->integerNode('connect_timeout')
                        ->defaultValue(1000)
                    ->end()
                    ->integerNode('retry_timeout')
                        ->defaultValue(0)
                    ->end()
                    ->integerNode('send_timeout')
                        ->defaultValue(0)
                    ->end()
                    ->integerNode('receive_timeout')
                        ->defaultValue(0)
                    ->end()
                    ->integerNode('poll_timeout')
                        ->defaultValue(1000)
                    ->end()
                    ->integerNode('server_failure_limit')
                        ->defaultValue(0)
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
