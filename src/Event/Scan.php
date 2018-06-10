<?php

/**
 * 扫描带参二维码事件消息类
 * 
 * @package Lychee\Message\Event
 * @author Y!an <i@yian.me>
 */

namespace Lychee\Message\Event;

class Scan extends Base
{
    /**
     * 事件类型
     *
     * @var string
     */
    protected $Event = "SCAN";

    /**
     * 检验属性完整性
     *
     * @return boolean
     */
    protected function validateProperties(array $tree): bool
    {
        $validateList = [
            "EventKey",
            "Ticket",
        ];
        foreach ($validateList as $property)
        {
            if (isset($tree[$property]))
            {
                $this->properties[$property] = $tree[$property];
            }
            
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

    /**
     * 获取 EventKey
     *
     * @return string
     */
    public function getEventKey(): string
    {
        return isset($this->properties["EveentKey"]) ? $this->properties["EventKey"] : "";
    }

    /**
     * 设置 Ticket
     *
     * @param string $ticket
     * @return self
     */
    public function setTicket(string $ticket)
    {
        $this->properties["Ticket"] = $ticket;
        return $this;
    }
}