<?php

namespace App\Jobs;

use App\Models\Project\ProjectInfo;
use App\Services\Project\ProjectDocService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ProjectDocSave implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 4;

    public $timeout = 600;
    public $projectId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $projectService = new ProjectDocService();
            $project = ProjectInfo::findOrFail($this->projectId);
            $projectService->saveDocByProject($project, false);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
