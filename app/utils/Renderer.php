<?php

namespace Paprika\utils;

class Renderer
{
    /**
     * @param string $file Nom du fichier
     * @param array|null $data Données à injecter
     * @return string
     */
    public static function render(string $file, $data = null)
    {
        $path = __DIR__ . "/../view/$file.php";

        if (!file_exists($path)) {
            throw new \Exception("Le fichier de vue '$file.php' est introuvable.");
        }

        $content = file_get_contents($path);

        // Opérateur moustache {{ ... }}
        $content = preg_replace('/{{\s*(.+?)\s*}}/', "<?php echo $1; ?>", $content);

        // @if / @elseif / @endif
        $content = preg_replace('/@if\s*\((.+?)\)/', "<?php if ($1) { ?>", $content);
        $content = preg_replace('/@elseif\s*\((.+?)\)/', "<?php } else if ($1) { ?>", $content);
        $content = preg_replace('/@endif/', "<?php } ?>", $content);

        // @foreach / @endforeach
        $content = preg_replace('/@foreach\s*\((.+?)\)/', "<?php foreach ($1) { ?>", $content);
        $content = preg_replace('/@endforeach/', "<?php } ?>", $content);

        // @while / @endwhile
        $content = preg_replace('/@while\s*\((.+?)\)/', "<?php while ($1) { ?>", $content);
        $content = preg_replace('/@endwhile/', "<?php } ?>", $content);

        // Sauvegarde du contenu pré-parsé dans le cache
        $filepath = __DIR__ . "/../../storage/cache/$file.php";
        file_put_contents($filepath, $content);

        // Rendu avec extraction des variables
        ob_start();
        if ($data !== null) {
            extract($data, EXTR_SKIP);
        }
        include $filepath;
        return ob_get_clean();
    }
}