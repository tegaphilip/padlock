#!/usr/bin/env bash

./bin/stop.sh

docker-compose build --no-cache --build-arg PHP_ENV=development hocaboo_auth

./bin/start.sh