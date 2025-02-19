# Request Logger
[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)

&ensp;The simple template for create request logging system. \
\
&ensp; All that you need is to use some logger that implement `Psr\Log\LoggerInterface` 
and request mapper that implements `Bmwx591\RequestLogger\Mapper\RequestMapperInterface` 
for mapping log message and context. If you want to use some special rules to check if 
you need to log one request or another you can add rules resolver implementation of
`Bmwx591\RequestLogger\RulesResolver\RulesResolverInterface`. If you won\`t add rules 
resolver than all requests will be logged. \
\
&ensp; Logger works with wrapped requests and responses so you can write you own wrappers 
by implement `Bmwx591\RequestLogger\Logger\WrappedRequest` and 
`Bmwx591\RequestLogger\Logger\WrappedResponse` interfaces to add ability to work with 
you type of requests and responses if they don\`t implement PSR-7
`Psr\Http\Message\RequestInterface` and `Psr\Http\Message\ResponseInterface`.


## Usage/Examples

```php
use Bmwx591\RequestLogger\Logger\RequestLogger;

$requestLogger = new RequestLogger(
    new SomeLogger(), // some implementation of Psr\Log\LoggerInterface
    $requestMapper, // implementation of RequestMapperInterface for map message and content for request
    $rulesResolver // implementation of RulesResolverInterface or null
);

$requestLogger
    ->incomingRequest(<wrapped request>)
    ->outgoingResponse(<wrapped response>)
    ->addExternal(<ExternalRequest instance>)
    ->pushLogs();
```


## Authors

- [@bmwx591](https://www.github.com/bmwx591)


## Running Tests

To run tests, run the following command

```bash
vendor/bin/phpunit
```
