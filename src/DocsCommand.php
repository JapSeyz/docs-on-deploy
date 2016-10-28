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
            $dir = config('deploydocs.output');
            if(is_dir(base_path($dir))){
                $this->delTree($dir);
            }
        } else {
            $command = 'api:generate';
            $options = [
                '--output' => config('deploydocs.output'),
                '--routePrefix' => config('deploydocs.routes'),
                '--actAsUserId' => config('deploydocs.user_id'),
                '--bindings' => config('deploydocs.bindings'),
            ];

            \Artisan::call($command, $options);
        }
    }

    /**
     * Recursively delete a directory
     *
     * @param string $dir
     *
     * @return bool
     */
    private function delTree($dir){
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            is_dir("$dir/$file") ? $this->delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
}
