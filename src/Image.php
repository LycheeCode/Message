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
    protected $MsgType = "image";

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
     * 设置图片 media id
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
     * 设置图片 URL
     *
     * @param string $picUrl
     * @return self
     */
    public function setPicUrl(string $picUrl)
    {
        $this->properties["PicUrl"] = $picUrl;
        return $this;
    }
}