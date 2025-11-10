<?php
namespace Paprika\utils;

class Renderer
{
    /**
     * Render une vue avec données
     *
     * @param string $file Nom du fichier de vue (ex : 'auth/login')
     * @param array|null $data Variables à injecter
     * @return string
     * @throws \Exception
     */
    public static function render(string $file, ?array $data = null)
    {
        $path = __DIR__ . "/../view/$file.php";

        if (!file_exists($path)) {
            throw new \Exception("Le fichier de vue '$file.php' est introuvable.");
        }

        $content = file_get_contents($path);

        // Remplace {{ var }} par PHP
        $content = preg_replace('/{{\s*(.+?)\s*}}/', "<?php echo \$1; ?>", $content);

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

        // Crée automatiquement le dossier cache si nécessaire
        $filepath = __DIR__ . "/../../storage/cache/$file.php";
        $dir = dirname($filepath);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        file_put_contents($filepath, $content);

        // Inclut la vue avec extraction des variables
        ob_start();
        if ($data !== null) {
            extract($data, EXTR_SKIP);
        }
        include $filepath;
        return ob_get_clean();
    }
}