<?php

namespace App\Console\Commands;

use App\Models\Project\ProjectInfo;
use App\Services\Project\ProjectDocService;
use Illuminate\Console\Command;


class SoftbookDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'softbook:doc {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'softbook doc tool';

    /**
     * Execute the console command.
     * https://phpword-zh.readthedocs.io/zh-cn/latest/intro.html
     * 文档：https://phpword.readthedocs.io/en/latest/intro.html
     *
     * github：https://github.com/PHPOffice/PHPWord
     *
     * 中文文档：https://segmentfault.com/a/1190000019479817（应该是这位大神理解编写的）
     *
     * 中文文档：https://phpword-zh.readthedocs.io/_/downloads/zh_CN/latest/pdf/（强烈推荐）
     * @return mixed
     */
    public function handle()
    {
        $id = $this->argument('id');
        $project = ProjectInfo::find($id);

        if (!is_null($project)) {
            $docService = new ProjectDocService();
            $docService->saveDocByProjectId($project, false);
        } else {
            $this->error('项目id未查询到数据');
        }
    }
}
