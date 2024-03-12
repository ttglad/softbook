<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class GeminiService extends Service
{
    const GEMINI_URL = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent';

    public function getMessage($question)
    {

        //url$
        $url = self::GEMINI_URL . '?key=' . env('GOOGLE_GEMINI_KEY');

        //请求数据
        $data = [
            'contents' => [
                'parts' => [
                    'text' => $question
                ]
            ]
        ];

        Log::info('gemini -- question: ' . $question);

        //post请求
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        // 设置请求头
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if (!empty($data)) { //判断是否为POST请求
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
//        Log::info('gemini -- data: ' . $response);
        $res = json_decode($response, true);
        curl_close($curl);

        return $res['candidates'][0]['content']['parts'][0]['text'];
    }
}
