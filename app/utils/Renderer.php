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
        $content = preg_replace('@if/{{ \s*(.+?)\s*}}/', '<?php if ($1)', $content);
        $content = preg_replace('/@endif/', 'endif ?>', $content);

        // @foreach with @endforeach
        $content = preg_replace();

        // save $content in storage/cache directory
        $filepath = __DIR__ . "/../../storage/cache/";
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
