<?php

namespace Vormkracht10\LaravelOpenGraphImage\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearCache extends Command
{
    public $signature = 'open-graph-image:clear-cache';

    public $description = 'Clear cached open graph images';

    protected $storageDisk;

    protected $storagePath;

    public function __construct()
    {
        parent::__construct();
        $this->storageDisk = config('open-graph-image.storage.disk');
        $this->storagePath = config('open-graph-image.storage.path');
    }

    public function handle(): int
    {
        $this->info('Clearing cached open graph images...');

        $this->getStorageDisk()->deleteDirectory($this->storagePath);

        $this->comment('All done');

        return self::SUCCESS;
    }

    public function getStorageDisk()
    {
        return Storage::disk($this->storageDisk);
    }
}
