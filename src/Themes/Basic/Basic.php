<?php
namespace PhpPure\Themer\Themes\Basic;

use PhpPure\Themer\Themes\AbstractTheme;

class Basic extends AbstractTheme
{
    private $blade;
    private $config;
    private $markdowns;

    public function config($config)
    {
        $this->config = $config;
        $this->blade = $this->blade(__DIR__.'/Stub', __DIR__.'/Stub');

        return $this;
    }

    public function markdowns($markdowns)
    {
        $this->markdowns = $markdowns;

        return $this;
    }

    private function parseConfig($prefix, $lists)
    {
        $result = [];

        foreach ($lists as $key => $val) {
            if (is_array($val)) {
                $result = array_merge($result, $this->parseConfig($prefix.$key.'/', $val));
            } else {
                $result[$prefix.$key] = $val;
            }
        }

        return $result;
    }

    public function execute()
    {
        $ret = [];

        $parsed = $this->parseConfig('', $this->markdowns);

        $slugs = [];
        foreach ($parsed as $file => $md_file) {
            $slugs[$md_file] = static::slug($file);
        }

        foreach ($parsed as $file => $md_file) {
            $titles = explode('/', $file);
            $title = end($titles);

            if (
                isset($this->config['landing_page']) &&
                $md_file == $this->config['landing_page']
            ) {
                $file = 'index';
            }

            $ret[static::slug($file).'.html'] = html_entity_decode($this->blade->make('index', [
                'title'      => $title.' - ',
                'baseTitle'  => isset($this->config['base_title'])
                                    ? $this->config['base_title']
                                    : 'Documentation',
                'body'       => $this->parse(file_get_contents($md_file)),
                'navigation' => $this->blade->make('navigation', [
                                    'markdowns'    => $this->markdowns,
                                    'md_file'      => $md_file,
                                    'slugs'        => $slugs,
                                    'landing_page' => isset($this->config['landing_page']) ? $this->config['landing_page'] : false,
                                ])->render(),
            ])->render());
        }

        return $ret;
    }

    public static function slug($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function navigation($markdowns, $md_file, $slugs, $landing_page)
    {
        echo "<ul>";
        foreach ($markdowns as $menu => $sub_menu_or_value) {

            if (is_array($sub_menu_or_value) && !empty($sub_menu_or_value)) {
                echo "<li>";
                    ?><span class="nav-menu-title"><?php echo $menu ?></span><?php
                echo "</li>";

                static::navigation($sub_menu_or_value, $md_file, $slugs, $landing_page);
                continue;
            }

            $file = $slugs[$sub_menu_or_value];

            if ($landing_page === $sub_menu_or_value) {
                $file = 'index';
            }

            echo "<li>";
                ?><a href="<?php echo $file.'.html' ?>"><?php echo $menu ?></a><?php
            echo "</li>";
        }
        echo "</ul>";
    }
}