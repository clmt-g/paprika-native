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
        $path = __DIR__ . "/../view/$file";
        $content = file_get_contents($path);
        $content = preg_match('/{{ \s*(.+?)\s*}}/', "<?php echo $1 ?>", $content);
        //TODO : @if with @endif
        //TODO : @foreach with @endforeach

        //TODO : save $content in storage/cache directory
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
