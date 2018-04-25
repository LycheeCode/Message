<?php

/**
 * 小视频消息类
 * 
 * @package Lychee\Message
 * @author Y!an <i@yian.me>
 */

namespace Lychee\Message;

use Lychee\Message\Base;

class ShortVideo extends Base
{
    /**
     * 消息类型
     *
     * @var string
     */
    protected $msgtype = "shortvideo";

    /**
     * 检验属性完整性
     *
     * @return boolean
     */
    protected function validateProperties(): bool
    {
        $validateList = [
            "MediaId",
            "ThumbMediaId"
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
     * 设置小视频 media id
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
     * 设置小视频消息缩略图的 media id
     *
     * @param string $thumbMediaId
     * @return self
     */
    public function setThumbMediaId(string $thumbMediaId)
    {
        $this->properties["ThumbMediaId"] = [
            "type"  => "CDATA",
            "value" => $thumbMediaId,
        ];
        return $this;
    }
}