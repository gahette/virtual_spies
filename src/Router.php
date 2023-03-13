<?php

namespace App;

use AltoRouter;
use App\Security\ForbiddenException;
use Exception;

class Router
{
    private string $viewPath;
    private AltoRouter $router;

    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new AltoRouter(); // Démarrage du router
    }

    /**
     * @throws Exception
     */
    public function get(string $url, string $view, ?string $name = null): self // retour sera la class
    {
        $this->router->map('GET', $url, $view, $name); // Récupère URL, charge la vue avec le nom
        return $this;
    }

    /**
     * @throws Exception
     */
    public function post(string $url, string $view, ?string $name = null): self // retour sera la class
    {
        $this->router->map('POST', $url, $view, $name); // Récupère URL, charge la vue avec le nom
        return $this;
    }

    /**
     * @throws Exception
     */
    public function match(string $url, string $view, ?string $name = null): self // retour sera la class
    {
        $this->router->map('POST|GET', $url, $view, $name); // Récupère URL, charge la vue avec le nom
        return $this;
    }

    /**
     * @throws Exception
     */
    public function url(string $name, array $params = [])
    {
        return $this->router->generate($name, $params);
    }

    public function run(): self
    {
        $match = $this->router->match(); // Renvoie tableau associatif contenant les correspondances
        try {
            $view = $match['target']; // Récupère les view
        }catch(\ErrorException $e){
            require $this->viewPath . DIRECTORY_SEPARATOR . 'e404.php';
            exit;
        }
        $params = $match['params'];
        $router = $this;
        $isAdmin = strpos($view, 'admin/') !== false;
        $layout = $isAdmin ? 'admin/layouts/default' : 'layouts/default';

        try {
            ob_start(); // Démarre la buffer
            require $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php';
            $content = ob_get_clean(); // Récupération du contenu
            require $this->viewPath . DIRECTORY_SEPARATOR . $layout . '.php';
        }catch(ForbiddenException $e){
            header('Location: ' . $this->url('login'). '?forbidden=1');
            exit;
        }
        return $this;
    }
}