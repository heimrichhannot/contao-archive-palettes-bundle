<?php

/*
 * Copyright (c) 2023 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\ArchivePalettesBundle\DependencyInjection;

use HeimrichHannot\ArchivePalettesBundle\HeimrichHannotArchivePalettesBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class HeimrichHannotArchivePalettesExtension extends Extension
{
    public function getAlias()
    {
        return HeimrichHannotArchivePalettesBundle::ALIAS;
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration(
            $configuration,
            $configs
        );

        $container->setParameter('huh_archive_palettes', $config);
    }
}
