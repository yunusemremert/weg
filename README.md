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

Project Description
------------
<p>Developing a web application that will capture to-do business information from 2 separate providers, share it with the development team on a weekly basis, and output it to the screen.</p>

<p>In each provider service, the name of the task gives the duration (in hours), the degree of difficulty. There are 5 developers in total and the size of work each developer can do in 1 hour is as follows:</p>

<table>
<thead>
<tr>
<th>Developer</th>
<th>Duration</th>
<th>Difficulty</th>
</tr>
</thead>
<tbody>
<tr>
<td>Dev-1</td>
<td align="center">1</td>
<td align="center">1x</td>
</tr>
<tr>
<td>Dev-2</td>
<td align="center">1</td>
<td align="center">2x</td>
</tr>
<tr>
<td>Dev-3</td>
<td align="center">1</td>
<td align="center">3x</td>
</tr>
<tr>
<td>Dev-4</td>
<td align="center">1</td>
<td align="center">4x</td>
</tr>
<tr>
<td>Dev-5</td>
<td align="center">1</td>
<td align="center">5x</td>
</tr>
</tbody>
</table>

<p>Assuming that the developers work 45 hours a week, an interface should be prepared that will print the weekly developer-based work schedule and the minimum total number of weeks the work will be completed, with an algorithm that ensures that the work is completed as soon as possible.</p>

---

### To get started, follow these steps:

#### Please open the terminal of the project and run it (Step: 1, 2, 3, 4, 5, 6, 8)

1. Install the required packages using composer by running the following command:

```shell
composer install
```

2. Please create the .env file with the following command line.
```shell
copy .env .env.local
```

3. Create your database by running the following command:
```shell
php bin/console doctrine:database:create
```

4. Migrate your database by running the following command:
```shell
php bin/console doctrine:migrations:migrate
```

5. Add the developers to the database by running the following command:
```shell
php bin/console doctrine:fixtures:load
```

6. Extract the job information from the api addresses and add it to the database by running the following command:
````shell
php bin/console app:get-todo-api
````

7. Please fill in the .env file with the required configurations below.
```
APP_TIMEZONE=Europe/Istanbul

DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8.0.32&charset=utf8mb4"

PROVIDER_ONE_URL=http://www.mocky.io/v2/5d47f24c330000623fa3ebfa
PROVIDER_TWO_URL=http://www.mocky.io/v2/5d47f235330000623fa3ebf7
```

8. Please start server
```shell
symfony server:start
```

[1]: https://symfony.com
[2]: https://symfony.com/projects
[3]: https://symfony.com/doc/current/reference/requirements.html
[4]: https://symfony.com/doc/current/setup.html
[5]: https://semver.org
[6]: https://symfony.com/doc/current/contributing/community/releases.html