<?php

namespace App\Services;

use WebSocket\Client;

class XfyunService extends Service
{
    const XF_URL = 'wss://spark-api.xf-yun.com/v3.5/chat';

    public function getMessage($question)
    {
        //密钥信息，在开放平台-控制台中获取：https://console.xfyun.cn/services/cbm
        $Appid = env('XF_APPID');
//        print_r($Appid);
        $Apikey = env('XF_API_KEY');
//        print_r($Apikey);
        // $XCurTime =time();
        $ApiSecret = env('XF_API_SECRET');
//        print_r($ApiSecret);

        // $XCheckSum ="";

        // $data = $this->getBody("你是谁？");
        $authUrl = $this->assembleAuthUrl("GET", self::XF_URL, $Apikey, $ApiSecret);
        //创建ws连接对象
        $client = new Client($authUrl);

        // 连接到 WebSocket 服务器
        if ($client) {
            // 发送数据到 WebSocket 服务器
            $data = $this->getBody($Appid, $question);
            $client->send($data);

            // 从 WebSocket 服务器接收数据
            $answer = "";
            while (true) {
                $response = $client->receive();
                $resp = json_decode($response, true);
                $code = $resp["header"]["code"];
//                echo "从服务器接收到的数据： " . $response;
                if (0 == $code) {
                    $status = $resp["header"]["status"];
                    if ($status != 2) {
                        $content = $resp['payload']['choices']['text'][0]['content'];
                        $answer .= $content;
                    } else {
                        $content = $resp['payload']['choices']['text'][0]['content'];
                        $answer .= $content;
//                        $total_tokens = $resp['payload']['usage']['text']['total_tokens'];
//                        print("\n本次消耗token用量：\n");
//                        print($total_tokens);
                        break;
                    }
                } else {
//                    echo "服务返回报错" . $response;
                    break;
                }
            }

            return $answer;
//            print("\n返回结果为：\n");
//            print($answer);
        } else {
//            echo "无法连接到 WebSocket 服务器";
        }
        return '';
    }

    /**
     * 发送post请求
     * @param string $url 请求地址
     * @param array $post_data post键值对数据
     * @return string
     */
    private function http_request($url, $post_data, $headers)
    {
        $postdata = http_build_query($post_data);
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => $headers,
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

//        echo $result;

        return $result;
    }

    //构造参数体
    private function getBody($appid, $question)
    {
        $header = [
            'app_id' => $appid,
            'uid' => '12345'
        ];

        $parameter = [
            'chat' => [
                'domain' => 'generalv3.5',
                'temperature' => 0.5,
                'max_tokens' => 1024
            ]
        ];

        $payload = [
            'message' => [
                'text' => [
                    // 需要联系上下文时，要按照下面的方式上传历史对话
                    // [role' => 'user', 'content' => '你是谁'],
                    // [role' => 'assistant', 'content' => '.....'],
                    // ...省略的历史对话
                    ['role' => 'user', 'content' => $question]
                ]
            ]
        ];

        $json_string = json_encode([
            'header' => $header,
            'parameter' => $parameter,
            'payload' => $payload
        ]);

        return $json_string;

    }

    //鉴权方法
    private function assembleAuthUrl($method, $addr, $apiKey, $apiSecret)
    {
        if ($apiKey == "" && $apiSecret == "") { // 不鉴权
            return $addr;
        }

        $ul = parse_url($addr); // 解析地址
        if ($ul === false) { // 地址不对，也不鉴权
            return $addr;
        }

        // // $date = date(DATE_RFC1123); // 获取当前时间并格式化为RFC1123格式的字符串
        $timestamp = time();
        $rfc1123_format = gmdate('D, d M Y H:i:s \G\M\T', $timestamp);
        // $rfc1123_format = "Mon, 31 Jul 2023 08:24:03 GMT";


        // 参与签名的字段 host, date, request-line
        $signString = [
            'host: ' . $ul['host'],
            'date: ' . $rfc1123_format,
            $method . ' ' . $ul['path'] . ' HTTP/1.1'
        ];

        // 对签名字符串进行排序，确保顺序一致
        ksort($signString);

        // 将签名字符串拼接成一个字符串
        $sgin = implode("\n", $signString);
//        print($sgin);

        // 对签名字符串进行HMAC-SHA256加密，得到签名结果
        $sha = hash_hmac('sha256', $sgin, $apiSecret, true);
//        print("signature_sha:\n");
//        print($sha);
        $signature_sha_base64 = base64_encode($sha);

        // 将API密钥、算法、头部信息和签名结果拼接成一个授权URL
        $authUrl = "api_key=\"$apiKey\", algorithm=\"hmac-sha256\", headers=\"host date request-line\", signature=\"$signature_sha_base64\"";

        // 对授权URL进行Base64编码，并添加到原始地址后面作为查询参数
        $authAddr = $addr . '?' . http_build_query([
                'host' => $ul['host'],
                'date' => $rfc1123_format,
                'authorization' => base64_encode($authUrl),
            ]);

        return $authAddr;
    }
}
