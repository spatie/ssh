# A lightweight package to execute commands over an SSH connection

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/ssh.svg?style=flat-square)](https://packagist.org/packages/spatie/ssh)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/ssh/run-tests?label=tests)](https://github.com/spatie/ssh/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/ssh.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/ssh)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/ssh.svg?style=flat-square)](https://packagist.org/packages/spatie/ssh)

You can execute an SSH command like this:

```php
Ssh::create('user', 'host')->execute('your favorite command');
```

It will return an instance of [Symfony's `Process`](https://symfony.com/doc/current/components/process.html).

## Support us

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us). 

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/ssh
```

## Usage

You can execute an SSH command like this:

```php
$process = Ssh::create('user', 'host')->execute('your favorite command');
```

It will return an instance of [Symfony's `Process`](https://symfony.com/doc/current/components/process.html).

### Getting the result of a command

To check if your command ran ok

```php
$process->isSuccessful();
```


This is how you can get the output

```php
$process->getOutput();
```


### Running multiple commands

To run multiple commands pass an array to the execute method.

```php
$process = Ssh::create('user', 'host')->execute([
   'first command',
   'second command',
]);
```

### Choosing a port

You can choose a port by passing it to the constructor.


```php
$port = 123;

Ssh::create('user', 'host', $port);
```

Alternatively you can use the `usePort` function:

```php
Ssh::create('user', 'host')->usePort($port);
```


### Specifying the private key to use

You can use `usePrivateKey` to specify a path to a private SSH key to use.

```php
Ssh::create('user', 'host')->usePrivateKey('/home/user/.ssh/id_rsa');
```

### Disable Strict host key checking

By default, strict host key checking is enabled. You can disable strict host key checking using `disableStrictHostKeyChecking`.

```php
Ssh::create('user', 'host')->enableStrictHostKeyChecking();
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Alternatives

  If you need some more features, take a look at [DivineOmega/php-ssh-connection](https://github.com/DivineOmega/php-ssh-connection).

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

The `Ssh` class contains code taken from [laravel/envoy](https://laravel.com/docs/6.x/envoy)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
