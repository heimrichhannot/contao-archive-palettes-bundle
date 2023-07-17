<?php

/*
 * Copyright (c) 2023 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\ArchivePalettesBundle\EventListener\Contao;

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\CoreBundle\ServiceAnnotation\Hook;
use HeimrichHannot\ArchivePalettesBundle\Manager\ArchivePalettesManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @Hook("loadDataContainer")
 */
class LoadDataContainerListener
{
    private ParameterBagInterface $parameterBag;
    private ArchivePalettesManager $archivePalettesManager;

    private array $tables;
    private array $parentTables;

    public function __construct(ParameterBagInterface $parameterBag, ArchivePalettesManager $archivePalettesManager)
    {
        $this->parameterBag = $parameterBag;
        $this->archivePalettesManager = $archivePalettesManager;
    }

    public function __invoke(string $table): void
    {
        if (!isset($this->tables)) {
            if (!$this->parameterBag->has('huh_archive_palettes')
                || !\is_array($tables = $this->parameterBag->get('huh_archive_palettes')['tables'])) {
                $this->tables = [];
            } else {
                $this->tables = $tables;
                $this->parentTables = array_combine(array_column($tables, 'parent'), array_keys($tables));
            }
        }

        if (isset($this->tables[$table])) {
            $this->archivePalettesManager->addArchivePalettesSupportForChild($table, $this->tables[$table]['parent']);
        } elseif (isset($this->parentTables[$table])) {
            $this->archivePalettesManager->addArchivePalettesSupportForArchive($this->parentTables[$table], $table);
            $position = str_ends_with($this->tables[$this->parentTables[$table]]['palette_parent'], '_legend')
                ? PaletteManipulator::POSITION_AFTER : PaletteManipulator::POSITION_APPEND;
            PaletteManipulator::create()
                ->addLegend('archive_palettes_legend', $this->tables[$this->parentTables[$table]]['palette_parent'], $position)
                ->addField('addArchivePalette', 'archive_palettes_legend', PaletteManipulator::POSITION_APPEND)
                ->applyToPalette('default', $table);
        }
    }
}
