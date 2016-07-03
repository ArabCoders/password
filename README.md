# Passwords Handler.

## Install

Via Composer

```bash
$ composer require arabcoders/password
```

## Usage Example.

```php
<?php
$pass = new arabcoders\password\Password();
// to hash password
$pass->setPassword('password')->hash();
// to get hashed password.
$hash = $pass->getHash();
// to verify password.
echo ( $pass->verify() ) ? 'welcome' : 'shoo';
?>
```
