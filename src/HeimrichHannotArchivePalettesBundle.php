<?php

/*
 * Copyright (c) 2023 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\ArchivePalettesBundle;

use HeimrichHannot\ArchivePalettesBundle\DependencyInjection\HeimrichHannotArchivePalettesExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HeimrichHannotArchivePalettesBundle extends Bundle
{
    public const ALIAS = 'huh_archive_palettes';

    public function getPath()
    {
        return \dirname(__DIR__);
    }

    public function getContainerExtension()
    {
        return new HeimrichHannotArchivePalettesExtension();
    }
}
