<?php

/**
 * 视频消息类
 * 
 * @package Lychee\Message
 * @author Y!an <i@yian.me>
 */

namespace Lychee\Message;

use Lychee\Message\Base;

class Video extends Base
{
    /**
     * 消息类型
     *
     * @var string
     */
    protected $msgtype = "video";

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
     * 设置视频 media id
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
     * 设置视频标题，可选
     *
     * @param string $title
     * @return self
     */
    public function setTitle(string $title)
    {
        $this->properties["Title"] = [
            "type"  => "CDATA",
            "value" => $title,
        ];
        return $this;
    }

    /**
     * 设置视频描述，可选
     *
     * @param string $description
     * @return self
     */
    public function setDescription(string $description)
    {
        $this->properties["Description"] = [
            "type"  => "CDATA",
            "value" => $description,
        ];
        return $this;
    }

    /**
     * 设置视频消息缩略图的 media id，接收消息时才会有此项
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