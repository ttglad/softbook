<?php

namespace App\Http\Controllers\Admin;

use App\Models\SysDictData;
use Illuminate\Http\Request;
use Linfo\Linfo;

/**
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class MonitorController extends AdminController
{
    /**
     * 列表页
     */
    public function server(Request $request)
    {
        $linfo = new Linfo();
        $parser = $linfo->getParser();

        $ram = $parser->getRam();
        $ram['totalSize'] = $this->getMemSize($ram['total']);
        $ram['useSize'] = $this->getMemSize($ram['total'] - $ram['free']);
        $ram['freeSize'] = $this->getMemSize($ram['free']);

        return view('admin.monitor.server', [
            'cpu' => $parser->getCPU(),
            'cpuArchitecture' => $parser->getCPUArchitecture(),
            'os' => $parser->getOS(),
//            'kernel' => $parser->getKernel(),
            'accessedIp' => $parser->getAccessedIP(),
            'ram' => $ram,
//            'hd' => $parser->getHD(),
//            'mounts' => $parser->getMounts(),
            'hostName' => $parser->getHostName(),
            'upTime' => $parser->getUpTime(),
//            'model' => $parser->getModel(),
//            'net' => $parser->getNet(),
            'processStats' => $parser->getProcessStats(),
//            'services' => $parser->getServices(),
            'phpVersion' => $parser->getPhpVersion(),
            'webService' => $parser->getWebService(),
            'documentRoot' => $_SERVER['DOCUMENT_ROOT'],
        ]);
    }

    /**
     * 列表页
     */
    public function operLog(Request $request)
    {
        return view('admin.monitor.operLog', [
        ]);
    }

    /**
     * 获取文件大小
     * @param $filesize
     * @return string
     */
    private function getMemSize($filesize)
    {
        if ($filesize >= 1073741824) {
            //转成GB
            $filesize = round($filesize / 1073741824 * 100) / 100 . ' GB';
        } elseif ($filesize >= 1048576) {
            //转成MB
            $filesize = round($filesize / 1048576 * 100) / 100 . ' MB';
        } elseif ($filesize >= 1024) {
            //转成KB
            $filesize = round($filesize / 1024 * 100) / 100 . ' KB';
        } else {
            //不转换直接输出
            $filesize = $filesize . ' 字节';
        }
        return $filesize;
    }
}
