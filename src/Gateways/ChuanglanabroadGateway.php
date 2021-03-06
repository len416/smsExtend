<?php
namespace Len\SmsExtend\Gateways;

use Len\SmsExtend\Gateways\Gateway;

/**
 * 253云通讯(创蓝)国际网关
 *
 * @authors chenfeng (wangchenfeng@xdqcjy.com)
 * @date    2018-06-20 10:52:51
 * @version V1
 */
class ChuanglanabroadGateway extends Gateway
{
    /**
     * 网关地址
     *
     * @var string
     */
    protected $gatewayUrl = 'http://intapi.253.com/send/json';

    /**
     * 发送
     *
     * @author chenfeng (wangchenfeng@xdqcjy.com)
     * @date  2018-06-20
     * @param string $mobilePhone 手机号码
     * @param string $message 发送内容
     * @return array
     */
    public function send(string $mobilePhone, string $message)
    {
        $clientData = [
            "msg"   => $message, //短信内容。长度不能超过536个字符
            "mobile" => $mobilePhone, //手机号码。多个手机号码使用英文逗号分隔
        ];

        //组装数据
        $clientData = array_merge($clientData, $this->getGatewayConfig());

        //发送请求
        $result = $this->postJson($this->gatewayUrl, $clientData);
        if (empty($result)) {
            return $this->responseData(400, "sms send faile");
        }

        $code = intval($result['code']);
        $msg  = !$code ? 'success' : $result['error'];
        unset($result['code']);
        return $this->responseData($code, $msg, $result);
    }
}


