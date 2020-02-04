# A lightweight package to execute commands over an SSH connection

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/ssh.svg?style=flat-square)](https://packagist.org/packages/spatie/ssh)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/ssh/run-tests?label=tests)](https://github.com/spatie/ssh/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/ssh.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/ssh)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/ssh.svg?style=flat-square)](https://packagist.org/packages/spatie/ssh)

You can execute an SSH command like this:

```php
(new Ssh('user', 'host'))->execute('your favorite command');
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
$process = (new Ssh('user', 'host'))->execute('your favorite command');
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
$process = (new Ssh('user', 'host'))->execute([
   'first command',
   'second command',
]);
```

### Choosing a port

You can choose a port by passing it to the constructor.


```php
$port = 123;

(new Ssh('user', 'host', $port));
```

Alternatively you can use the `port` function:

```php
(new Ssh('user', 'host'))->usePort($port);
```


### Specifying the private key to use

You can use `usePrivateKey` to specify a path to a private SSH key to use.

```php
(new Ssh('user', 'host'))->usePrivateKey('/home/user/.ssh/id_rsa');
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

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
