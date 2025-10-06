<?php

namespace Paprika\utils;

class Renderer
{

    public static function render(string $file, $data = null){

        $path = __DIR__ . '/../view/' . $file . '.php'; // mettre le chemin du fichier
        $content = file_get_contents($path);
        $content = preg_match('/ff\s*(.+?)\s*}}/', "<?php echo $1?>", $content);

        //TODO : @if with @endif
        $content = preg_replace('/@if\s*\((.*?)\)/', '<?php if ($1): ?>', $content);
        $content = preg_replace('/@endif/', '<?php endif; ?>', $content);
        //TODO @foreach with @endforeach
        $content = preg_replace('/@foreach\s*\((.*?)\)/', '<?php foreach ($1): ?>', $content);
        $content = preg_replace('/@endforeach/', '<?php endforeach; ?>', $content);

        //TODO save $content in storage/cache directory
        $filepath = __DIR__ . '/../../storage/cache/' . $file . '.php';
        file_put_contents($filepath, $content);


        ob_start();
        if($data !== null){
            extract($data);
        }
        include $filepath;
        $page = ob_get_contents();
        ob_end_clean();
        return $page;

        //
    }
}