<?php

declare(strict_types=1);

class Autoloader
{
    private string $root;

    public function __construct(string $root)
    {
        $this->root = $root;

        spl_autoload_register([$this, 'autoload']);
    }

    private function autoload(string $className) {
        include_once(
            sprintf(
                '%s%s%s.php',
                $this->root,
                DIRECTORY_SEPARATOR,
                str_replace('\\', DIRECTORY_SEPARATOR, $className)
            )
        );
    }
}
