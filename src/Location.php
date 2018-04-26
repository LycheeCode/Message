<?php

/**
 * 地理位置消息类
 * 
 * @package Lychee\Message
 * @author Y!an <i@yian.me>
 */

namespace Lychee\Message;

use Lychee\Message\Base;

class Location extends Base
{
    /**
     * 消息类型
     *
     * @var string
     */
    protected $MsgType = "location";

    /**
     * 检验属性完整性
     *
     * @param array $tree
     * @return boolean
     */
    protected function validateProperties(array $tree): bool
    {
        $validateList = [
            "Location_X",
            "Location_Y",
            "Scale",
            "Label"
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
     * 设置纬度
     *
     * @param float $x
     * @return self
     */
    public function setLocationX(float $x)
    {
        $this->properties["Location_X"] = $x;
        return $this;
    }
    
    /**
     * 设置精度
     *
     * @param float $y
     * @return self
     */
    public function setLocationY(float $y)
    {
        $this->properties["Location_Y"] = $y;
        return $this;
    }

    /**
     * 设置缩放大小
     *
     * @param integer $scale
     * @return self
     */
    public function setScale(int $scale)
    {
        $this->properties["Scale"] = $scale;
        return $this;
    }

    /**
     * 设置地理位置信息
     *
     * @param string $label
     * @return self
     */
    public function setLabel(string $label)
    {
        $this->properties["Label"] = $label;
        return $this;
    }
}