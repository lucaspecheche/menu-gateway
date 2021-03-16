## Docker

All content related to how the Docker image was build can be found at:

- .docker/
- Dockerfile
- docker-composer.yml
- .dockerignore



## Vessel
Vessel was written to expose short versions of commands that are used too often
when debugging, developing code, and executing CI actions such as running
linters, fix-linters, and tests.

For example, without vessel the process of executing a Laravel command inside
the container to create a model would be  something like
`docker-compose exec -T app sh -c "cd /var/www/html && php artisan make:model User"`
with vessel the same result can be achieved by execution `./vessel artisan make:model User`.

Another good example of vessel usage would be the up command. With `./vessel up`
the docker-compose.yml file will be built but also the **xdebug.ini** file will
be created with the right configs and your current IP address to make the usage
of Xdebug possible. If you choose to start the container by running
`docker-compose up` bear in mind that Xdebug will not work.

### Available vessel commands

| Command                        | Description                                          |
| ------------------------------ |------------------------------------------------------|
| ./vessel up                    | Initialize docker-compose stack                      |
| ./vessel down                  | Stop docker-compose stack                            |
| ./vessel bash                  | Access bash of the app container                     |
| ./vessel clean-all             | Prune all possible containers, volumes, and networks |
| ./vessel artisan <ANY_COMMAND> | Run any Laravel artisan command                       |
| ./vessel tinker                | Open a REPL for the Laravel framework                |
| ./vessel composer              | Run any composer command                             |
| ./vessel pest                  | Run test swite using Pest framework                  |
| ./vessel tests                 | Run test swite with code coverage                    |
| ./vessel linters               | Run linters                                          |
| ./vessel fix-linters           | Run linter fixer                                     |
| ./vessel update-dependencies   | Update composer dependencies                         |

___

## Linters

The project has **PHP_CodeSniffer**, **PHP Mess Detector** configured as linters, the files
containing the rules used by them are phpmd.xml and phpcs.xml. As for fixers we have
**PHP CS Fixer** configured, and its rules can be found at .php_cs.



## Static Analysis

The project has **PHPCPD**, **PSALM**, and **Larastan** configured as linters. Larastan has also
a file phpstan.neon containing the rules used, while the other two don't have any configuration file.



## Text editors

This project was mainly coded with VIM, but there is also a **.vscode** and **.idea** directories
that holds configurations of VSCode|PHPStorm + Docker + Xdebug, and the configurations of linters.
In order to make everything work in VSCode or PHPStorm you may need to install the following plugins
**PHP Debug (VSCode only)**, **PHP Mess Detector**, **phpcs**, **php cs fixer**.

This has been tested locally and there is no guarantee that it will work on other
peoples machine. In any case this may be a head start if you wanna have this aspect
of the project working in your machine.
