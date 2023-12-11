<?php

namespace BitcodeSa\Msegat\Commands;

use Illuminate\Console\Command;

class MsegatCommand extends Command
{
    public $signature = 'msegat';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
