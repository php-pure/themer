<?php
namespace PhpPure\Themer;

use RuntimeException;
use SebastianBergmann\Git\Git;

class Factory
{
    private $revisions = [];

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

    public function cloneRevisions()
    {
        foreach ($this->revisions as $branch) {
            $revision_path = getcwd().'/../.php_pure_branches/'.$branch;

            exec('mkdir -p '.$revision_path);

            exec('cp -rf '.getcwd().' '.$revision_path);

            $git = new Git($revision_path.'/'.basename(getcwd()));
            $git->checkout($branch);

            exec('mkdir -p '.getcwd().'/revisions');

            // copy all contents except .git folder
            exec('rsync -rv --exclude=.git '.$revision_path.'/'.basename(getcwd()).' '.getcwd().'/revisions/'.$branch);

            // last remove the revision path
            exec('rm -rf '.$revision_path);


        }

        exec('rm -rf '.getcwd().'/../.php_pure_branches');
    }

    public function generate($prefix_folder = '', $ignore_revisions = false)
    {
        $git = new Git(getcwd());

        if (!empty($this->revisions) && $ignore_revisions === false) {
            // if (!$git->isWorkingCopyClean()) {
            //     throw new RuntimeException("Your working copy is not clean, please stash or commit your changes first.");
            // }

            $this->cloneRevisions();
        }

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

    public function revisions($revisions)
    {
        $this->revisions = $revisions;

        return $this;
    }

    public function tags($tags)
    {
        $this->tags = $tags;

        return $this;
    }
}
