# Contao Archive Palettes Bundle

This bundle offers functionality for selecting custom palettes depending on the parent archive for the backend of the Contao CMS.

## Features

- add custom palettes to your DCA files
- select them in the parent archive

## Setup

1. Install via composer: `composer require heimrichhannot/contao-archive-palettes-bundle`.
2. Adjust your project configuration

   Example for tl_news:
    ```yaml
    # config/config.yml
   huh_archive_palettes:
      tables:
         tl_news: # The table where the custom palettes should be applied
            parent: "tl_news_archive" # The archive table where custom palette should be selected
            palette_parent: "comments_legend" # A legend or a field after which the palette selector should be inserted in the parent table palette
   ```
3. Clear cache and update your database

## Configuration

### Configuration via yaml

```yaml
# Default configuration for extension with alias: "huh_archive_palettes"
huh_archive_palettes:

   # The tables that should be extended with the archive palette.
   tables:               # Example: tl_news

      # Prototype
      name:

         # The parent (archive) table.
         parent:               ~ # Required, Example: tl_news_archive

         # A field or a parent where the should be added after.
         palette_parent:       ~ # Required
```

### Configuration via PHP

1. Open the DCA file you'd like to extend. As an example we use `tl_news`. It should be located in your project bundle.
1. Create the custom field palettes as you would normally:
   ```php
   // ...
   $dca['palettes']['custom_palette1'] = '{general_legend},field1,field2;';
   $dca['palettes']['custom_palette2'] = '{general_legend},field3,field4;';
   ```
1. Paste the following code at the end of the DCA file in order to insert the palette manipulation logic:
   ```php
   System::getContainer()->get(\HeimrichHannot\ArchivePalettesBundle\Manager\ArchivePalettesManager::class)->addArchivePalettesSupportForChild(
       'tl_news', 'tl_news_archive'
   );
   ```
1. Open the *parent* DCA file, i.e. the archive DCA file. In the case of `tl_news` this would be `tl_news_archive`.
1. Paste the following code at the end of the DCA file in order to insert the palette manipulation logic:
   ```php
   System::getContainer()->get(\HeimrichHannot\ArchivePalettesBundle\Manager\ArchivePalettesManager::class)->addArchivePalettesSupportForArchive(
       'tl_news', 'tl_news_archive'
   );
   ```
1. Add the following code at the end of the file in order to add the palette selector field (the field as been added in the step before):
   ```php
   // ...
   $dca['palettes']['default'] = $dca['palettes']['default'] . ';{archive_palettes_legend},addArchivePalette;';
   ```
1. Clear the project cache and update the database in order to add the needed fields.
1. Open archive's configuration (`editheader` operation in most cases) and set the custom palette to your needs.
