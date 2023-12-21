<?php

namespace App\Console\Commands;

use App\Models\GenTable;
use App\Models\GenTableColumn;
use App\Models\SysConfig;
use App\Models\SysDictData;
use App\Models\SysMenu;
use App\Services\ResourceService;
use Illuminate\Console\Command;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;

use PhpOffice\PhpWord\Element\Code;


class SoftbookDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'softbook:doc';

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
        $imagePath = rtrim(env('SOFTBOOK_IMAGE_DIR', resource_path('softbook/image')), '/') . '/';
        $basePath = rtrim(env('SOFTBOOK_BASE_DIR', resource_path('softbook')), '/') . '/';
        $savePath = rtrim(env('SOFTBOOK_SAVE_DIR', resource_path('softbook/project')), '/') . '/';

        // 软件名称
        $sysConfig = SysConfig::where('config_key', 'sys.soft.name')->first();
        $projectName = $sysConfig->config_value;
        $sysConfig = SysConfig::where('config_key', 'sys.soft.code')->first();
        $projectKey = $sysConfig->config_value;

        // 行业
        $businessType = '通讯行业';

        // 系统功能
        $systemFeatures = '该系统是一款通信信号调度集成系统，主要包括信号调度管理、通信设备配置、网络拓扑管理等功能。通过对信号强度的监控和调度任务的分析，确保通信信号的稳定性和调度效果。';
        // 开发目的
        $developmentPurpose = '系统旨在提供一套高效的通信信号调度解决方案，通过对信号的监测和调度任务的分析，优化通信信号的质量，提高调度效果，增强通信系统的稳定性。';
        // 技术特点
        $technicalFeatures = '系统采用先进的信号监控和调度技术，实现对通信信号的全面调度管理。报警与处理模块支持智能化处理异常情况，提高调度应对能力。系统还具备灵活的任务分析与效果评估功能，支持多维度的数据分析，为通信信号调度提供科学依据。';

        $savePath .= $projectName . '/';
        if (!is_dir($savePath)) {
            // 创建目录
            mkdir($savePath, 0777, true);
        }

        // 生成说明文档
        $this->saveProjectInfo($projectName, $imagePath, $savePath, $basePath);

        // 生成代码
        $this->saveCodeInfo($projectName, $savePath);

        // 生成信息采集表
        $this->saveInfoTable($projectName, $savePath, $systemFeatures, $developmentPurpose, $technicalFeatures, $businessType);
    }

    /**
     * 生成说明文档
     * @param $projectName
     * @param $imagePath
     * @param $savePath
     * @param $basePath
     * @return void
     */
    private function saveProjectInfo($projectName, $imagePath, $savePath, $basePath)
    {
        $imageNum = 0;

        /**
         * 生成使用说明
         */
        $phpWord = new PhpWord();
        $section = $phpWord->addSection([
            'headerHeight' => 850,
            'footerHeight' => 964,
        ]);

        $fontStyle = [
            'name' => '宋体(正文)',  // 字体
            'size' => 10.5,       // 字体大小
        ];

        $pageStyle = [
            'indentation' => ['firstLine' => 360],
            'spaceBefore' => 30,
            'spaceAfter' => 30,
        ];

        $pageImageStyle = [
            'alignment' => Jc::CENTER,
            'spaceAfter' => 60,
        ];

        // 添加页眉
        $header = $section->addHeader();
        $header->addText($projectName, [
            'name' => '宋体(正文)',  // 字体
            'size' => 9,       // 字体大小
        ]);

        // 添加页脚
        $footer = $section->addFooter();
        $footer->addPreserveText('{PAGE}', [
            'name' => '宋体(正文)',  // 字体
            'size' => 9,       // 字体大小
        ], ['alignment' => Jc::CENTER]);

        $section->addText('概述', $fontStyle, [
            'alignment' => Jc::CENTER,
            'spaceAfter' => 30,
        ]);

        $section->addText('该平台主要功能包括', $fontStyle, $pageStyle);

        $phpWord->addNumberingStyle(
            'multilevel',
            [
                'type' => 'multilevel',
                'levels' => [
                    ['format' => '', 'text' => '', 'left' => 0, 'hanging' => 360, 'tabPos' => 360],
                    ['format' => '', 'text' => '%1.%2', 'left' => 360, 'hanging' => 360, 'tabPos' => 360],
                ]
            ]
        );

        $section->addListItem('一、用户登录', 0, $fontStyle, 'multilevel');
        $section->addText('如图1所示，用户在账号登录框输入用户名和密码即可进入系统。', $fontStyle, $pageStyle);
        $section->addText('功能介绍：系统设置了不同的管理权限，由超级管理员分配用户权限和设置账号密码，不同用户账号之间存在权限区别，如用户是否能够是否能够查看详细运行数据的权限等。',
            $fontStyle, $pageStyle);

        $imageStyle = [
            'alignment' => Jc::CENTER,
            'width' => 420,  // 设置图片宽度为100%页面宽度
            'height' => 230, // 设置图片高度为100%页面高度
        ];

        if (is_file($imagePath . 'login.png')) {
            $section->addImage($imagePath . 'login.png', $imageStyle, false, '用户登录');
        }
        $section->addText('图' . ++$imageNum . '  用户登录', $fontStyle, $pageImageStyle);

        $menus = $this->getMenuTrees();
        foreach ($menus as $item => $menu) {
            if ($item == 0) {
                $itemOrder = '二、';
            }
            if ($item == 1) {
                $itemOrder = '三、';
            }
            if ($item == 2) {
                $itemOrder = '四、';
            }
            $section->addListItem($itemOrder . $menu['menu_name'], 0, $fontStyle, 'multilevel');
            $section->addText('这个一级菜单主要包括两个二级菜单，本一级菜单具体功能介绍如下：', $fontStyle, $pageStyle);

            foreach ($menu['children'] as $child) {
                // 获取表名字
                $tableName = trim(str_replace("/business/", '', $child['url']), '/');
                $table = GenTable::with('columns')->where('table_name', $tableName)->first();
                $tableColumnDesc = '';
                if (!is_null($table)) {
                    $tableColumnDesc .= '包含字段：';
                    foreach ($table->columns as $column) {
                        if ($column->is_list == '1') {
                            $tableColumnDesc .= $column->column_comment . '、';
                        }
                    }
//                    $this->info($tableColumnDesc);
                    $tableColumnDesc = mb_substr($tableColumnDesc, 0, -1) . '。';
                }

                // 获取临时的序号
                $tempImageNum = $imageNum;

                $section->addListItem($child['menu_name'], 1, $fontStyle, 'multilevel');
                $section->addText('功能入口：点击左部菜单中，即可进入该菜单界面查看其信息内容。', $fontStyle, $pageStyle);
                $section->addText('功能介绍：该菜单设计了通过名称智能查找、对各字段的新增、编辑和删除处理，具体功能如下。' . $tableColumnDesc,
                    $fontStyle,$pageStyle);

                if (is_file($imagePath . $child['imagePrefix'] . '-01.png')) {
                    $section->addImage($imagePath . $child['imagePrefix'] . '-01.png', $imageStyle, false);
                }
                $section->addText('图' . ++$imageNum . '  菜单查看', $fontStyle, $pageImageStyle);

                $section->addText('添加功能：点击信息编辑栏中的“添加”按钮即可进行信息的添加，填写各字段信息，点击完成即可进行新增，具体操作如图' . ++$tempImageNum . '、图' . ++$tempImageNum . '所示。',
                    $fontStyle, $pageStyle);
                if (is_file($imagePath . $child['imagePrefix'] . '-02.png')) {
                    $section->addImage($imagePath . $child['imagePrefix'] . '-02.png', $imageStyle, false);
                }
                $section->addText('图' . ++$imageNum . '  新增信息', $fontStyle, $pageImageStyle);

                if (is_file($imagePath . $child['imagePrefix'] . '-03.png')) {
                    $section->addImage($imagePath . $child['imagePrefix'] . '-03.png', $imageStyle, false);
                }
                $section->addText('图' . ++$imageNum . '  新增后界面', $fontStyle, $pageImageStyle);

                $section->addText('编辑功能：点击信息编辑栏中的“编辑”按钮即可进行信息的编辑，更改各字段信息，点击完成即可进行编辑，具体操作如图' . ++$tempImageNum . '、图' . ++$tempImageNum . '所示。',
                    $fontStyle, $pageStyle);
                if (is_file($imagePath . $child['imagePrefix'] . '-04.png')) {
                    $section->addImage($imagePath . $child['imagePrefix'] . '-04.png', $imageStyle, false);
                }
                $section->addText('图' . ++$imageNum . '  编辑信息', $fontStyle, $pageImageStyle);

                $section->addText('删除功能：点击信息编辑栏中的“删除”按钮即可进行信息的删除，具体操作如图' . ++$tempImageNum . '、图' . ++$tempImageNum . '所示。',
                    $fontStyle, $pageStyle);

                if (is_file($imagePath . $child['imagePrefix'] . '-05.png')) {
                    $section->addImage($imagePath . $child['imagePrefix'] . '-05.png', $imageStyle, false);
                }
                $section->addText('图' . ++$imageNum . '  删除信息', $fontStyle, $pageImageStyle);
            }
        }

        // 获取临时的序号
        $tempImageNum = $imageNum;

        $section->addListItem('五、用户管理', 0, $fontStyle, 'multilevel');
        $section->addText('功能入口：点击左部菜单系统管理-用户管理，即可进入该界面。', $fontStyle, $pageStyle);
        $section->addText('功能介绍：系统设置，可以管理用户信息等，通过对系统中的用户进行创建、删除、修
改和权限控制等操作，确保系统安全性和有效性。旨在提供合法用户访问系统、限制用户操作范围和访问权限、管理用户个人信息以及收集用户行为数据等功能。如图' . ++$tempImageNum . '所示。',
            $fontStyle, $pageStyle);
        if(is_file($basePath . 'user.png')) {
            $section->addImage($basePath . 'user.png', [
                'alignment' => Jc::CENTER,
                'width' => 400,  // 设置图片宽度为100%页面宽度
                'height' => 250, // 设置图片高度为100%页面高度
            ], false);
        }
        $section->addText('图' . ++$imageNum . '  编辑信息', $fontStyle, $pageImageStyle);

        $section->addListItem('六、角色管理', 0, $fontStyle, 'multilevel');
        $section->addText('功能入口：点击左部菜单系统管理-角色管理，即可进入该界面。', $fontStyle, $pageStyle);
        $section->addText('功能介绍：系统设置，可以管理角色信息等，通过将用户分配到不同的角色中，每个角色具有不同的权限和功能，来实现对系统中用户权限的控制和管理。方便系统进行细粒度的权限控制，确保用户只能访问其具备权限的资源，提高系统的安全性和可管理性。如图' . ++$tempImageNum . '所示。',
            $fontStyle, $pageStyle);

        if (is_file($basePath . 'role.png')) {
            $section->addImage($basePath . 'role.png', [
                'alignment' => Jc::CENTER,
                'width' => 400,  // 设置图片宽度为100%页面宽度
                'height' => 250, // 设置图片高度为100%页面高度
            ], false);
        }

        $section->addText('图' . ++$imageNum . '  角色管理', $fontStyle, $pageImageStyle);

        $section->addListItem('七、系统监控', 0, $fontStyle, 'multilevel');
        $section->addText('功能入口：点击左侧菜单栏系统监控，可以查看各个维度的监控数据，实时监测系统的运行状态、资源利用率、响应时间等指标，及时发现并解决潜在的问题，提高系统的运行效率和可用性。',
            $fontStyle, $pageStyle);
        if (is_file($basePath . 'monitor.png')) {
            $section->addImage($basePath . 'monitor.png', [
                'alignment' => Jc::CENTER,
                'width' => 400,  // 设置图片宽度为100%页面宽度
                'height' => 250, // 设置图片高度为100%页面高度
            ], false);
        }
        $section->addText('图' . ++$imageNum . '  系统监控', $fontStyle, $pageImageStyle);

        $phpWord->save($savePath . $projectName . '使用说明.docx');
    }


    /**
     * 生成代码文档
     * @param $projectName
     * @param $savePath
     * @return void
     */
    private function saveCodeInfo($projectName, $savePath)
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection([
            'headerHeight' => 850,
            'footerHeight' => 964,
            'lineNumbering' => [
                'start' => 1,
                'restart' => 'newSection'
            ]
        ]);

        $fontStyle = [
            'name' => '宋体(正文)',  // 字体
            'size' => 10.5,       // 字体大小
        ];

        // 添加页眉
        $header = $section->addHeader();
        $header->addText($projectName, [
            'name' => '宋体(正文)',  // 字体
            'size' => 9,       // 字体大小
        ]);

        // 添加页脚
        $footer = $section->addFooter();
        $footer->addPreserveText('{PAGE}', [
            'name' => '宋体(正文)',  // 字体
            'size' => 9,       // 字体大小
        ], ['alignment' => Jc::CENTER]);

        // 获取代码
        $contents = $this->getCodes();

        $codeArray = explode("\n", $contents);
        foreach ($codeArray as $code) {
            if (empty($code)) {
                continue;
            }
            $section->addText(htmlspecialchars($code), $fontStyle);
        }

        $phpWord->save($savePath . $projectName . '代码.docx');
    }

    /**
     * 生成信息采集表
     * @param $projectName
     * @param $savePath
     * @param $systemFeatures
     * @param $developmentPurpose
     * @param $technicalFeatures
     * @return void
     */
    private function saveInfoTable(
        $projectName,
        $savePath,
        $systemFeatures,
        $developmentPurpose,
        $technicalFeatures,
        $businessType
    ) {
        $config = config('softbook');

        $phpWord = new PhpWord();
        $section = $phpWord->addSection([
            'marginTop' => 567,
            'marginBottom' => 567,
            'marginLeft' => 1418,
            'marginRight' => 1418,
            'headerHeight' => 418,
            'footerHeight' => 340,
        ]);

        $fontStyle = [
            'name' => '宋体(正文)',  // 字体
            'size' => 10.5,       // 字体大小
        ];

        $fontStyleBold = [
            'name' => '宋体(正文)',  // 字体
            'size' => 10.5,       // 字体大小
            'bold' => true,
        ];

        $pageStyle = [
            'spaceBefore' => 30,
            'spaceAfter' => 30,
            'alignment' => 'left',
            'indentation' => [
                'left' => 100,
            ],
        ];

        // 添加页眉
        $header = $section->addHeader();
        $header->setMarginTop(418);
        $header->addText('计算机软件著作权登记', [
            'name' => '宋体(正文)',  // 字体
            'size' => 10,       // 字体大小
        ], [
            'alignment' => Jc::CENTER,
        ]);

        $tableWidth = 9100;
        $tableLeftWidth = 2800;
        $tableRightWidth = $tableWidth - $tableLeftWidth;
        $table = $section->addTable([
            'borderColor' => '000000',
            'borderSize' => 5,
        ]);

        $table->addRow(); // 添加表头行
        $table->addCell($tableWidth, ['gridSpan' => 2])->addText('计算机软件著作权登记', [
            'name' => '宋体(正文)',  // 字体
            'size' => 12,       // 字体大小
            'bold' => true,       // 加粗
        ], [
            'alignment' => JC::CENTER,
//            'spacing' => 120,
            'spaceBefore' => 30,
            'spaceAfter' => 30,
        ]);

        $table->addRow(); // 添加表头行
        $table->addCell($tableWidth, ['gridSpan' => 2])
            ->addText('注意事项：一经提交无法修改，请谨慎填写！（以此表格电子资料为依据）', $fontStyleBold, $pageStyle);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*软件全称：', $fontStyleBold, $pageStyle);
        $table->addCell($tableRightWidth)
            ->addText($projectName, $fontStyleBold, $pageStyle);// 添加数据行

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('软件简称：（可无）', $fontStyleBold, $pageStyle);
        $table->addCell($tableRightWidth);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*版本号：（如：V1.0 ）', $fontStyleBold, $pageStyle);
        $table->addCell($tableRightWidth)
            ->addText('V1.0', $fontStyle, $pageStyle);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*软件分类', $fontStyleBold, $pageStyle);
        $table->addCell($tableRightWidth)
            ->addText('应用软件', $fontStyle, $pageStyle);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*软件开发完成日期：', $fontStyleBold, $pageStyle);
        $table->addCell($tableRightWidth);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*是否发表（未发表/已发表+发表时间+发表地点）', $fontStyleBold, $pageStyle);
        $table->addCell($tableRightWidth)
            ->addText('未发表', $fontStyle, $pageStyle);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*著作权人（公司名称）', $fontStyleBold, $pageStyle);
        $table->addCell($tableRightWidth);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*统一社会信用代码', $fontStyleBold, $pageStyle);
        $table->addCell($tableRightWidth);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*公司成立日期:(年月日)', $fontStyleBold, $pageStyle);
        $table->addCell($tableRightWidth);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*软件运行硬件环境：', $fontStyleBold, $pageStyle);
        $cell = $table->addCell($tableRightWidth);
        $cell->addText('', $fontStyle, $pageStyle);
        $cell->addText('处理器：' . $config['cpu'][array_rand($config['cpu'])], $fontStyle, $pageStyle);
        $cell->addText('内存：' . $config['member'][array_rand($config['member'])], $fontStyle, $pageStyle);
        $cell->addText('硬盘：' . $config['disk'][array_rand($config['disk'])], $fontStyle, $pageStyle);
        $cell->addText('', $fontStyle, $pageStyle);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*软件运行软件环境：', $fontStyleBold, $pageStyle);
        $table->addCell($tableRightWidth)
            ->addText($config['system'][array_rand($config['system'])], $fontStyle, $pageStyle);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*开发该软件的操作系统', $fontStyleBold, $pageStyle);
        $table->addCell($tableRightWidth)
            ->addText($config['develop_system'][array_rand($config['develop_system'])], $fontStyle, $pageStyle);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*软件开发环境/开发工具', $fontStyleBold, $pageStyle);
        $cell = $table->addCell($tableRightWidth);
        $cell->addText('', $fontStyle, $pageStyle);
        $cell->addText('PHP7.3', $fontStyle, $pageStyle);
        $cell->addText('MySql', $fontStyle, $pageStyle);
        $cell->addText('PhpStorm', $fontStyle, $pageStyle);
        $cell->addText('', $fontStyle, $pageStyle);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*该软件的运行平台/操作系统', $fontStyleBold, $pageStyle);
        $cell = $table->addCell($tableRightWidth);
        $cell->addText('', $fontStyle, $pageStyle);
        $cell->addText('Linux', $fontStyle, $pageStyle);
        $cell->addText('ubuntu', $fontStyle, $pageStyle);
        $cell->addText('MasOs', $fontStyle, $pageStyle);
        $cell->addText('WinServer', $fontStyle, $pageStyle);
        $cell->addText('', $fontStyle, $pageStyle);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*软件运行支撑环境/支持软件', $fontStyleBold, $pageStyle);
        $cell = $table->addCell($tableRightWidth);
        $cell->addText('', $fontStyle, $pageStyle);
        $cell->addText(implode(' / ', [
            $config['php_ver'][array_rand($config['php_ver'])],
            $config['mysql_ver'][array_rand($config['mysql_ver'])],
            $config['nginx_ver'][array_rand($config['nginx_ver'])],
        ]), $fontStyle, $pageStyle);
        $cell->addText('', $fontStyle, $pageStyle);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*编程语言', $fontStyleBold, $pageStyle);
        $table->addCell($tableRightWidth)
            ->addText('PHP、Html、Javascript', $fontStyle, $pageStyle);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*程序量', $fontStyleBold, $pageStyle);
        $table->addCell($tableRightWidth)
            ->addText(rand(61000, 69000), $fontStyle, $pageStyle);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*开发目的', $fontStyleBold, $pageStyle);
        $cell = $table->addCell($tableRightWidth);
        $cell->addText($developmentPurpose, $fontStyle, $pageStyle);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*面向领域/行业', $fontStyleBold, $pageStyle);
        $table->addCell($tableRightWidth)
            ->addText($businessType, [
                'name' => '宋体(正文)',  // 字体
                'size' => 10.5,       // 字体大小
                'bold' => true,
                'color' => 'FF0000',
            ], $pageStyle);


        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*软件的主要功能', $fontStyleBold, $pageStyle);
        $cell = $table->addCell($tableRightWidth);
        $cell->addText($systemFeatures, $fontStyle, $pageStyle);

        // 添加数据行
        $table->addRow();
        $table->addCell($tableLeftWidth)
            ->addText('*软件的技术特点', $fontStyleBold, $pageStyle);
        $cell = $table->addCell($tableRightWidth);
        $cell->addText($technicalFeatures, $fontStyle, $pageStyle);

        $phpWord->save($savePath . $projectName . '信息采集表.docx');
    }


    /**
     * 获取菜单树
     * @return array
     */
    private function getMenuTrees(): array
    {
        $menuTrees = [];
        $menus = SysMenu::where('visible', 0)->orderByDesc('menu_id')->take(9)->get();
//        $this->info('menu size is: ' . sizeof($menus));
        if (sizeof($menus) > 0) {
            // 取父节点
            foreach ($menus as $item) {
                if ($item->parent_id == 0) {
//                    $this->info($item->menu_id);
                    $menuTrees[$item->menu_id] = [
                        'menu_id' => $item->menu_id,
                        'menu_name' => $item->menu_name,
                        'parent_id' => $item->parent_id,
                        'order_num' => $item->order_num,
                        'url' => $item->url,
                        'target' => $item->target,
                        'imagePrefix' => '#'
                    ];
                }
            }
            // 取子节点挂载到父节点children
            foreach ($menus as $item) {
                if ($item->parent_id > 0) {
//                    $this->info($item->parent_id);
                    $menuTrees[$item->parent_id]['children'][] = [
                        'menu_id' => $item->menu_id,
                        'menu_name' => $item->menu_name,
                        'parent_id' => $item->parent_id,
                        'order_num' => $item->order_num,
                        'url' => $item->url,
                        'target' => $item->target,
                        'imagePrefix' => explode('/', $item->url)[2]
                    ];
                }
            }
            // 父节点排序
            usort($menuTrees, function ($a, $b) {
                return $a['order_num'] - $b['order_num'];
            });

            // 子节点排序
            foreach ($menuTrees as &$item) {
                usort($item['children'], function ($a, $b) {
                    return $a['order_num'] - $b['order_num'];
                });
            }
        }
        return array_values($menuTrees);
    }

    /**
     * 获取源码
     * @return array|string|string[]
     * @throws \Throwable
     */
    private function getCodes(): string
    {
        $content = '';
        try {
            $menus = $this->getMenuTrees();
            $resourceService = new ResourceService();

            // 获取登录页面 ######
            $sysConfig = SysConfig::where('config_key', 'sys.account.registerUser')->first();
            $registerValue = is_null($sysConfig) ? false : $sysConfig->config_value;
            $rememberMe = true;
            $captchaEnabled = false;
            // 软件名称
            $sysConfig = SysConfig::where('config_key', 'sys.soft.name')->first();
            $softName = $sysConfig->config_value;

            $content .= view('admin.auth.login', [
                'registerValue' => $registerValue,
                'rememberMe' => $rememberMe,
                'captchaEnabled' => $captchaEnabled,
                'softName' => $softName,
            ])->render();

            // 获取用户页 ######
            // 获取菜单展示名称
            $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();
            $content .= view('admin.user.user', [
                'sysNormalDisable' => $sysNormalDisable,
            ])->render();

            // 菜单业务列表
            // 获取页面代码 ######
            foreach ($menus as $menu) {
                if (empty($menu['children'])) {
                    continue;
                }
                foreach ($menu['children'] as $child) {
                    $table = str_replace('business/', '', trim($child['url'], '/'));

                    // 获取业务表名称
                    $business = GenTable::where('table_name', $table)->first();
                    if (is_null($business)) {
                        throw new \Exception('业务不存在', 1001);
                    }
                    // 业务列名称
                    $businessColumn = GenTableColumn::where('table_id', $business->table_id)->orderBy('sort')->get();

                    // 获取业务展示页面
                    $content .= view('business.show', [
                        'business' => $business,
                        'businessColumn' => $businessColumn,
                    ])->render();
                }
            }

            // 获取登录+用户服务
            $content .= file_get_contents(app_path('Http/Controllers/Admin/AuthorityController.php'));
//            $content .= file_get_contents(app_path('Http/Controllers/Admin/UserController.php'));
            $content .= file_get_contents(app_path('Models/SysUser.php'));

            // 获取服务代码
            foreach ($menus as $menu) {
                if (empty($menu['children'])) {
                    continue;
                }
                foreach ($menu['children'] as $child) {
                    $table = str_replace('business/', '', trim($child['url'], '/'));

                    // 获取业务表名称
                    $business = GenTable::where('table_name', $table)->first();
                    if (is_null($business)) {
                        throw new \Exception('业务不存在', 1001);
                    }
                    // 业务列名称
                    $businessColumn = GenTableColumn::where('table_id', $business->table_id)->orderBy('sort')->get();

                    // 获取model代码
                    $content .= $resourceService->getControllerContent($business, $businessColumn);
                    $content .= $resourceService->getModelContent($business, $businessColumn);
                    $content .= $resourceService->getServiceContent($business, $businessColumn);
                }
            }
        } catch (\Exception $e) {

        }

        // 替换软件代码
        $sysConfig = SysConfig::where('config_key', 'sys.soft.code')->first();
        if (!is_null($sysConfig) && !empty($sysConfig->config_value)) {
            $content = str_replace('ruoyi', $sysConfig->config_value, $content);
        }

        $content = str_replace('©', '', $content);

        return $content;
    }
}
