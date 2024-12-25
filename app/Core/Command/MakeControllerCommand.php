<?php

namespace Almhdy\Simy\Core\Command;

class MakeControllerCommand
{
    public function __invoke(array $arguments): void
    {
        $controllerName = $arguments[0] ?? null;

        if (!$controllerName) {
            echo "Controller name is required.\n";
            return;
        }

        $controllerFile = __DIR__ . "/../../Controllers/{$controllerName}.php";

        if (file_exists($controllerFile)) {
            echo "Controller already exists.\n";
            return;
        }

        $template = "<?php\n\nnamespace Almhdy\Simy\Controllers;\n\nclass {$controllerName}\n{\n    // Controller methods\n}\n";

        file_put_contents($controllerFile, $template);
        echo "Controller {$controllerName} created successfully.\n";
    }
}