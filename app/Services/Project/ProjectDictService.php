<?php

namespace App\Services\Project;

use App\Models\Project\ProjectDict;
use TencentCloud\Common\Credential;
use TencentCloud\Tmt\V20180321\Models\TextTranslateBatchRequest;
use TencentCloud\Tmt\V20180321\Models\TextTranslateRequest;
use TencentCloud\Tmt\V20180321\TmtClient;

class ProjectDictService extends ProjectService
{
    /**
     * @return string[]
     */
    protected static function getExcludeChar()
    {
        return ['-', '_', '.', "'"];
    }

    /**
     * @return string[]
     */
    protected static function getExcludeWords()
    {
        return ['of', 'on', 'in'];
    }

    /**
     * @return TmtClient
     */
    public static function getClient()
    {
        $cred = new Credential(env('TENCENTCLOUD_SECRET_ID'), env('TENCENTCLOUD_SECRET_KEY'));
        return new TmtClient($cred, env('TENCENTCLOUD_REGION', 'ap-shanghai'));
    }

    /**
     * 根据内容返回值
     * @param $key
     * @return string
     */
    public static function getDictObj($key): ProjectDict
    {
        $dict = ProjectDict::where('dict_name', $key)->first();
        if (is_null($dict)) {
            $req = new TextTranslateRequest();
            $req->setProjectId(0);
            $req->setSource('zh');
            $req->setTarget('en');
            $req->setSourceText($key);
            $content = self::getClient()->TextTranslate($req);
            if (!is_null($content) && !empty($content->TargetText)) {
                $valueArray = explode(' ', $content->TargetText);
                $valueStr = '';
                foreach ($valueArray as $value) {
                    if (!in_array(strtolower($value), self::getExcludeWords())) {
                        $valueStr .= ucfirst($value);
                    }
                }
                $valueStr = str_replace(self::getExcludeChar(), '', $valueStr);
                $dict = new ProjectDict();
                $dict->dict_name = $key;
                $dict->dict_value = lcfirst($valueStr);
                $dict->save();
            }
        }
        return $dict;
    }

    /**
     * 根据内容返回值
     * @param $key
     * @return string
     */
    public static function getDictValue($key): string
    {
        $return = '';

        $dict = ProjectDict::where('dict_name', $key)->first();
        if (is_null($dict)) {
            $req = new TextTranslateRequest();
            $req->setProjectId(0);
            $req->setSource('zh');
            $req->setTarget('en');
            $req->setSourceText($key);
            $content = self::getClient()->TextTranslate($req);
            if (!is_null($content) && !empty($content->TargetText)) {
                $valueArray = explode(' ', $content->TargetText);
                $valueStr = '';
                foreach ($valueArray as $value) {
                    if (!in_array(strtolower($value), self::getExcludeWords())) {
                        $valueStr .= ucfirst($value);
                    }
                }
                $valueStr = str_replace(self::getExcludeChar(), '', $valueStr);
                $dict = new ProjectDict();
                $dict->dict_name = $key;
                $dict->dict_value = lcfirst($valueStr);
                $dict->save();
            }
        }
        return $dict->dict_value;
    }

    /**
     * 根据内容返回值
     * @param $keys
     * @return array
     */
    public static function getDictArray($keys): array
    {
        $return = [];
        $notExistKey = [];
        // 第一步遍历查询字典表
        foreach ($keys as $key) {
            if (isset($return[$key])) {
                continue;
            }
            $dict = ProjectDict::where('dict_name', $key)->first();
            if (is_null($dict)) {
                $notExistKey[] = $key;
            } else {
                $return[$key] = $dict->toArray();
            }
        }
        // 如何字典表不存在，则查询腾讯获取并入库
        if (!empty($notExistKey)) {
            $req = new TextTranslateBatchRequest();
            $req->setProjectId(0);
            $req->setSource('zh');
            $req->setTarget('en');
            $req->setSourceTextList($notExistKey);

            $content = self::getClient()->TextTranslateBatch($req);
            if (!is_null($content) && !empty($content->TargetTextList)) {
                foreach ($notExistKey as $i => $item) {
                    $valueArray = explode(' ', $content->TargetTextList[$i]);
                    $valueStr = '';
                    foreach ($valueArray as $value) {
                        if (!in_array(strtolower($value), self::getExcludeWords())) {
                            $valueStr .= ucfirst($value);
                        }
                    }
                    $valueStr = str_replace(self::getExcludeChar(), '', $valueStr);
                    $dict = new ProjectDict();
                    $dict->dict_name = $item;
                    $dict->dict_value = lcfirst($valueStr);
                    $dict->save();

                    $return[$item] = $dict->toArray();
                }
            }
        }
        return $return;
    }

}
