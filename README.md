# Padlock, Phalcon Authentication Server

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

Padlock is a docker-based phalcon authentication server built on top of the [PHP OAuth 2.0 Server](https://github.com/thephpleague/oauth2-server) 

Setting Up
------------
* Add the entries `padlock.local` and `padlock-test.local` and map to `127.0.0.1` in your `/etc/hosts` file

* Ensure you have docker installed

* Make a copy of `.env.sample` to `.env` in the `app/env/` directory and replace the values.

* You can generate the `ENCRYPTION_KEY` environment variable by running 
`php -r "echo base64_encode(random_bytes(40)) . PHP_EOL;"` on the command line

* cd into the `keys` directory and generate your public and private keys like so: `openssl genrsa -out private.key 2048` 
then  `openssl rsa -in private.key -pubout -out public.key`. These are needed for encrypting and decrypting tokens

* Feel free to change the port mappings in `docker-compose.yml` if you already have services running on ports `8899` for
the phalcon app and `33066` for the mysql server

* Run the app like this `./bin/start.sh` or run `docker-compose up -d`

* Login to mysql using the credentials host:127.0.0.1, username: root, password:root, port: 33066

* Create two databases: `padlock_db` and `padlock_test_db` and import the sql file found in `app/db/padlock.sql` into 
both databases

Try it out
==========

Requesting a Token
------------------

1. Password Grant Flow: Send a `POST` request to `http://padlock.local/api/v1/oauth/token` with the following parameters:
    - client_id: test
    - client_secret: secret
    - grant_type: password
    - username: abc
    - password: abc
    
    NOTE: This grant returns an access token and a refresh token
    
2. Client Credentials Grant Flow: Send a `POST` request to `http://padlock.local/api/v1/oauth/token` with the following parameters:
    - client_id: test
    - client_secret: secret
    - grant_type: client_credentials
    
    NOTE: This grant returns only an access token

3. Refresh Token Grant: Send a `POST` request to `http://padlock.local/api/v1/oauth/token` with the following parameters:
    - client_id: test
    - client_secret: secret
    - grant_type: refresh_token
    - refresh_token: value gotten from any flow that returns a refresh token (e.g password grant flow)
    
    NOTE: This grant returns another access token and refresh token and invalidates/revokes the previous ones
    
4. Implicit Grant: Send a `GET` request to `http://padlock.local/api/v1/oauth/authorize` with the following parameters:
    - client_id: test
    - response_type: token
    - state: a random string (optional)
    - redirect_uri: http://www.test.com (optional)
    
    NOTE: This grant returns an access token immediately. It does not return a refresh token. 
    
5. Authorization Code Grant: Send a `GET` request to `http://padlock.local/api/v1/oauth/authorize` with the following parameters:
    - client_id: test
    - response_type: code
    - state: a random string (optional)
    - redirect_uri: http://www.test.com (optional)
    
    NOTE: This grant returns an authorization code that is then used to request for a token by sending a `POST`
    request to the endpoint `http://padlock.local/api/v1/oauth/token` with the following parameters:
    - client_id: test
    - client_secret: secret
    - grant_type: authorization_code
    - code: value gotten from the get request
    - redirect_uri: http://www.test.com (optional)
    
Validating a Token
------------------
Send a `POST` request to `http://padlock.local/api/v1/oauth/token/validate` with an `Authorization` header whose value is
`Bearer {access_token}`
  

Running Tests
-------------

* Make a copy of `.env.sample` to `.env.test` in the `app/env/` directory and replace the values.

* Login to the app container using `./bin/login.sh` or run `docker exec -it padlock_app bash`

* Execute unit tests  `./unit-test.sh` (uses [PHPUnit](https://phpunit.de/))

* Run integration tests using `./integration-test.sh` (uses [Codeception](https://codeception.com/)) 

## Install

Via Composer

``` bash
$ composer require tegaphilip/padlock
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Credits

- [Tega Oghenekohwo](https://github.com/tegaphilip)
- [Adeyemi Olaoye](https://github.com/yemexx1)
- [All Contributors][link-contributors]


[ico-version]: https://img.shields.io/packagist/v/tegaphilip/padlock.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/tegaphilip/padlock.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/tegaphilip/padlock
[link-code-quality]: https://scrutinizer-ci.com/g/tegaphilip/padlock
[link-downloads]: https://packagist.org/packages/tegaphilip/padlock
[link-contributors]: ../../contributors



