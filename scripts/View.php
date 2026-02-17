<?php

namespace Core;

class View
{
    private $action;
    private $argv;

    public function __construct($action = 'make', $argv = [])
    {
        $this->action = $action;
        $this->argv = $argv;

        $this->createFolders();

        switch ($action) {
            case 'make':
                $this->make($argv[2], $argv[3]);
                break;

            default:
                # code...
                break;
        }
    }

    private function createFolders()
    {
        if (!file_exists('views')) {
            echo 'Creating views folder...';
            mkdir('views');
        }

        if (!file_exists('controllers')) {
            echo 'Creating controllers folder...';
            mkdir('controllers');
        }
    }

    public function make($name, $controller = false)
    {

        if (file_exists("views/{$name}.php")) {
            echo "View '{$name}' already exists.";
            exit();
        }

        try {
            if (!$controller) {
                echo 'Creating view...';
                file_put_contents("views/{$name}.php", '');
                exit();
            }

            $data = "<?php\n\n\$title = ucfirst('{$name}');\n\nreturn view('{$name}', [\n  'title' => \$title\n]);";

            echo 'Creating view...';
            file_put_contents("views/{$name}.php", '');
            echo "\n";
            echo 'Creating controller...';
            file_put_contents("controllers/{$name}.php", $data);

            exit();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

$view = new View($argv[1], $argv);
