<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;


class SoftbookClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'softbook:clear {type?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'softbook clear tool';

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        $clearImage = false;
        $clearDoc = false;
        $type = $this->argument('type');
        if (empty($type)) {
            $clearImage = true;
            $clearDoc = true;
        } elseif ($type == 'image') {
            $clearImage = true;
        } elseif ($type == 'doc') {
            $clearDoc = true;
        } else {
            $this->error('type[' . $type . '] is error.');
        }
        if ($clearImage) {
            $files = File::allFiles(resource_path('softbook/image'));
            // 遍历并删除所有文件
            foreach ($files as $file) {
                if ($file->getCTime() >= strtotime("-12 month")) {
                    continue;
                }
                File::delete($file);
            }
        }
        if ($clearDoc) {
            $files = File::directories(resource_path('softbook/project'));
            // 遍历并删除所有文件
            foreach ($files as $file) {
                File::deleteDirectory($file);
            }
        }
    }
}
