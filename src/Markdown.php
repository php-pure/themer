<?php
namespace PhpPure\Themer;

use cebe\markdown\Markdown as Base;

class Markdown
{
    public static function parse($content)
    {
        return (new Base)->parse($content);
    }
}
