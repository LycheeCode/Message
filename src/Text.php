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
    protected $MsgType = "text";

    /**
     * 检验属性完整性
     *
     * @param array $tree
     * @return boolean
     */
    protected function validateProperties(array $tree): bool
    {
        $validateList = [
            "Content",
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
     * 设置消息内容
     *
     * @param string $text
     * @return self
     */
    public function setContent(string $text)
    {
        $this->properties['Content'] = $text;
        return $this;
    }
}
