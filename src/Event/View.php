<?php

/**
 * 点击菜单（链接）事件消息类
 * 
 * @package Lychee\Message\Event
 * @author Y!an <i@yian.me>
 */

namespace Lychee\Message\Event;

class View extends Base
{
    /**
     * 事件类型
     *
     * @var string
     */
    protected $Event = "VIEW";

    /**
     * 检验属性完整性
     *
     * @return boolean
     */
    protected function validateProperties(array $tree): bool
    {
        $validateList = [
            "EventKey",
        ];
        foreach ($validateList as $property)
        {
            if (! isset($tree[$property]))
            {
                return false;
            }
            $this->properties[$property] = $tree[$property];
        }
        return true;
    }

    /**
     * 设置 EventKey
     *
     * @param string $eventKey
     * @return self
     */
    public function setEventKey(string $eventKey)
    {
        $this->properties["EventKey"] = $eventKey;
        return $this;
    }
}