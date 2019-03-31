# Format'ciné

__Format'ciné__ is a French association promoting cinema in the __Indre et Loire__ region, here's their website.

![Screenshot](screenshot.png)

## Author

The website has been designed by [Moka Création](http://www.mokacreation.com/) and developed by [19h47](http://www.19h47.fr/).

## PHPCS

### Install the WordPress rules

Add __PHP_CodeSniffer__ to the `composer.json` file

```json
{
    "require": {
        "squizlabs/php_codesniffer": "*"
    }
}
```

Then update dependencies

```bash
composer update
```

Create the project

```bash
Make create-project
```

### Add the Rules to PHP CodeSniffer

```bash
Make config-set
```
