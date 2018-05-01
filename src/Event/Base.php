<?php

/**
 * 事件消息类基类
 * 
 * @package Lychee\Message\Event
 * @author Y!an <i@yian.me>
 */

namespace Lychee\Message\Event;

abstract class Base extends \Lychee\Message\Base
{
    /**
     * 消息类型
     *
     * @var string
     */
    protected $MsgType = "event";
}