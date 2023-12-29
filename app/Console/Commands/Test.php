<?php

namespace App\Console\Commands;

use App\Models\SysMenu;
use App\Services\Project\ProjectDictService;
use App\Utils\StringUtils;
use Illuminate\Console\Command;

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;

use PhpOffice\PhpWord\SimpleType\TextAlignment;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\Style\Paragraph;
use PhpOffice\PhpWord\Style\Numbering;

use PhpOffice\PhpWord\Style\ListItem;

use PhpOffice\PhpWord\SimpleType;
use PhpOffice\PhpWord\Style\Image;
use PhpOffice\PhpWord\SimpleType\TblWidth;


class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'php test';


    public function handle()
    {
        $string = 'hell_word_1';

//        $string = StringUtils::underscoreToCamelCase($string, true);
//        $this->info(lcfirst($string));
//        $string = StringUtils::getDbColumnType("int(11)", true);
//        $this->info(lcfirst($string));
//        $string = StringUtils::getDbColumnLength("int(111)", true);
//        $this->info(($string));
//
//        $string = '访问文件';
//
//        $data = ProjectDictService::getDictObj($string);
//        var_dump($data);
    }

}
