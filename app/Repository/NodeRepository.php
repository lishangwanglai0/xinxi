<?php
/**
 * Created by PhpStorm.
 * User: lx
 * Date: 2020/3/12
 * Time: 14:10
 */

namespace App\Repository;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
class NodeRepository
{
    const SIGNNAME="星智汇";
    const REGIONID="cn-hangzhou";
    const TEMPLATECODE="SMS_175340389";
    const ACCESSKEYID="LTAI4FjBUynZZR7aZAQ7aqDm";
    const ACCESSKEYSECRET="ELAP1aga7fM2N5TrnECD5lckp5V2k1";

    // Download：https://github.com/aliyun/openapi-sdk-php
    // Usage：https://github.com/aliyun/openapi-sdk-php/blob/master/README.md
    /**
     * 短信验证码
     * @param $phone
     * @param $code
     * @return string
     * @throws ClientException
     * @author guoyang
     * @date 2020/3/12  16:22
     */
    public function sendNode($phone,$code)
    {
        AlibabaCloud::accessKeyClient(NodeRepository::ACCESSKEYID, NodeRepository::ACCESSKEYSECRET)
            ->regionId('cn-hangzhou')
            ->asDefaultClient();
        $code=json_encode(['code'=>$code]);
        $query=[
            'RegionId' => NodeRepository::REGIONID,
            'PhoneNumbers' => $phone,
            'SignName' => NodeRepository::SIGNNAME,
            'TemplateCode' => NodeRepository::TEMPLATECODE,
            'TemplateParam'=>$code
        ];
        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => $query,
                ])
                ->request();
            return $result->toArray();
        } catch (ClientException $e) {
            return  $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            return $e->getErrorMessage() . PHP_EOL;
        }

    }
}