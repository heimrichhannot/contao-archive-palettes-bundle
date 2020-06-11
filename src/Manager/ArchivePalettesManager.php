<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\ArchivePalettesBundle\Manager;

use Contao\DataContainer;
use HeimrichHannot\UtilsBundle\Arrays\ArrayUtil;
use HeimrichHannot\UtilsBundle\Dca\DcaUtil;
use HeimrichHannot\UtilsBundle\Model\ModelUtil;

class ArchivePalettesManager
{
    /**
     * @var DcaUtil
     */
    private $dcaUtil;
    /**
     * @var ModelUtil
     */
    private $modelUtil;
    /**
     * @var ArrayUtil
     */
    private $arrayUtil;

    public function __construct(DcaUtil $dcaUtil, ModelUtil $modelUtil, ArrayUtil $arrayUtil)
    {
        $this->dcaUtil = $dcaUtil;
        $this->modelUtil = $modelUtil;
        $this->arrayUtil = $arrayUtil;
    }

    public function initPalette(?DataContainer $dc, string $table, string $parentTable)
    {
        $this->dcaUtil->loadDc($table);
        $this->dcaUtil->loadDc($parentTable);

        if (null === ($instance = $this->modelUtil->findModelInstanceByPk($table, $dc->id))) {
            return;
        }

        if (null === ($archive = $this->modelUtil->findModelInstanceByPk($parentTable, $instance->pid))) {
            return;
        }

        // override the default palette
        $GLOBALS['TL_DCA'][$table]['palettes']['default'] = $GLOBALS['TL_DCA'][$table]['palettes'][$archive->customNewsPalettes];
    }

    public function addArchivePalettesSupport(string $table, string $parentTable)
    {
        $manager = $this;

        $this->dcaUtil->loadDc($table);
        $dca = &$GLOBALS['TL_DCA'][$table];

        $this->dcaUtil->loadDc($parentTable);
        $archiveDca = &$GLOBALS['TL_DCA'][$parentTable];

        // add callback

        $dca['config']['archivePalettes'] = function (?DataContainer $dc) use ($table, $parentTable, $manager) {
            $manager->initPalette($dc, $table, $parentTable);
        };

        // add the selector fields to the archive
        $options = array_keys($dca['palettes']);
        $this->arrayUtil->removeValue('__selector__', $options);

        $fields = [
            'addArchivePalette' => [
                'label' => &$GLOBALS['TL_LANG']['MSC']['archivePalettesBundle']['addArchivePalette'],
                'exclude' => true,
                'inputType' => 'checkbox',
                'eval' => ['tl_class' => 'w50', 'submitOnChange' => true],
                'sql' => "char(1) NOT NULL default ''",
            ],
            'archivePalettes' => [
                'label' => &$GLOBALS['TL_LANG']['MSC']['archivePalettesBundle']['archivePalettes'],
                'exclude' => true,
                'filter' => true,
                'inputType' => 'select',
                'options' => $options,
                'eval' => ['tl_class' => 'w50', 'mandatory' => true, 'includeBlankOption' => true],
                'sql' => "varchar(64) NOT NULL default ''",
            ],
        ];

        $archiveDca['fields'] = array_merge(\is_array($archiveDca['fields']) ? $archiveDca['fields'] : [], $fields);

        // add the palettes
        $archiveDca['palettes']['__selector__'][] = 'addArchivePalette';

        $archiveDca['subpalettes']['addArchivePalette'] = 'archivePalettes';
    }
}
