<?php

namespace Alareqi\WasenderExtend\Commands;

use Illuminate\Console\Command;

class WasenderExtendCommand extends Command
{
    public $signature = 'wasender-extend';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
