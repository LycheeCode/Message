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
    protected $MsgType = "music";

    /**
     * 检验属性完整性
     *
     * @param array $tree
     * @return boolean
     */
    protected function validateProperties(array $tree): bool
    {
        $validateList = [
            "ThumbMediaId",
        ];
        foreach ($validateList as $property)
        {
            if (! isset($tree[$property]))
            {
                return false;
            }
            $this->properties[$property] = $tree[$property];
        }
        // TODO: 设置可选属性
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
        $this->properties["Title"] = $title;
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
        $this->properties["Description"] = $description;
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
        $this->properties["ThumbMediaId"] = $thumbMediaId;
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
        $this->properties["MusicUrl"] = $MusicUrl;
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
        $this->properties["HQMusicUrl"] = $HQMusicUrl;
        return $this;
    }
}