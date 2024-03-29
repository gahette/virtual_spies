<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?= isset($title) ? e($title) : 'Virtual Spies' ?> | Virtual Spies</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
              rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
              crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Virtual Spies</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= $this->url('missions') ?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $this->url('admin_missions') ?>">Missions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $this->url('admin_agents') ?>">Agents</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $this->url('admin_countries') ?>">Pays</a>
                        </li>

                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success me-5" type="submit">Search</button>
                    </form>
                    <form action="<?= $this->url('logout') ?>" method="post" class="d-flex" style="display: inline">
                        <button type="submit" class="btn btn-outline-light me-2" >Se déconnecter</button>
                    </form>
                </div>
            </div>
        </nav>
        <div class="container mt-4">
            <?= $content ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
                crossorigin="anonymous"></script>
    </body>
</html>
