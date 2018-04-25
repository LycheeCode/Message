<?php

/**
 * 图片消息类
 * 
 * @package Lychee\Message
 * @author Y!an <i@yian.me>
 */

namespace Lychee\Message;

use Lychee\Message\Base;

class Image extends Base
{
    /**
     * 消息类型
     *
     * @var string
     */
    protected $msgtype = "image";

    /**
     * 检验属性完整性
     *
     * @return boolean
     */
    protected function validateProperties(): bool
    {
        if (! isset($this->properties['MediaId']))
        {
            return false;
        }
        return true;
    }

    /**
     * 设置图片 media id
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
     * 设置图片 URL
     *
     * @param string $picUrl
     * @return self
     */
    public function setPicUrl(string $picUrl)
    {
        $this->properties["PicUrl"] = [
            "type"  => "CDATA",
            "value" => $picUrl,
        ];
        return $this;
    }
}