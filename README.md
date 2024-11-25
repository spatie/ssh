# A lightweight package to execute commands over an SSH connection

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/ssh.svg?style=flat-square)](https://packagist.org/packages/spatie/ssh)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/ssh/run-tests?label=tests)](https://github.com/spatie/ssh/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/ssh.svg?style=flat-square)](https://packagist.org/packages/spatie/ssh)

You can execute an SSH command like this:

```php
Ssh::create('user', 'host')->execute('your favorite command');
```

It will return an instance of [Symfony's `Process`](https://symfony.com/doc/current/components/process.html).

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/ssh.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/ssh)

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
$process = Ssh::create('user', 'example.com')->execute('your favorite command');
```

It will return an instance of [Symfony's `Process`](https://symfony.com/doc/current/components/process.html).

If you don't want to wait until the execute commands complete, you can call `executeAsync`

```php
$process = Ssh::create('user', 'example.com')->executeAsync('your favorite command');
```

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
$process = Ssh::create('user', 'example.com')->execute([
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

### Using a password

You can use the constructor to specify a password to use.

```php
Ssh::create('user', 'host', port, 'password');
```

Alternatively you can use the `usePassword` function:

```php
Ssh::create('user', 'host')->usePassword('password');
```

### Setting a timeout

You can set a timeout for the command.


```php
Ssh::create('user', 'host')->setTimeout(100);
```

### Specifying a jump host

If using a jump/proxy/bastion host, the `useJumpHost` function allows you to set the jump hosts details:

```php
Ssh::create('user', 'host')->useJumpHost("$jumpuser@$jumphost:$jumpport");
```

### Using SSH multiplexing

If making many connections to the same host, SSH multiplexing enables re-using one TCP connection. Call `useMultiplexing` function to set control master options:

```php
Ssh::create('user', 'host')->useMultiplexing($controlPath, $controlPersist);

// Ssh::create('user', 'host')->useMultiplexing('/home/.ssh/control_masters/%C', '15m');

```


### Specifying the private key to use

You can use `usePrivateKey` to specify a path to a private SSH key to use.

```php
Ssh::create('user', 'host')->usePrivateKey('/home/user/.ssh/id_rsa');
```

### Disable Strict host key checking

By default, strict host key checking is enabled. You can disable strict host key checking using `disableStrictHostKeyChecking`.

```php
Ssh::create('user', 'host')->disableStrictHostKeyChecking();
```
### Enable quiet mode

By default, the quiet mode is disabled. You can enable quiet mode using `enableQuietMode`.

```php
Ssh::create('user', 'host')->enableQuietMode();
```

### Disable Password Authentication

By default, the password authentication is enabled. You can disable password authentication using `disablePasswordAuthentication`.

```php
Ssh::create('user', 'host')->disablePasswordAuthentication();
```

### Uploading & downloading files and directories

You can upload files & directories to a host using:

```php
Ssh::create('user', 'host')->upload('path/to/local/file', 'path/to/host/file');
```

Or download them:

```php
Ssh::create('user', 'host')->download('path/to/host/file', 'path/to/local/file');
```

Under the hood the process will use `scp`.

### Modifying the Symfony process

Behind the scenes all commands will be performed using [Symfonys `Process`](https://symfony.com/doc/current/components/process.html).

You can configure to the `Process` by using the `configureProcess` method. Here's an example where we disable the timeout.

```php
Ssh::create('user', 'host')->configureProcess(fn (Process $process) => $process->setTimeout(null));
```

### Immediately responding to output

You can get notified whenever your command produces output by passing a closure to `onOutput`. 

```php
Ssh::create('user', 'host')->onOutput(function($type, $line) {echo $line;})->execute('whoami');
```

Whenever there is output that closure will get called with two parameters:
- `type`: this can be `Symfony\Component\Process\Process::OUT` for regular output and `Symfony\Component\Process\Process::ERR` for error output
- `line`: the output itself

### Windows Target 

If your target is a Windows machine, you can use the `removeBash` method to remove the bash command from the command line.

```php
Ssh::create('user', 'host')->removeBash();
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security

If you've found a bug regarding security please mail [security@spatie.be](mailto:security@spatie.be) instead of using the issue tracker.

## Alternatives

  If you need some more features, take a look at [DivineOmega/php-ssh-connection](https://github.com/DivineOmega/php-ssh-connection).

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

The `Ssh` class contains code taken from [laravel/envoy](https://laravel.com/docs/6.x/envoy)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
