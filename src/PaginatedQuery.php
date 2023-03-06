<?php

namespace App;

use Database\DBConnection;
use Exception;
use PDO;

class PaginatedQuery
{
    private string $query;
    private string $queryCount;
    private PDO $pdo;
    private int $perPage;
    private $count;
    private $items;


    /**
     * @param string $query
     * @param string $queryCount
     * @param PDO|null $pdo
     * @param int $perPage
     */
    public function __construct(string $query, string $queryCount, PDO $pdo = null, int $perPage = 12)
    {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->pdo = $pdo ?: (new DBConnection)->getPdo();
        $this->perPage = $perPage;
    }

    public function getItems(string $classMapping): array
    {
        if ($this->items === null) {

            // Numéro de la page courante
            $currentPage = $this->getCurrentPage();
            $pages = $this->getPages();

            if ($currentPage > $pages) {
                throw new Exception('Cette page n\'existe pas');
            }

            // Calcul de de l'offset
            $offset = $this->perPage * ($currentPage - 1);
            $this->items = $this->pdo->query(
                $this->query .
                " LIMIT $this->perPage OFFSET $offset")
                ->fetchAll(PDO::FETCH_CLASS, $classMapping);
        }
        return $this->items; // optimisation de l'appel
    }

    public function previousLink(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        if ($currentPage <= 1) return null;
        if ($currentPage > 2) $link .= "?page=" . ($currentPage - 1);
        return <<<HTML
<a href="$link" class="btn btn-dark">&laquo; Page précédente</a>
HTML;
    }

    public function nextLink(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        $pages = $this->getPages();
        if ($currentPage >= $pages) return null;
        $link .= "?page=" . ($currentPage + 1);
        return <<<HTML
<a href= "$link" class="btn btn-dark ms-auto ?>">Page suivante &raquo;</a>
HTML;
    }

    private function getCurrentPage(): int
    {
        return URL::getPositiveInt('page', 1);
    }

    private function getPages(): int
    {
        if ($this->count === null) {
            // Récupération du nombre de missions
            $this->count = (int)$this->pdo
                ->query($this->queryCount)
                ->fetch(PDO::FETCH_NUM)[0];
        }

        // Nombre de pages total
        return ceil($this->count / $this->perPage);
    }
}