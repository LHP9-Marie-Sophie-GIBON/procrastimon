<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- animated background -->
    <div class='light x1'></div>
    <div class='light x2'></div>
    <div class='light x3'></div>
    <div class='light x4'></div>
    <div class='light x5'></div>
    <div class='light x6'></div>
    <div class='light x7'></div>
    <div class='light x8'></div>
    <div class='light x9'></div>


    <header>
        <nav class="navbar fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img src="https://cdn.staticneo.com/w/shenmue/thumb/9/95/Gachacatcha.png/300px-Gachacatcha.png" alt="logo">PROCRASTIMON</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Progress</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Settings</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>



    <main class="row">
        <div class="row progressbar justify-content-end">
            <div class="col-6">
                <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <div class="progress" role="progressbar" aria-label="Info example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-info" style="width: 0%"></div>
                </div>
            </div>
        </div>

        <div class="row character">
            <img src="https://assets.pokemon.com/assets/cms2/img/pokedex/detail/258.png" alt="character">
        </div>

        <div class="row options">
            <div class="col text-center text-white">
                <h5 class="m-1">GOALS</h5>
                <nav class="navbar">
                    <form class="container-fluid">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">@</span>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </form>
                </nav>
            </div>
            <div class="col text-center text-white">
                <h5 class="m-1">TO-DO LIST</h5>
                <nav class="navbar">
                    <form class="container-fluid">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">@</span>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </form>
                </nav>

            </div>
        </div>

        <footer>

        </footer>
    </main>
    <footer></footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>