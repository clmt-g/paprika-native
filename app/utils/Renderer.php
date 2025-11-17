<?php
namespace Paprika\utils;

class Renderer
{
    public static function render(string $file, $data = null): string
    {
        $path = __DIR__ . "/../view/$file.php";

        if (!file_exists($path)) {
            throw new \Exception("Vue introuvable : $file");
        }

        $content = file_get_contents($path);

        if ($content === false) {
            throw new \Exception("Impossible de lire : $path");
        }

        // {{ }} - Variables
        $content = preg_replace('/{{\s*(.+?)\s*}}/', "<?php echo htmlspecialchars($1); ?>", $content);

        // @if - Traiter AVANT @elseif et @else
        $content = preg_replace('/@if\s*\((.+)\)/', "<?php if($1) { ?>", $content);

        // @elseif - Traiter AVANT @else
        $content = preg_replace('/@elseif\s*\((.+)\)/', "<?php } elseif($1) { ?>", $content);

        // @else
        $content = preg_replace('/@else/', "<?php } else { ?>", $content);

        // @endif
        $content = preg_replace('/@endif/', "<?php } ?>", $content);

        // @foreach
        $content = preg_replace('/@foreach\s*\((.+)\)/', "<?php foreach($1) { ?>", $content);

        // @endforeach
        $content = preg_replace('/@endforeach/', "<?php } ?>", $content);

        // @while
        $content = preg_replace('/@while\s*\((.+)\)/', "<?php while($1) { ?>", $content);

        // @endwhile
        $content = preg_replace('/@endwhile/', "<?php } ?>", $content);

        // AJOUTER LES USE EN HAUT DU FICHIER COMPILÉ
        $content = "<?php use Paprika\\utils\\Auth; ?>\n" . $content;

        // Sauvegarder dans le cache
        $filepath = __DIR__ . "/../../storage/cache/$file.php";

        // Créer le dossier si nécessaire
        $dir = dirname($filepath);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents($filepath, $content);

        // Rendre la vue
        ob_start();
        if ($data !== null) {
            extract($data);
        }
        include $filepath;
        return ob_get_clean();
    }
}