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
    protected $tousername;

    /**
     * 消息发送者
     *
     * @var string
     */
    protected $fromusername;

    /**
     * 消息创建时间，UNIX 时间戳
     *
     * @var int
     */
    protected $createtime;

    /**
     * 消息类型
     *
     * @var string
     */
    protected $msgtype;

    /**
     * 消息 id，64 位整型
     *
     * @var int
     */
    protected $msgid;

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
        $doc = new DOMDocument;
        $doc->loadXML($xml);
        $msg = $doc->getElementsByTagName("xml");
        if (! $msg->length)
        {
            throw new Exception("Invalid msg");
        }
        $msg = $msg->item(0);
        foreach ($msg->childNodes as $msgItem)
        {
            if (! $msgItem->hasChildNodes())
            {
                continue;
            }
            foreach ($msgItem->childNodes as $msgValue)
            {
                if (strtolower($msgItem->nodeName) == "msgtype")
                {
                    if ($msgValue->nodeValue != $this->msgtype)
                    {
                        throw new \Exception("Invalid message type");
                    }
                    continue;
                }

                if ( in_array(
                        strtolower($msgItem->nodeName),
                        [
                            "createtime",
                            "fromusername",
                            "tousername",
                            "msgid"
                        ])
                    )
                {
                    $baseProperty = strtolower($msgItem->nodeName);
                    $this->$baseProperty = $msgValue->nodeValue;
                }

                if ($msgValue->nodeType == XML_CDATA_SECTION_NODE)
                {
                    $this->properties[$msgItem->nodeName] = [
                        "type"  => "CDATA",
                        "value" => $msgValue->nodeValue
                    ];
                }
                else
                {
                    $this->properties[$msgItem->nodeName] = [
                        "type"  => "NORMAL",
                        "value" => $msgValue->nodeValue
                    ];
                }

            } // foreach ($msgItem->childNodes as $msgValue)
        }

        if (! $this->validateProperties())
        {
            throw new \Exception("Validate properties failed");
        }
    }

    /**
     * 检验属性完整性
     *
     * @return boolean
     */
    abstract protected function validateProperties(): bool;

    /**
     * 将 message model 转换成 XML 字符串
     *
     * @return string
     */
    public function toXML(): string
    {
        if (! $this->validateProperties())
        {
            throw new \Exception("Validate properties failed");
        }
        $base = [
            "ToUserName" => [
                "type"  => "CDATA",
                "value" => $this->tousername,
            ],
            "FromUserName" => [
                "type"  => "CDATA",
                "value" => $this->fromusername,
            ],
            "CreateTime" => [
                "type"  => "NORMAL",
                "value" => $this->createtime,
            ],
            "MsgType" => [
                "type"  => "CDATA",
                "value" => $this->msgtype,
            ],
        ];
        if (! is_null($this->msgid))
        {
            $base["MsgId"] = [
                "type"  => "NORMAL",
                "value" => $this->msgid,
            ];
        }
        $datas = $base + $this->properties;
        return $this->buildXML($datas);
    }

    /**
     * 遍历数组，生成 XML
     *
     * @param array $datas
     * @return string
     */
    private function buildXML(array $datas): string
    {
        $dom = new DOMDocument;
        $xmlBody = $dom->createElement("xml");
        foreach ($datas as $name => $dataProperties)
        {
            if ($dataProperties["type"] == "CDATA")
            {
                $node = $dom->createElement($name);
                $nodeValue = $xmlBody->ownerDocument->createCDATASection($dataProperties["value"]);
                $node->appendChild($nodeValue);
            }
            else
            {
                $node = $dom->createElement($name, $dataProperties["value"]);
            }
            $xmlBody->appendChild($node);
        }
        return $dom->saveXML($xmlBody);
    }

    /**
     * 设置消息接收者
     *
     * @param string $value
     * @return self
     */
    public function setToUserName(string $value)
    {
        $this->tousername = $value;
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
        $this->fromusername = $value;
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
        $this->createtime = $value;
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
        $this->msgid = $value;
        return $this;
    }

    public function __get(string $name)
    {
        if (in_array($name, ["ToUserName", "FromUserName", "CreateTime", "MsgType", "MsgId"]))
        {
            $baseProperty = strtolower($name);
            return $this->$baseProperty;
        }
        return isset($this->properties[$name]) ? $this->properties[$name]["value"] : false;
    }
}