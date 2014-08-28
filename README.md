# Symfony2 Session Bundle

Provides simple setup of database and memcached based sessions.

##Features:

* Pre-configured database and memcached based session handlers.
* Parameters for changing settings.

## Installation

### 1. Add the bundle to your composer.json

```json
"require": {
    "symfonycontrib/session-bundle": "@stable"
}
```

### 2. Install the bundle using composer

```bash
$ composer update symfonycontrib/session-bundle
```

### 3. Add this bundle to your application's kernel

```php
    new SymfonyContrib\Bundle\SessionBundle\SessionBundle(),
```

### 4. Update your schema

```bash
$ app/console d:s:u --force
```

### 5. Set session handler in config.yml

```yml
# app/config/config.yml
framework:
    session:
        handler_id: session.handler.database
```

## Configuration

Session handler service IDs to choose from:

* session.handler.database
* session.handler.memcached

To use the above session handlers, they must be first enabled. By default,
the `database` handler is `enabled` and the `memcached` handler is `disabled`.

### Complete configuration reference

```yml
session:
    database:
        enabled: true
        host: %database_host%
        port: %database_port%
        name: %database_name%
        user: %database_user%
        pass: %database_pass%
    memcached:
        enabled: false
        servers:
            - host: 127.0.0.1
              port: 11211
              weight: 0
        persistent: session
        prefix: sess
        ttl: 3600
        compression: true
        serializer: php
        hash: default
        distribution: consistent
        libketama: true
        buffer_writes: false
        binary_protocol: false
        no_block: false
        tcp_nodelay: false
        connect_timeout: 1000
        send_timeout: 0
        receive_timeout: 0
        poll_timeout: 1000
```

### How to use the database for session storage

By default, if you have followed the install steps above and are using the
default Symfony Standard Edition database parameters, your application will
using database sessions.

If you need to use custom data base parameters, configure them like below:

```yml
# app/config/config.yml
# Defaults shown
session:
    database:
        host: %database_host%
        port: %database_port%
        name: %database_name%
        user: %database_user%
        pass: %database_password%
```

### How to use Memcached for session storage

** Note: The PHP memcached, not memcache, extension needs to be installed. **

If you want to use default settings as listed in the reference above,
all you need to do is enable memcached handler:

```yml
# app/config/config.yml
framework:
    session:
        handler_id: session.handler.memcached

session:
    memcached: ~
```

You can configure many of the memcached settings.
Use the reference above and
http://www.php.net/manual/en/memcached.constants.php

### You should also configure the other Symfony session settings

See http://symfony.com/doc/current/reference/configuration/framework.html#session

Example:

```yml
# app/config/config.yml
framework:
    session:
        name: session_id
        cookie_domain: %cookie_domain%
        cookie_path: /
        cookie_secure: %cookie_secure%
        cookie_httponly: true
        # 1 month
        cookie_lifetime: 2592000
        gc_probability: 1
        gc_divisor: 100
        # 1 month
        gc_maxlifetime: 2592000
        # 1 hour
        metadata_update_threshold: 1440
        handler_id:  %session.handler_id%
```
