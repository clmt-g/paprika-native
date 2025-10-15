<?php

namespace Paprika\utils;

/**
 *
 */
class Renderer
{
    /**
     * @param string $file (nom du fichier)
     * @param $data
     * @return void
     */
    public static function render(string $file, $data = null)
    {
        $path = __DIR__ . "/../view/$file.php";
        $content = file_get_contents($path);
        $content = preg_replace('/{{\s*(.+?)\s*}}/', "<?php echo htmlspecialchars($1); ?>", $content);
        //@if
        $content = preg_replace('/@if\(\s*(.+?)\s*\)/', "<?php if($1) { ?>", $content);
        $content = preg_replace('/@endif/', "<?php } ?>", $content);
        $content = preg_replace('/@elseif/', "<?php } else { ?>", $content);
        //@foreach
        $content = preg_replace('/@foreach\(\s*(.+?)\s*\)/', "<?php foreach($1) { ?>", $content);
        $content = preg_replace('/@endforeach/', "<?php } ?>", $content);
        //@while
        $content = preg_replace('/@while\(\s*(.+?)\s*\)/', "<?php while($1) { ?>", $content);
        $content = preg_replace('/@endwhile/', "<?php } ?>", $content);

        // save $content in storage/cache directory
        $filepath = __DIR__ . "/../../storage/cache/$file.php";
        file_put_contents($filepath, $content);

        ob_start();
        if($data !== null) {
            extract($data);
        }
        include $filepath;
        $page = ob_get_clean();
        ob_end_flush();
        return $page;
    }
}
