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
        $this->view_dir = $dir;
    }

    public function generate($prefix_folder = '')
    {
        $theme = new $this->theme;
        $theme->config($this->config);
        $theme->markdowns($this->markdowns);
        $theme->viewsDir($this->views_dir);
        $records = $theme->execute();

        $this->checkFolderOrFilePerm($prefix_folder);

        foreach ($records as $file => $content) {
            $file = $prefix_folder.'/'.$file;

            if (!is_dir($folder = dirname($file))) {
                mkdir($folder, 0777, true);
            }

            // $this->checkFolderOrFilePerm($file);

            echo "   Writing to [$file]\n";
            file_put_contents($file, $content);
        }
    }

    private function checkFolderOrFilePerm($file_or_folder)
    {
        if (!is_writable($file_or_folder)) {
            throw new RuntimeException(
                "Folder [$file_or_folder] is not writeable,".
                " try to apply chmod."
            );
        }
    }
}
