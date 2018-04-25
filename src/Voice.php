<?php

/**
 * 语音消息类
 * 
 * @package Lychee\Message
 * @author Y!an <i@yian.me>
 */

namespace Lychee\Message;

use Lychee\Message\Base;

class Voice extends Base
{
    /**
     * 消息类型
     *
     * @var string
     */
    protected $msgtype = "voice";

    /**
     * 检验属性完整性
     *
     * @return boolean
     */
    protected function validateProperties(): bool
    {
        $validateList = [
            "MediaId",
        ];
        foreach ($validateList as $property)
        {
            if (! isset($this->properties[$property]))
            {
                return false;
            }
        }
        return true;
    }

    /**
     * 设置语音 media id
     *
     * @param string $mediaId
     * @return self
     */
    public function setMediaId(string $mediaId)
    {
        $this->properties["MediaId"] = [
            "type"  => "CDATA",
            "value" => $mediaId,
        ];
        return $this;
    }

    /**
     * 设置语音文件格式
     *
     * @param string $format
     * @return self
     */
    public function setFormat(string $format)
    {
        $this->properties["Format"] = [
            "type"  => "CDATA",
            "value" => $format,
        ];
        return $this;
    }

    /**
     * 设置语音识别结果，开通语音识别功能后每次推送的消息中会有此项
     *
     * @param string $recognition
     * @return self
     */
    public function setRecognition(string $recognition)
    {
        $this->properties["Recognition"] = [
            "type"  => "CDATA",
            "value" => $recognition,
        ];
        return $this;
    }
}