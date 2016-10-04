#!/usr/bin/env bash
docker pull phpunit/phpunit
docker run -v $(pwd):/app --rm phpunit/phpunit --configuration=Test/phpunit.xml --bootstrap=Test/bootstrap.php $@
