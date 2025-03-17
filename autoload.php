<?php


spl_autoload_register(function ($className) {
    $paths = [
      "controllers/",
      "models/",
      "core/",
    ];

    foreach ($paths as $path) {
        $file = __DIR__ . "/$path$className.php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
