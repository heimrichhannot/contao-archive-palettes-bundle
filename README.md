# Contao Archive Palettes Bundle

This bundle offers functionality for selecting custom palettes depending on the parent archive for the backend of the Contao CMS

## Features

- add custom palettes to your DCA files
- select them in the parent archive

## Installation

1. Install via composer: `composer require heimrichhannot/contao-archive-palettes-bundle`.

## Configuration

1. Open the DCA file you'd like to extend. As an example we use `tl_news`. It should be located in your project bundle.
1. Create the custom field palettes as you would normally:
   ```php
   // ...
   $dca['palettes']['custom_palette1'] = '{general_legend},field1,field2;';
   $dca['palettes']['custom_palette2'] = '{general_legend},field3,field4;';
   ```
1. Paste the following code at the end of your DCA file in order to get the logic:
   ```php
   System::getContainer()->get(\HeimrichHannot\ArchivePalettesBundle\Manager\ArchivePalettesManager::class)->addArchivePalettesSupport(
       'tl_news', 'tl_news_archive'
   );
   ```
1. Open the *parent* DCA file, i.e. the archive DCA file. In the case of `tl_news` this would be `this-news_archive`.
1. Add the following code at the end of the file in order to add the palette selector field:
   ```php
   // ...
   $dca['palettes']['default'] = str_replace('title,', 'title,addArchivePalette,', $dca['palettes']['default']);
   ```
1. Clear the project cache and update the database in order to add the needed fields.
1. Open archive's configuration (`editheader` operation in most cases) and set the custom palette to your needs.
