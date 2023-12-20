<?php

namespace App\Http\Controllers\Admin;

use TencentCloud\Common\Credential;
use TencentCloud\Tmt\V20180321\Models\TextTranslateRequest;
use TencentCloud\Tmt\V20180321\TmtClient;

/**
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class ProjectController extends AdminController
{
    /**
     * https://cloud.tencent.com/document/api/551/15615#.E5.9C.B0.E5.9F.9F.E5.88.97.E8.A1.A8
     * @return void
     */
    public function test()
    {
        $cred = new Credential(env('TENCENTCLOUD_SECRET_ID'), env('TENCENTCLOUD_SECRET_KEY'));
        $client = new TmtClient($cred, 'ap-shanghai');
        $req = new TextTranslateRequest();
        $req->setProjectId(0);
        $req->setSource('zh');
        $req->setTarget('en');
        $req->setSourceText('软件著作');
//        $req->setUntranslatedText();
//        print_r($client->TextTranslate($req));exit;
        $action = 'TextTranslate';
        $response = $client->returnResponse($action, $client->TextTranslate($req));
        print_r($response);exit;
    }
}
