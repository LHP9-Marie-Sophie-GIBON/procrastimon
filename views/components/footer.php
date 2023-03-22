<nav class="navbar navbar-expand-lg options fixed-bottom justify-content-center" tabindex="1">
    <button type="button" class="btn btn-outline-light rounded-5 border-5 fw-bold fs-4" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">Menu</button>
</nav>

<div class="offcanvas offcanvas-bottom h-75 rounded-top-5 " tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
    <div class="offcanvas-body small align-items-between">
        <div class="container-fluid text-center">
            <div class="row align-items-center justify-content-center mt-3">
                <div class="col-2 text-center" >
                    <button class="btn btn-outline-light border-5" type="button" >
                        <a href="../controllers/controller-goals.php">
                            <img src="https://img.icons8.com/external-yogi-aprelliyanto-basic-outline-yogi-aprelliyanto/48/FFFFFF/external-achievement-award-yogi-aprelliyanto-basic-outline-yogi-aprelliyanto-2.png" />
                        </a>
                    </button> <br>
                    <label class="text-white small" for="goals">Goals</label>
                </div>
                <div class="col-2 text-center ">
                    <button class="btn btn-outline-light border-5" type="button">
                        <a href="../controllers/controller-todos.php">
                            <img src="https://img.icons8.com/sf-black-filled/48/FFFFFF/todo-list.png" />
                        </a>
                    </button> <br>
                    <label class="text-white small" for="todolist">To-do list</label>
                </div>
                
            </div>
            <div class="row justify-content-center align-items-center">
            <div class="col-2 text-center">
                    <button class="btn btn-outline-light border-5" type="button">
                        <a href="../controllers/controller-trophies.php">
                            <img src="https://img.icons8.com/ios-filled/48/FFFFFF/laurel-wreath.png" />
                        </a>
                    </button> <br>
                    <label class="text-white small" for="Trophies">Trophies</label>
                </div>
            </div>
            <div class="row justify-content-center align-items-center">
                <div class="col-2 text-center">
                    <button class="btn btn-outline-light border-5">
                        <a href="../controllers/controller-boarding-home.php"><img src="https://img.icons8.com/ios-glyphs/48/FFFFFF/house-with-a-garden.png" /></a>
                    </button> <br>
                    <label class="text-white small" for="Boarding-home">Boarding-Home</label>
                </div>
                <div class="col-2 text-center">
                    <button class="btn btn-outline-light border-5" type="button" data-bs-toggle="modal" data-bs-target="#modalOptions">
                        <img src="https://img.icons8.com/ios-filled/48/FFFFFF/menu-2.png" />
                    </button> <br>
                    <label class="text-white small" for="Profil">Profil</label>

                </div>
            </div>

        </div>
    </div>
    <div class="row justify-content-center m-3">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
</div>






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
