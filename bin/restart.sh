#!/usr/bin/env bash

./bin/stop.sh

docker-compose build --no-cache --build-arg padlock_app

./bin/start.sh