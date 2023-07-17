<?php

/*
 * Copyright (c) 2023 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\ArchivePalettesBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use HeimrichHannot\ArchivePalettesBundle\HeimrichHannotArchivePalettesBundle;
use Symfony\Component\Config\Loader\LoaderInterface;

class Plugin implements BundlePluginInterface, ConfigPluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(HeimrichHannotArchivePalettesBundle::class)->setLoadAfter([
                ContaoCoreBundle::class,
            ]),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader, array $managerConfig)
    {
        $loader->load('@HeimrichHannotArchivePalettesBundle/config/services.yml');
    }
}
