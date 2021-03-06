<?php
/**
 * @author: helei
 * @createTime: 2016-07-15 17:28
 * @description: 支付宝相关数据的基类
 * @link      https://github.com/helei112g/payment/tree/paymentv2
 * @link      https://helei112g.github.io/
 */

namespace Payment\Common\Ali\Data;

use Payment\Common\AliConfig;
use Payment\Common\BaseData;
use Payment\Common\PayException;
use Payment\Utils\ArrayUtil;
use Payment\Utils\RsaEncrypt;

/**
 * Class BaseData
 *
 * @property string $getewayUrl  支付宝网关
 * @property string $appId   支付宝分配给开发者的应用ID
 * @property string $method  接口名称
 * @property string $format  	仅支持JSON
 * @property string $returnUrl  	HTTP/HTTPS开头字符串
 * @property string $charset  请求使用的编码格式，如utf-8,gbk,gb2312等 当前仅支持  utf-8
 * @property string $signType  加密方式。默认rsa
 * @property string $timestamp  发送请求的时间，格式"yyyy-MM-dd HH:mm:ss"
 * @property string $version   调用的接口版本，固定为：1.0
 * @property string $notifyUrl  支付宝服务器主动通知商户服务器里指定的页面http/https路径
 * @property string $limitPay   用户不可用指定渠道支付
 * @property boolean $return_raw  是否返回原始数据，只进行签名检查
 *
 * @property string $rsaPrivatePath  rsa私钥路径
 * @property string $rsaAliPubPath  rsa支付宝公钥路径
 *
 * @property string $partner  合作id
 * @property string $account  卖家支付宝账号，手机号或者邮箱
 * @property string $account_name  卖家支付宝昵称
 *
 * @package Payment\Charge\Ali\Data
 * anthor helei
 */
abstract class AliBaseData extends BaseData
{

    public function getData()
    {
        $data = parent::getData();

        // 新版需要对数据进行排序
        $data = ArrayUtil::arraySort($data);
        return $data;
    }

    /**
     * 签名算法实现
     * @param string $signStr
     * @return string
     * @author helei
     */
    protected function makeSign($signStr)
    {
        $sign = '';
        switch ($this->signType) {
            case 'RSA':
                $rsaPrivatePath = @file_get_contents($this->rsaPrivatePath);
                $rsa = new RsaEncrypt($rsaPrivatePath);

                $sign = $rsa->encrypt($signStr);
                break;
            case 'RSA2':
                // @TODO
                break;
            default:
                $sign = '';
        }

        return $sign;
    }
}
