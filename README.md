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
$process->isSuccessfull();
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

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

The `Ssh` class contains code taken from [laravel/envoy](https://laravel.com/docs/6.x/envoy)

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie). 
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
