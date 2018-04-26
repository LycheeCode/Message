<?php

namespace Lychee\Message;

use Lychee\Message\Base;

class News extends Base
{
    /**
     * 消息类型
     *
     * @var string
     */
    protected $MsgType = "news";

    /**
     * 检验属性完整性
     *
     * @return boolean
     */
    protected function validateProperties(array $tree): bool
    {
        if (! isset($tree["ArticleCount"])
         || ! isset($tree["Articles"]))
        {
            return false;
        }
        $this->properties["ArticleCount"] = $tree["ArticleCount"];
        for ($i = 0; $i < $tree["ArticleCount"]; $i++)
        {
            $articleElemets = [
                "Title",
                "Description",
                "PicUrl",
                "Url"
            ];
            foreach ($articleElemets as $el)
            {
                if (! isset($tree["Articles"][$i][$el]))
                {
                    return false;
                }
                $this->properties["Articles"][$i][$el] = $tree["Articles"][$i][$el];
            }
        }
        return true;
    }
}