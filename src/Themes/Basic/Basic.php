<?php
namespace PhpPure\Themer\Themes\Basic;

use PhpPure\Themer\Themes\AbstractTheme;

class Basic extends AbstractTheme
{
    private $config;
    private $markdowns;

    public function config($config)
    {
        $this->config = $config;

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
            if (! file_exists($md_file)) {
                throw new \RuntimeException("File [$md_file] not found.");
            }

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

            $ret[static::slug($file).'.html'] = html_entity_decode($this->blade()->make('index', $this->config + [
                'title'      => $title.' - ',
                'body'       => $this->parse(file_get_contents($md_file)),
                'sidebar'    => $this->blade()->make(
                                    'sidebar',
                                    [
                                        'markdowns'    => $this->markdowns,
                                        'md_file'      => $md_file,
                                        'slugs'        => $slugs,
                                        'landing_page' => isset($this->config['landing_page']) ? $this->config['landing_page'] : false,
                                    ]
                                )->render(),
            ])->render());

            echo "   Rendering [$md_file]\n";
        }

        echo "   Checking if 404.blade.php exists";
        if (file_exists($this->getViewsDir().'/404.blade.php')) {
            echo "   404.blade.php exists";
            echo "   Rendering the 404.blade.php\n";
            $ret['404.html'] = html_entity_decode($this->blade()->make('404', $this->config)->render());
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

    public static function sidebar($markdowns, $md_file, $slugs, $landing_page, $menu_num = 1, $sidebar_num = 1)
    {
        echo "<ul class=\"sidebar-level-{$sidebar_num}\">";
        foreach ($markdowns as $menu => $sub_menu_or_value) {

            if (is_array($sub_menu_or_value) && !empty($sub_menu_or_value)) {
                echo "<li class=\"menu-level-{$menu_num}\">";
                    ?><div class="nav-menu-title"><?php echo $menu ?></div><?php

                    $sn = $sidebar_num + 1;
                    $mn = $menu_num + 1;
                    static::sidebar($sub_menu_or_value, $md_file, $slugs, $landing_page, $mn, $sn);
                echo "</li>";

                continue;
            }

            $file = $slugs[$sub_menu_or_value];

            if ($landing_page === $sub_menu_or_value) {
                $file = 'index';
            }

            echo "<li class=\"menu-level-{$menu_num}\">";
                ?><a href="<?php echo $file.'.html' ?>"><?php echo $menu ?></a><?php
            echo "</li>";
        }
        echo "</ul>";
    }
}
