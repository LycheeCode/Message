<?php

/**
 * 音乐消息类
 * 
 * @package Lychee\Message
 * @author Y!an <i@yian.me>
 */

namespace Lychee\Message;

use Lychee\Message\Base;

class Music extends Base
{
    /**
     * 消息类型
     *
     * @var string
     */
    protected $msgtype = "music";

    /**
     * 检验属性完整性
     *
     * @return boolean
     */
    protected function validateProperties(): bool
    {
        if (! isset($this->properties['ThumbMediaId']))
        {
            return false;
        }
        return true;
    }

    /**
     * 设置音乐标题
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
     * 设置音乐描述
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
     * 设置封面图 media id
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

    /**
     * 设置音乐 URL
     *
     * @param string $picUrl
     * @return self
     */
    public function setMusicUrl(string $MusicUrl)
    {
        $this->properties["MusicUrl"] = [
            "type"  => "CDATA",
            "value" => $MusicUrl,
        ];
        return $this;
    }
    
    /**
     * 设置高质量音乐 URL
     *
     * @param string $picUrl
     * @return self
     */
    public function setHQMusicUrl(string $HQMusicUrl)
    {
        $this->properties["HQMusicUrl"] = [
            "type"  => "CDATA",
            "value" => $HQMusicUrl,
        ];
        return $this;
    }
}