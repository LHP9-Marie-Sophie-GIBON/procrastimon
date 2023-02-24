<nav class="navbar navbar-expand-lg options fixed-bottom">
    <form class="container-fluid justify-content-around">
        <button class="btn btn-outline-light border-5" type="button">
            <a href="../controllers/controller-goals.php">
                <img src="https://img.icons8.com/external-yogi-aprelliyanto-basic-outline-yogi-aprelliyanto/48/FFFFFF/external-achievement-award-yogi-aprelliyanto-basic-outline-yogi-aprelliyanto-2.png" />
            </a>
        </button>
        <button class="btn btn-outline-light border-5" type="button">
            <a href="../controllers/controller-todo.php">
                <img src="https://img.icons8.com/sf-black-filled/48/FFFFFF/todo-list.png" />
            </a>
        </button>
        <button class="btn btn-outline-light border-5" type="button">
            <a href="../controllers/controller-trophies.php">
                <img src="https://img.icons8.com/ios-filled/48/FFFFFF/laurel-wreath.png" />
            </a>
        </button>
        <button class="btn" type="button" data-bs-toggle="modal" data-bs-target="#modalOptions">
            <img src="https://img.icons8.com/ios-filled/48/FFFFFF/menu-2.png" />
        </button>
    </form>
</nav>

<!-- Modal -->
<div class="modal fade" id="modalOptions" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">OPTIONS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <form action="../config/deconnect.php" method="post">
                    <button type="submit" class="btn btn-outline-light">
                        <img src="https://img.icons8.com/pastel-glyph/48/FFFFFF/shutdown--v1.png" />
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>