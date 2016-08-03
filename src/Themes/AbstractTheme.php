<?php
namespace PhpPure\Themer\Themes;

use Jenssegers\Blade\Blade;
use PhpPure\Themer\Markdown;

abstract class AbstractTheme
{
    abstract public function execute();
    abstract public function config($config);
    abstract public function markdowns($markdowns);

    protected function parse($content)
    {
        return Markdown::parse($content);
    }

    protected function blade($views, $cache)
    {
        return new Blade($views, $cache);
    }
}
