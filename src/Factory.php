<?php
namespace PhpPure\Themer;

use RuntimeException;

class Factory
{
    private $theme;
    private $config;
    private $markdowns;
    private $views_dir = null;

    public function __construct($markdowns, $config = [])
    {
        $this->theme();
        $this->config = $config;
        $this->markdowns = $markdowns;
    }

    public function theme($theme = Themes\Basic\Basic::class)
    {
        $this->theme = $theme;

        return $this;
    }

    public function views($dir)
    {
        $this->views_dir = $dir;

        return $this;
    }

    public function generate($prefix_folder = '', $ignore_revisions = false)
    {
        $theme = new $this->theme;
        $theme->config($this->config);
        $theme->markdowns($this->markdowns);
        $theme->viewsDir($this->views_dir);
        $records = $theme->execute();

        foreach ($records as $file => $content) {
            $file = $prefix_folder.'/'.$file;

            if (!is_dir($folder = dirname($file))) {
                mkdir($folder, 0777, true);
            }

            echo "   Writing to [$file]\n";
            file_put_contents($file, $content);
        }
    }

    public function tags($tags)
    {
        $this->tags = $tags;

        return $this;
    }
}
