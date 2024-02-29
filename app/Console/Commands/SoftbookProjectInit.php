<?php

namespace App\Console\Commands;

use App\Services\Project\ProjectInfoService;
use Illuminate\Console\Command;


class SoftbookProjectInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'softbook:projectInit {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'softbook project init tool';

    /**
     * @return mixed
     */
    public function handle()
    {
        $id = $this->argument('id');

        $projectService = new ProjectInfoService();
        $projectService->projectDataInit($id);
        $projectService->projectMenuDescInit($id);
    }
}
