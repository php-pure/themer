<?php
namespace PhpPure\Themer;

class Factory
{
    private $theme;
    private $config;
    private $markdowns;

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

    public function generate($prefix_folder = '')
    {
        $theme = new $this->theme;
        $theme->config($this->config);
        $theme->markdowns($this->markdowns);
        $records = $theme->execute();

        foreach ($records as $file => $content) {
            $file = $prefix_folder.'/'.$file;

            if (!is_dir($folder = dirname($file))) {
                mkdir($folder, 0777, true);
            }

            file_put_contents($file, $content);
        }
    }
}
