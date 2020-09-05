<?php

namespace App\Commands;

use Illuminate\Console\Command;

class HelloWorld extends Command
{
    protected $signature = 'command:HelloWorld';

    public function handle()
    {
        $this->comment('Hello World');
    }
}
