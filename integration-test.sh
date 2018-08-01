#!/usr/bin/env bash

if [ $# -eq 0 ]
  then
    source ./app/env/.env.test && export DB_NAME DB_USER DB_PASSWORD DB_PORT DB_HOST APPLICATION_ENV && php vendor/bin/codecept run api --env testing --debug --fail-fast
  else
    source ./app/env/.env.test && export DB_NAME DB_USER DB_PASSWORD DB_PORT DB_HOST APPLICATION_ENV && php vendor/bin/codecept run api $1 --env testing --debug --fail-fast
fi