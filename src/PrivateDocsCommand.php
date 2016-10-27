<?php

namespace JapSeyz\PrivateDocs;

use Illuminate\Console\Command;

class PrivateDocsCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'privatedocs:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate private API documentation from existing Laravel routes.';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return false|null
     */
    public function handle()
    {
        $command = 'apidoc:generate --output="resources/views/docs"
                    --routePrefix='.config('privatedocs.routes').'
                    --actAsUserId='.config('privatedocs.user_id');

        \Artisan::call($command);
    }

}
