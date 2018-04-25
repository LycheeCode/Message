<?php

/**
 * 消息加解密类
 * 
 * @package Lychee\Message
 * @author Y!an <i@yian.me>
 */

namespace Lychee\Message;

use \DOMDocument;

class Encryptor
{
    /**
     * 公众号 appid
     *
     * @var string
     */
    private $appid;

    /**
     * 消息验证 token
     *
     * @var string
     */
    private $token;

    /**
     * 消息加解密密钥
     *
     * @var string
     */
    private $key;

    public function __construct(string $appid, string $token, string $key)
    {
        $this->appid = $appid;
        $this->token = $token;
        $this->key = base64_decode($key . "=", true);
    }

    /**
     * 加密 xml 数据
     *
     * @param string $xml
     * 
     * @return string
     * 
     * @throws Exception
     */
    public function encrypt(string $xml): string
    {
        try
        {
            $xml = $this->pkcs7Pad($this->randStr().pack('N', strlen($xml)).$xml.$this->appid, 32);

            $iv = substr($this->key, 0, 16);
            $Encrypt = openssl_encrypt($xml, "AES-256-CBC", $this->key, OPENSSL_ZERO_PADDING, $iv);
        }
        catch (\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
        $TimeStamp = time();
        $Nonce = $this->randStr();
        $MsgSignature = $this->sign($Encrypt, $this->token, $TimeStamp, $Nonce);
        $xml = new DOMDocument;
        $msgBody = $xml->createElement("xml");
        $encryptNode = $xml->createElement("Encrypt");
        $encryptNode->appendChild($msgBody->ownerDocument->createCDATASection($Encrypt));
        $msgBody->appendChild($encryptNode);
        $msgBody->appendChild($xml->createElement("MsgSignature", $MsgSignature));
        $msgBody->appendChild($xml->createElement("TimeStamp", $TimeStamp));
        $msgBody->appendChild($xml->createElement("Nonce", $Nonce));
        $xml->formatOutput = true;
        return $xml->saveXML($msgBody);
    }

    /**
     * 解密 xml 数据
     *
     * @param string $rawXMLData
     * @param string $sign
     * @param string $timestamp
     * @param string $nonce
     * 
     * @return string
     * 
     * @throws Exception
     */
    public function decrypt(string $rawXMLData, string $sign, string $timestamp, string $nonce): string
    {
        $xml = new DOMDocument;
        $xml->loadXML($rawXMLData);
        $encrypt = $xml->getElementsByTagName("Encrypt");
        if (! $encrypt->length)
        {
            throw new \Exception("Invalid data");
        }
        $encrypt = $encrypt->item(0)->nodeValue;
        
        if ($this->sign($this->token, $encrypt, $timestamp, $nonce) != $sign)
        {
            throw new \Exception("Invalid Sign");
        }

        $iv = substr($this->key, 0, 16);
        $decrypt = openssl_decrypt($encrypt, "AES-256-CBC", $this->key, OPENSSL_ZERO_PADDING, $iv);

        $result = $this->pkcs7Unpad($decrypt);
        $content = substr($result, 16, strlen($result));
        $contentLen = unpack('N', substr($content, 0, 4))[1];

        if (trim(substr($content, $contentLen + 4)) !== $this->appid)
        {
            throw new \Exception('Invalid appid');
        }

        return substr($content, 4, $contentLen);
    }

    /**
     * PKCS#7 pad.
     *
     * @param string $text
     * @param int    $blockSize
     *
     * @return string
     *
     * @throws Exception
     */
    public function pkcs7Pad(string $text, int $blockSize): string
    {
        if ($blockSize > 256)
        {
            throw new Exception('$blockSize may not be more than 256');
        }
        $padding = $blockSize - (strlen($text) % $blockSize);
        $pattern = chr($padding);

        return $text.str_repeat($pattern, $padding);
    }

    /**
     * PKCS#7 unpad.
     *
     * @param string $text
     *
     * @return string
     */
    public function pkcs7Unpad(string $text): string
    {
        $pad = ord(substr($text, -1));
        if ($pad < 1 || $pad > 32)
        {
            $pad = 0;
        }

        return substr($text, 0, (strlen($text) - $pad));
    }

    /**
     * 生成签名
     *
     * @return string
     */
    public function sign(): string
    {
        $datas = func_get_args();
        sort($datas, SORT_STRING);

        return sha1(implode($datas));
    }

    /**
     * 生成随机字符串
     *
     * @param int $length
     * @return string
     */
    private function randStr(int $length = 16): string
    {
        $dict = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456798";
        $str = "";
        for ($i = 0; $i < $length; $i++)
        {
            $str .= $dict[mt_rand(0, strlen($dict) - 1)];
        }
        return $str;
    }
}