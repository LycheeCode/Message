# Lychee\Message

## 简介

`Lychee\Message` 是微信公众号消息模型类，它能解析和构建微信公众号消息数据，你可以使用它进行微信公众号被动消息的开发和调试。

## 安装

```
composer require lychee/message
```

## 简单使用

### 从 XML 数据载入

```PHP
<?php
use Lychee\Message\Text;

$xml = "<xml><ToUserName><![CDATA[username]]></ToUserName><FromUserName><![CDATA[openid]]></FromUserName><CreateTime>1529939743</CreateTime><MsgType><![CDATA[text]]></MsgType><MsgId>201806252315439427</MsgId><Content><![CDATA[Hello world]]></Content></xml>";

$msg = new Text($xml);

var_dump($msg);
// object(Lychee\Message\Text)#2 (6) {
//   ["MsgType":protected]=>
//   string(4) "text"
//   ["ToUserName":protected]=>
//   string(8) "username"
//   ["FromUserName":protected]=>
//   string(6) "openid"
//   ["CreateTime":protected]=>
//   string(10) "1529939743"
//   ["MsgId":protected]=>
//   string(18) "201806252315439427"
//   ["properties":protected]=>
//   array(1) {
//    ["Content"]=>
//    string(11) "Hello world"
//   }
// }
```

如果你不知道 xml 中的 `MsgType` 是何值（例如你的程序接收到来自微信的数据时），可以使用 `Auto` 类来帮你加载和解析：

```PHP
<?php
use Lychee\Message\Auto;

$xml = "<xml><ToUserName><![CDATA[username]]></ToUserName><FromUserName><![CDATA[openid]]></FromUserName><CreateTime>1529939743</CreateTime><MsgType><![CDATA[text]]></MsgType><MsgId>201806252315439427</MsgId><Content><![CDATA[Hello world]]></Content></xml>";

$msg = Auto::init($xml);

var_dump(get_class($msg));
// string(19) "Lychee\Message\Text"
```

### 构建新消息

```PHP
<?php
use Lychee\Message\Text;

$msg = new Text;

// 然后可以通过 set 开头的方法设置属性：
$msg->setToUserName("username")
    ->setFromUserName("openid")
    ->setCreateTime(time())
    ->setMsgId(date("YmdHis" . mt_rand(1000,9999)))
    ->setContent("Hello world");

var_dump($msg->toXML());
// string(248) "<xml><ToUserName><![CDATA[username]]></ToUserName><FromUserName><![CDATA[openid]]></FromUserName><CreateTime>1529939797</CreateTime><MsgType><![CDATA[text]]></MsgType><MsgId>201806252316377977</MsgId><Content><![CDATA[Hello world]]></Content></xml>"
```

### 访问消息数据

访问消息数据时，可以像公开属性一样直接访问，属性名与 xml 结构中的标签一样，例如

```PHP
echo $msg->ToUserName;
// username

echo $msg->Content;
// Hello world
```

### 生成 xml 字符串和数组

通过 `toXML()` 和 `toArray()` 方法可以生成 xml 字符串或消息数组：

```PHP
<?php
use Lychee\Message\Text;

$msg = new Text;
$msg->setToUserName("username")
    ->setFromUserName("openid")
    ->setCreateTime(time())
    ->setMsgId(date("YmdHis" . mt_rand(1000,9999)))
    ->setContent("Hello world");

var_dump($msg->toXML());
// string(248) "<xml><ToUserName><![CDATA[username]]></ToUserName><FromUserName><![CDATA[openid]]></FromUserName><CreateTime>1529941287</CreateTime><MsgType><![CDATA[text]]></MsgType><MsgId>201806252341275858</MsgId><Content><![CDATA[Hello world]]></Content></xml>"

var_dump($msg->toArray());
// array(6) {
//   ["MsgType"]=>
//   string(4) "text"
//   ["FromUserName"]=>
//   string(6) "openid"
//   ["ToUserName"]=>
//   string(8) "username"
//   ["CreateTime"]=>
//   int(1529941287)
//   ["MsgId"]=>
//   int(201806252341275858)
//   ["Content"]=>
//   string(11) "Hello world"
// }
```