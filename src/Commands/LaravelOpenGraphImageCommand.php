<?php

namespace Vormkracht10\LaravelOpenGraphImage\Commands;

use Illuminate\Console\Command;

class LaravelOpenGraphImageCommand extends Command
{
    public $signature = 'laravel-open-graph-image';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
