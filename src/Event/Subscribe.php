<?php

/**
 * 关注事件消息类
 * 
 * @package Lychee\Message\Event
 * @author Y!an <i@yian.me>
 */

namespace Lychee\Message\Event;

class Subscribe extends Base
{
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
        $this->properties["EventKey"] = "qrscene_" . $eventKey;
        return $this;
    }

    /**
     * 获取去除 qrscene_ 前缀后的 EventKey
     *
     * @return string
     */
    public function getEventKey(): string
    {
        return substr($this->properties["EventKey"], strlen("qrscene_"));
    }

    /**
     * 获取原始 EventKey
     *
     * @return string
     */
    public function getRawEventKey(): string
    {
        return isset($this->properties["EveentKey"]) ? $this->properties["EventKey"] : "";
    }

    /**
     * 获取 Ticket
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