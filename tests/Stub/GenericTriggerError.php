<?php
namespace Stub;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ServerRequestInterface;

class GenericTriggerError implements DelegateInterface
{

    public function process(ServerRequestInterface $request)
    {
        trigger_error('stubing error handler');
    }
}