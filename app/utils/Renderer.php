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

        // @if with @endif

        // @foreach with @endforeach

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
