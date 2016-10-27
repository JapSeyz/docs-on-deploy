<?php

namespace JapSeyz\Docs;

use Illuminate\Console\Command;

class DocsCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docs:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate API Docs on deploy';


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
        if(!config('deploydocs.enabled')){
            if(is_dir(public_path('docs'))){
                $dir = public_path('docs');

                $files = array_diff(scandir($dir), array('.','..'));
                foreach ($files as $file) {
                    is_dir("$dir/$file") ? delTree("$dir/$file") : unlink("$dir/$file");
                }
                return rmdir($dir);
            }
        } else {
            $command = 'api:generate';
            $options = [
                '--output' => config('deploydocs.output'),
                '--routePrefix' => config('deploydocs.routes'),
                '--actAsUserId' => config('deploydocs.user_id')
            ];

            \Artisan::call($command, $options);
        }
    }
}
