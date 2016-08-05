<?php
namespace PhpPure\Themer\Themes;

use Jenssegers\Blade\Blade;
use PhpPure\Themer\Markdown;

abstract class AbstractTheme
{
    private $views_dir = null;

    abstract public function execute();
    abstract public function config($config);
    abstract public function markdowns($markdowns);

    protected function parse($content)
    {
        return Markdown::parse($content);
    }

    public function viewsDir($views_dir)
    {
        $this->views_dir = $views_dir;
    }

    protected function blade($views = null, $cache = null)
    {
        $views = $views ?: $this->views_dir;

        if ($views === null) {
            $views = getcwd().'/views';
        }

        return new Blade($views, $cache ?: $views.'/.cache');
    }
}
