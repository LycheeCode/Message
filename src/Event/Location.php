<?php

/**
 * 上报地理位置事件消息类
 * 
 * @package Lychee\Message\Event
 * @author Y!an <i@yian.me>
 */

namespace Lychee\Message\Event;

class Location extends Base
{
    /**
     * 检验属性完整性
     *
     * @return boolean
     */
    protected function validateProperties(array $tree): bool
    {
        $validateList = [
            "Latitude",
            "Longitude",
            "Precision",
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
     * 设置地理位置纬度
     *
     * @param string $latitude
     * @return self
     */
    public function setLatitude(string $latitude)
    {
        $this->properties["Latitude"] = $latitude;
        return $this;
    }

    /**
     * 设置地理位置经度
     *
     * @param string $longitude
     * @return self
     */
    public function setLongitude(string $longitude)
    {
        $this->properties["Longitude"] = $longitude;
        return $this;
    }

    /**
     * 设置地理位置精度
     *
     * @param string $precision
     * @return self
     */
    public function setPrecision(string $precision)
    {
        $this->properties["Precision"] = $precision;
        return $this;
    }
}