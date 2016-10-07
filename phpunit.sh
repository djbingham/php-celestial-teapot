#!/usr/bin/env bash

pushd "$( dirname "${BASH_SOURCE[0]}" )/Test" > /dev/null

docker-compose up unit-test
docker-compose up -d database
sleep 11 # Wait for database to be ready. Yes, there are almost certainly more reliable methods for this.
docker-compose up integration-test
docker-compose stop
docker-compose rm -vf

popd
