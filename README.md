# ApiClient
### ApiClient is a simple library for making HTTP requests in PHP.

## Installation
```bash 
composer require grzegorzjeremenko/apiclient
```

## Testing
```bash
composer test
```

## Usage
```php
use ApiClient/ApiClient;

$client = new ApiClient();
$response = $client->sendRequest($request);
```

### Change logger
```php
use ApiClient/Logger;

$logger = new Logger([
    "logTo" => [
        "Console",
        "File"
    ],
    "logDir" => __DIR__ . "logs/"
]);

$client->setLogger($logger);
```

### Change connection method
```php
use ApiClient/CurlConnect;

$client->setConnect(new CurlConnect());
```

### Change request authorization type
```php
use ApiClient/Signer;

$signer = new Signer();
$signer->setMethod(new BasicAuthorizationStrategy());
// or
$signer->setMethod(new JWTAuthorizationStrategy());

$signer->setKey("testKey");

$client->setSigner($signer);
```

## License
ApiClient is licensed under the MIT License - see the LICENSE file for details

