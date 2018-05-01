<?php

/**
 * 取消关注事件消息类
 * 
 * @package Lychee\Message\Event
 * @author Y!an <i@yian.me>
 */

namespace Lychee\Message\Event;

class Unsubscribe extends Base
{
    /**
     * 检验属性完整性
     *
     * @return boolean
     */
    protected function validateProperties(array $tree): bool
    {
        return true;
    }
}