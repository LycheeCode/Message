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
    protected $MsgType = "voice";

    /**
     * 检验属性完整性
     *
     * @param array $tree
     * @return boolean
     */
    protected function validateProperties(array $tree): bool
    {
        $validateList = [
            "MediaId",
        ];
        foreach ($validateList as $property) {
            if (! isset($tree[$property])) {
                return false;
            }
            $this->properties[$property] = $tree[$property];
        }
        // TODO: 设置可选属性
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
        $this->properties["MediaId"] = $mediaId;
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
        $this->properties["Format"] = $format;
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
        $this->properties["Recognition"] = $recognition;
        return $this;
    }
}
