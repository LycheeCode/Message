<?php

/**
 * 文字消息类
 * 
 * @package Lychee\Message
 * @author Y!an <i@yian.me>
 */

namespace Lychee\Message;

use Lychee\Message\Base;

class Text extends Base
{
    /**
     * 消息类型
     *
     * @var string
     */
    protected $msgtype = "text";

    /**
     * 检验属性完整性
     *
     * @return boolean
     */
    protected function validateProperties(): bool
    {
        if (! isset($this->properties['Content']))
        {
            return false;
        }
        return true;
    }

    /**
     * 设置消息内容
     *
     * @param string $text
     * @return self
     */
    public function setContent(string $text)
    {
        $this->properties['Content'] = [
            "type"  => "CDATA",
            "value" => $text,
        ];
        return $this;
    }
}