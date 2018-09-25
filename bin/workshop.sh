#!/bin/bash

set -e
set -u
set -o pipefail

COMMAND=${1:-"help"}
WORKSHOP_USE_DOCKER=${WORKSHOP_USE_DOCKER:-"1"}
TAG=dev

function _use_docker() {
    [ "$WORKSHOP_USE_DOCKER" == "1" ]
}

function build() {
    docker build -t mastermind/php:$TAG .
}

function php() {
    _run php ${@:-"-v"}
}

function sh() {
    _run ${@:-"sh"}
}

function composer() {
    _run composer ${@:-""}
}

function phpunit() {
    _run ./vendor/bin/phpunit ${@:-""}
}

function behat() {
    _run ./vendor/bin/behat ${@:-"--format=progress"}
}

function tests() {
    phpunit && behat
}

function web() {
    if _use_docker; then
        docker run -it --rm \
            -e TERM=xterm-256color \
            -v $(pwd):/mastermind \
            -v $HOME/.composer/cache:/root/.composer/cache \
            -w /mastermind \
            -p 8000:8000 \
            mastermind/php:$TAG \
            php -S 0.0.0.0:8000 -t public
    else
        php -S 127.0.0.1:8000 -t public
    fi
}

function _run() {
    command=${@:1}
    if [ "" == "$command" ]; then
      command=sh
    fi
    if _use_docker; then
        docker run -it --rm \
            -v $(pwd):/mastermind \
            -v $HOME/.composer/cache:/root/.composer/cache \
            -w /mastermind \
            mastermind/php:$TAG \
            $command
    else
        exec $command
    fi
}

function help() {
    USAGE="Usage: $0 "$(compgen -A function | grep -v -e '^_' | tr "\\n" "|" | sed 's/|$//')
    echo $USAGE
    if ! _use_docker; then
        echo ""
        echo "Docker is not enabled and PHP on your host will be used. To use docker:"
        echo "  export WORKSHOP_USE_DOCKER=1"
        echo "  $0 build"
        echo "  $0 help"
        echo "  $0 php -v"
    fi
}

if ! _use_docker; then
    unset build php sh composer
fi

if [ "$(type -t $COMMAND)" != "function" ]; then
    help
    exit 1
fi

$COMMAND ${@:2}
