<p align="center"><a href="https://symfony.com" target="_blank">
    <img src="https://symfony.com/logos/symfony_black_02.svg">
</a></p>

[Symfony][1] is a **PHP framework** for web and console applications and a set
of reusable **PHP components**. Symfony is used by thousands of web
applications and most of the [popular PHP projects][2].

Installation
------------

* [Install Symfony][4] with Composer (see [requirements details][3]).
* Symfony follows the [semantic versioning][5] strictly, publishes "Long Term
  Support" (LTS) versions and has a [release process][6] that is predictable and
  business-friendly.

---

### To get started, follow these steps:

1. 
```shell
copy .env .env.local
```

2. 
```shell
php bin/console doctrine:database:create
```

3. 
```shell
php bin/console make:migration
```

4. 
```shell
php bin/console doctrine:migrations:migrate
```

5. 
```shell
php bin/console doctrine:fixtures:load
```

6. 
````shell
php bin/console app:get-todo-api
````

7. 
```
APP_TIMEZONE=Europe/Istanbul

DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8.0.32&charset=utf8mb4"

PROVIDER_ONE_URL=http://www.mocky.io/v2/5d47f24c330000623fa3ebfa
PROVIDER_TWO_URL=http://www.mocky.io/v2/5d47f235330000623fa3ebf7
```

[1]: https://symfony.com
[2]: https://symfony.com/projects
[3]: https://symfony.com/doc/current/reference/requirements.html
[4]: https://symfony.com/doc/current/setup.html
[5]: https://semver.org
[6]: https://symfony.com/doc/current/contributing/community/releases.html