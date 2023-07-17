<?php

/*
 * Copyright (c) 2023 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\ArchivePalettesBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HeimrichHannotArchivePalettesBundle extends Bundle
{
    public function getPath()
    {
        return \dirname(__DIR__);
    }
}
