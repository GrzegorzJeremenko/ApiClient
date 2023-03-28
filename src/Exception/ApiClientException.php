<?php

namespace ApiClient\Exception;

use Psr\Http\Client\ClientExceptionInterface;

class ApiClientException extends \Exception implements ClientExceptionInterface
{
}