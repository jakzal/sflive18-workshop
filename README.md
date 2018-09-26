# Lightning Fast Tests

## Requirements

* PHP ^7.1.3
* [composer](https://getcomposer.org/download/)
* git
* (Optional) IDE

During the workshop we'll be mostly writing tests and then making them pass, so there's no need for a dedicated web server.
Git will be useful to save your progress.
A [good IDE](https://www.jetbrains.com/phpstorm/download/) will help you make less typos and focus on the workshop.

It's perfectly fine to use your locally installed version of PHP as long as it's `>=7.1.3`.
However, there's also a docker image provided in case you run into any issues while setting up PHP directly on your computer.

### Local PHP

If you chose to use your local PHP installation, simply run `composer` commands directly in your favourite shell:

```
composer create-project symfony/skeleton mastermind
```

You're good to go as soon as composer finishes with no issues.

### Docker

If you chose to use the provided docker image, familiarize yourself with the `bin/workshop.sh` script.
It aims to automate the most common commands on Linux and MacOS.

First, build the image:

```
./bin/workshop.sh build
./bin/workshop.sh php -v
```

The second command should display a PHP version.

Now you should be able to use `composer` and `php` via the `workshop.sh` script:

```
./bin/workshop.sh composer create-project symfony/skeleton mastermind
```

You're good to go as soon as composer finishes with no issues.

## Exercises

* [Exercise 1](exercises/1.md)
* [Exercise 2](exercises/2.md)
* [Exercise 3](exercises/3.md)
* [Exercise 4](exercises/4.md)
* [Exercise 5](exercises/5.md)
* [Exercise 6](exercises/6.md)
