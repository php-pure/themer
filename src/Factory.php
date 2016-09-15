<?php
namespace PhpPure\Themer;

use RuntimeException;

class Factory
{
    private $theme;
    private $config;
    private $template_variables;
    private $markdowns;
    private $views_dir = null;

    public function __construct($markdowns, $config = [], $template_variables = [])
    {
        $this->theme();
        $this->config = $config;
        $this->template_variables = $template_variables;
        $this->markdowns = $markdowns;
    }

    public function theme($theme = Themes\Basic\Basic::class)
    {
        if (is_string($theme) && class_exists($theme)) {
            $this->theme = new $theme;
        } else if ($theme instanceof Themes\AbstractTheme) {
            $this->theme = $theme;
        } else {
            throw new RuntimeException("Theme not found.");
        }

        return $this;
    }

    public function views($dir)
    {
        $this->views_dir = $dir;

        return $this;
    }

    public function generate($prefix_folder = '', $ignore_revisions = false)
    {
        $this->theme->setConfig($this->config);
        $this->theme->setTemplateVariables($this->template_variables);
        $this->theme->setMarkdowns($this->markdowns);

        if (! is_null($this->views_dir)) {
            $this->theme->setViewsDir($this->views_dir);
        }

        $records = $this->theme->execute();

        foreach ($records as $file => $content) {
            $file = $prefix_folder.'/'.$file;

            if (! is_dir($folder = dirname($file))) {
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
