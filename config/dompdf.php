<?php

return [
    'font_path' => base_path('resources/fonts/'), // Chemin des polices
    'font_cache' => storage_path('app/dompdf'), // Cache des polices
    'temp_dir' => storage_path('temp'), // Répertoire temporaire
    'chroot' => realpath(base_path()), // Répertoire racine
    'isHtml5ParserEnabled' => true, // Activation du parseur HTML5
    'isPhpEnabled' => true, // Activation de PHP dans les vues
    'isHtml5ParserEnabled' => true, // Activation du parseur HTML5
    'isPhpEnabled' => true, // Activation de PHP dans les vues
    'defaultMediaType' => 'screen', // Type de média par défaut
    'defaultPaperSize' => 'a4', // Format de papier par défaut
    'defaultFont' => 'helvetica', // Police par défaut
];
