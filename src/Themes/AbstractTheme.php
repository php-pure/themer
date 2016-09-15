<?php
namespace PhpPure\Themer\Themes;

use Jenssegers\Blade\Blade;
use PhpPure\Themer\Markdown;

abstract class AbstractTheme
{
    protected $views_dir = null;
    protected $cache_dir = null;
    protected $config;
    protected $markdowns;
    protected $template_variables;

    abstract public function execute();

    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    public function setTemplateVariables($template_variables)
    {
        $this->template_variables = $template_variables;

        return $this;
    }

    public function setMarkdowns($markdowns)
    {
        $this->markdowns = $markdowns;

        return $this;
    }

    protected function parse($content)
    {
        return Markdown::parse($content);
    }

    protected function getViewsDir()
    {
        return $this->views_dir;
    }

    public function setViewsDir($views_dir)
    {
        $this->views_dir = $views_dir;

        return $this;
    }

    public function setCacheDir($cache_dir)
    {
        $this->cache_dir = $cache_dir;

        return $this;
    }

    protected function getCacheDir()
    {
        return $this->cache_dir;
    }

    protected function blade($views = null, $cache = null)
    {
        $views = $views ?: $this->views_dir;
        $cache = $cache ?: $this->cache_dir;

        if ($views === null) {
            $views = getcwd().'/views';
        }

        if ($cache === null) {
            $cache = getcwd().'/views/.cache';
        }

        return new Blade($views, $cache);
    }
}
