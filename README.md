# GrumPHP PHP selector extension

## Description

[GrumPHP][1] does not allow to select the actual PHP version to use to execute its tasks as it directly uses the `bin` 
executable. This extension attempts to solve this by allowing you to define the actual PHP binary in a separate 
environment variable file.

## Installation

```shell
$ composer require --dev torfs-ict/grumphp-php-selector
```

Then, edit your [GrumPHP][1] configuration file and register the extension:

```yaml
# grumphp.yml
grumphp:
  extensions:
    - TorfsICT\GrumPHP\PhpSelector\PhpSelectorGrumPHPExtension
```

After that, create `.env.grumphp` in your project root containing the `GRUMPHP_PHP_EXECUTABLE` variable:

```dotenv
# .env.grumphp
GRUMPHP_PHP_EXECUTABLE=php8.2
```

We suggest adding this file to your `.gitignore` so everyone working on the project can choose to use this or not. Note 
that the `.env.grumphp` is optional and omitting it will simply make [GrumPHP][1] behave as usual.

[1]: https://packagist.org/packages/grumphp/grumphp