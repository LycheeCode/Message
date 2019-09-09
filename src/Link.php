<?php

/**
 * 链接消息类
 *
 * @package Lychee\Message
 * @author Y!an <i@yian.me>
 */

namespace Lychee\Message;

use Lychee\Message\Base;

class Link extends Base
{
    /**
     * 消息类型
     *
     * @var string
     */
    protected $MsgType = "link";

    /**
     * 检验属性完整性
     *
     * @param array $tree
     * @return boolean
     */
    protected function validateProperties(array $tree): bool
    {
        $validateList = [
            "Title",
            "Description",
            "Url",
        ];
        foreach ($validateList as $property) {
            if (! isset($tree[$property])) {
                return false;
            }
            $this->properties[$property] = $tree[$property];
        }
        return true;
    }

    /**
     * 设置链接标题
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
     * 设置链接描述
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
     * 设置链接 url
     *
     * @param string $url
     * @return self
     */
    public function setUrl(string $url)
    {
        $this->properties["Url"] = $url;
        return $this;
    }
}
