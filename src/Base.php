<?php

/**
 * 消息类基类
 * 
 * @package Lychee\Message
 * @author Y!an <i@yian.me>
 */

namespace Lychee\Message;

use \DOMDocument;

abstract class Base
{
    /**
     * 消息接收者
     *
     * @var string
     */
    protected $ToUserName;

    /**
     * 消息发送者
     *
     * @var string
     */
    protected $FromUserName;

    /**
     * 消息创建时间，UNIX 时间戳
     *
     * @var int
     */
    protected $CreateTime;

    /**
     * 消息类型
     *
     * @var string
     */
    protected $MsgType;

    /**
     * 消息 id，64 位整型
     *
     * @var int
     */
    protected $MsgId;

    /**
     * 消息属性
     *
     * @var array
     */
    protected $properties = [];

    /**
     * Message constructor
     *
     * @param string $xml
     */
    public function __construct(string $xml = "")
    {
        // 子类继承基类时必须指定 $this->msgtype 的值
        if (is_null($this->msgtype))
        {
            throw new \Exception("Message type can not be null");
        }

        // 创建一个空的消息类
        if ($xml == "")
        {
            return;
        }

        // 从 XML 中创建一个消息类
        $msgTree = $this->fromXML($xml);

        if (! $this->validateProperties($msgTree))
        {
            throw new \Exception("Validate properties failed");
        }
    }

    /**
     * 检验属性完整性
     *
     * @return boolean
     */
    abstract protected function validateProperties(array $tree): bool;

    public function fromXML(string $xml): array
    {
        $doc = new DOMDocument;
        $doc->loadXML($xml);
        $msg = $doc->getElementsByTagName("xml");
        if (! $msg->length)
        {
            throw new Exception("Invalid msg");
        }
        $msg = $msg->item(0);
        $msgTree = $this->traverseXML($msg);
        if (! isset($msgTree['MsgType'])
         || $msgTree['MsgType'] != $this->MsgType)
        {
            throw new \Exception("Invalid message type");
        }
        if (! isset($msgTree['FromUserName'])
         || ! isset($msgTree['ToUserName'])
         || ! isset($msgTree['CreateTime']))
        {
            throw new \Exception("Invalid message");
        }
        $this->FromUserName = $msgTree['FromUserName'];
        $this->ToUserName = $msgTree['ToUserName'];
        $this->CreateTime = $msgTree['CreateTime'];
        $this->MsgId = isset($msgTree['MsgId']) ? $msgTree['MsgId'] : null;
        if ($this->MsgType == 'event')
        {
            $this->Event = $msgTree['Event'];
        }

        return $msgTree;
    }

    /**
     * 将 message model 转换成 XML 字符串
     *
     * @return string
     */
    public function toXML(): string
    {
        if (! $this->validateProperties($this->properties))
        {
            throw new \Exception("Validate properties failed");
        }
        $base = [
            "ToUserName" => $this->ToUserName,
            "FromUserName" => $this->FromUserName,
            "CreateTime" => $this->CreateTime,
            "MsgType" => $this->MsgType,
        ];
        if (! is_null($this->MsgId))
        {
            $base["MsgId"] = $this->MsgId;
        }
        if ($this->MsgType == "event")
        {
            $base["Event"] = $this->Event;
        }
        $datas = $base + $this->properties;
        
        $dom = new DOMDocument;
        $xmlBody = $this->buildXML($datas, "xml", $dom);
        return $dom->saveXML($xmlBody);
    }

    private function traverseXML(\DOMElement $element): array
    {
        $tree = [];
        
        foreach ($element->childNodes as $node)
        {
            if (! $node->hasChildNodes())
            {
                continue;
            }
            foreach ($node->childNodes as $childElement)
            {
                if ($childElement->hasChildNodes())
                {
                    $tree[$node->nodeName][] = $this->traverseXML($childElement);
                    continue;
                }
                $tree[$node->nodeName] = $childElement->nodeValue;

            } // foreach ($node->childNodes as $childElement)
        }

        return $tree;
    }

    /**
     * 遍历数组，生成 XML Node
     *
     * @param array $datas
     * @return \DOMNode
     */
    private function buildXML(array $datas, string $elementName, \DOMDocument $dom = null): \DOMNode
    {
        if (is_null($dom))
        {
            $dom = new \DOMDocument;
        }
        $xmlBody = $dom->createElement($elementName);
        foreach ($datas as $name => $dataProperties)
        {
            if (is_array($dataProperties))
            {
                if (is_numeric($name))
                {
                    $name = "item";
                }
                $node = $dom->createElement($name);
                foreach ($dataProperties as $n => $property)
                {
                    if (is_numeric($n))
                    {
                        $n = "item";
                    }
                    $child = $this->buildXML($property, $n, $dom);
                    $node->appendChild($child);
                }
            }
            else if (is_numeric($dataProperties))
            {
                $node = $dom->createElement($name, $dataProperties);
            }
            else
            {
                $node = $dom->createElement($name);
                $nodeValue = $xmlBody->ownerDocument->createCDATASection($dataProperties);
                $node->appendChild($nodeValue);
            }
            $xmlBody->appendChild($node);
        }
        return $xmlBody;
    }

    /**
     * 设置消息接收者
     *
     * @param string $value
     * @return self
     */
    public function setToUserName(string $value)
    {
        $this->ToUserName = $value;
        return $this;
    }

    /**
     * 设置消息发送者
     *
     * @param string $value
     * @return self
     */
    public function setFromUserName(string $value)
    {
        $this->FromUserName = $value;
        return $this;
    }

    /**
     * 设置消息时间
     *
     * @param integer $value
     * @return self
     */
    public function setCreateTime(int $value)
    {
        $this->CreateTime = $value;
        return $this;
    }

    /**
     * 设置消息 ID
     *
     * @param integer $value
     * @return self
     */
    public function setMsgId(int $value)
    {
        $this->MsgId = $value;
        return $this;
    }

    public function __get(string $name)
    {
        if (in_array($name, ["ToUserName", "FromUserName", "CreateTime", "MsgType", "MsgId"]))
        {
            return $this->$name;
        }
        return isset($this->properties[$name]) ? $this->properties[$name] : false;
    }
}