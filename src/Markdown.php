<?php
namespace PhpPure\Themer;

use cebe\markdown\GithubMarkdown as Base;

class Markdown
{
    public static function parse($content)
    {
        return (new Base)->parse($content);
    }
}
