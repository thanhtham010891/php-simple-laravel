<?php

namespace App\Exceptions;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Throwable;

class AppException implements ExceptionHandler
{
    public function report(Throwable $e)
    {
        dd($e->getMessage(), $e->getTrace());
    }

    public function shouldReport(Throwable $e)
    {
        // TODO: Implement shouldReport() method.
    }

    public function render($request, Throwable $e)
    {
        // TODO: Implement render() method.
    }

    public function renderForConsole($output, Throwable $e)
    {
        // TODO: Implement renderForConsole() method.
    }
}
