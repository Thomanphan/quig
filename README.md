# QUIG
Quote Image Generator: PHP scripts to generate png images from quotes.

## Usage
- `generateAll.php` loads al availale phrases and generates the images.
- `phrase.php` changes the current `phrase.png` file to one chosen at random from all the available images (if the image for the chosen phrase has not been written ti will be written.
    - If invoked from console, the phrase will bit displayed as text.
    - If invoked from web, the prase will be displayed as an image.
- `resetCache.php` removes the currently stored phrase in cache, forcing it to change next time the script is accessed.

## Initial configuration
1. Configure fonts, size and cache time if you need to, in `config.php`.
2. Make sure the `cache` directory exists and has write access. (All the generated images go here).
3. Somehow fill loadPhrases.php with your phrases. (mysql, csv, sqlite, google spreadsheets, anything you want)

## Note
If you are not using this in the directory root, it may be necessary to add a `RewriteBase` rule in the `.htaccess` file.
