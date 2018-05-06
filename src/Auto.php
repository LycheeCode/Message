<?php

/**
 * 自动识别消息类型类
 * 
 * @package Lychee\Message
 * @author Y!an <i@yian.me>
 */

namespace Lychee\Message;

use \DOMDocument;

class Auto
{
    /**
     * 初始化消息并取得相应消息类实例
     *
     * @param string $xml
     * @return mixed
     */
    public static function init(string $xml)
    {
        /**
         * 普通消息列表
         */
        $typeList = [
            "image", "link", "location", "music", "news", "shortvideo", "text", "video", "voice"
        ];

        /**
         * 事件消息列表
         */
        $eventList = [
            "click", "location", "scan", "subscribe", "unsubscribe", "view"
        ];

        $doc = new DOMDocument;
        $doc->loadXML($xml);

        $msgType = $doc->getElementsByTagName("MsgType");
        if (! $msgType->length)
        {
            throw new \Exception("Invalid msg");
        }
        $msgType = $msgType->item(0)->nodeValue;

        $className = "Lychee\\Message\\";

        if ($msgType == "event")
        {
            $event = $doc->getElementsByTagName("Event");
            if (! $event->length)
            {
                throw new \Exception("Invalid msg");
            }
            $event = $event->item(0)->nodeValue;
            if (in_array($event, $eventList))
            {
                $className .= "Event\\" . ucfirst($event);
                return new $className($xml);
            }
            throw new \Exception("Invalid msg");
        }
        else
        {
            if (in_array($msgType, $typeList))
            {
                if ($msgType == "shortvideo")
                {
                    $className .= "ShortVideo";
                }
                else
                {
                    $className .= ucfirst($msgType);
                }
                return new $className($xml);
            }
            throw new \Exception("Invalid msg");
        }
    }
}