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
        $content = preg_replace('/{{ \s*(.+?)\s*}}/', "<?php echo $1 ?>", $content);

        // @if(condition)
        $content = preg_replace('/@if\s*\((.+?)\)/', '<?php if ($1): ?>', $content);
        // @endif
        $content = preg_replace('/@endif/', '<?php endif; ?>', $content);

        // @foreach(loop
        $content = preg_replace('/@foreach\s*\((.+?)\)/', '<?php foreach ($1): ?>', $content);
        // @endforeach
        $content = preg_replace('/@endforeach/', '<?php endforeach; ?>', $content);

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
