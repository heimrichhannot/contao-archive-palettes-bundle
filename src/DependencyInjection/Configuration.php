<?php

/*
 * Copyright (c) 2023 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\ArchivePalettesBundle\DependencyInjection;

use HeimrichHannot\ArchivePalettesBundle\HeimrichHannotArchivePalettesBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(HeimrichHannotArchivePalettesBundle::ALIAS);

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('tables')
                    ->useAttributeAsKey('name')
                    ->info('The tables that should be extended with the archive palette.')
                    ->example('tl_news')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('parent')
                                ->isRequired()
                                ->info('The parent (archive) table.')
                                ->example('tl_news_archive')
                            ->end()
                            ->scalarNode('palette_parent')
                                ->isRequired()
                                ->info('A field or a parent where the should be added after.')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
