<?php

namespace App;

use AltoRouter;

class Router
{
    private string $viewPath;
    private AltoRouter $router;

    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new AltoRouter(); // Démarrage du router
    }

    public function get(string $url, string $view, ?string $name = null): self // retour sera la class
    {
        $this->router->map('GET', $url, $view, $name); // Récupère URL, charge la vue avec le nom
        return $this;
    }

    public function post(string $url, string $view, ?string $name = null): self // retour sera la class
    {
        $this->router->map('POST', $url, $view, $name); // Récupère URL, charge la vue avec le nom
        return $this;
    }
    public function url(string $name, array $params = []): string
    {
        return $this->router->generate($name, $params);
    }

    public function run(): self
    {
        $match = $this->router->match(); // Renvoie tableau associatif contenant les correspondances
        $view = $match['target']; // Récupère les view
        $params = $match['params'];
        $router = $this;
        ob_start(); // Démarre la buffer
        require $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php';
        $content = ob_get_clean(); // Récupération du contenu
        require $this->viewPath . DIRECTORY_SEPARATOR . 'layouts/default.php';

        return $this;
    }
}