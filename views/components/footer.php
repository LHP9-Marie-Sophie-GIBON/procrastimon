<?php $controller = basename($_SERVER['PHP_SELF'], '.php'); ?>
<nav class="navbar navbar-expand-lg options fixed-bottom justify-content-center" tabindex="1">
    <button type="button" class="btn btn-outline-light rounded-5 border-5 fw-bold fs-4" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">Menu</button>
</nav>

<div class="offcanvas offcanvas-bottom h-75 rounded-top-5 " tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
    <div class="offcanvas-body small align-items-between">
        <div class="container-fluid text-center">

            <?php if ($controller === 'controller-home') {
            ?>
                <div class="row align-items-center justify-content-center mt-3">

                    <!-- Bouton 1-->
                    <div class="col text-center">
                        <button class="btn btn-outline-light border-5" type="button">
                            <a href="../controllers/controller-goals.php">
                                <img src="https://img.icons8.com/external-yogi-aprelliyanto-basic-outline-yogi-aprelliyanto/48/FFFFFF/external-achievement-award-yogi-aprelliyanto-basic-outline-yogi-aprelliyanto-2.png" />
                            </a>
                        </button> <br>
                        <label class="text-white small" for="goals">Goals</label>
                    </div>

                    <!-- Bouton 2 -->
                    <div class="col text-center ">
                        <button class="btn btn-outline-light border-5" type="button">
                            <a href="../controllers/controller-todos.php">
                                <img src="https://img.icons8.com/sf-black-filled/48/FFFFFF/todo-list.png" />
                            </a>
                        </button> <br>
                        <label class="text-white small" for="todolist">To-do list</label>
                    </div>

                </div>
                <div class="row justify-content-center align-items-center">
                    <!-- Bouton 3 -->
                    <div class="col text-center">
                        <button class="btn btn-outline-light border-5" type="button">
                            <a href="../controllers/controller-trophies.php">
                                <img src="https://img.icons8.com/ios-filled/48/FFFFFF/laurel-wreath.png" />
                            </a>
                        </button> <br>
                        <label class="text-white small" for="Trophies">Trophies</label>
                    </div>
                </div>
                <div class="row justify-content-center align-items-center">
                    <!-- Bouton 4 -->
                    <div class="col text-center">
                        <button class="btn btn-outline-light border-5">
                            <a href="../controllers/controller-boarding-home.php"><img src="https://img.icons8.com/ios-glyphs/48/FFFFFF/house-with-a-garden.png" /></a>
                        </button> <br>
                        <label class="text-white small" for="Boarding-home">Boarding-Home</label>
                    </div>

                    <!-- Bouton 5 -->
                    <div class="col text-center">
                        <button class="btn btn-outline-light border-5" type="button" data-bs-toggle="modal" data-bs-target="#modalOptions">
                            <img src="https://img.icons8.com/ios-filled/48/FFFFFF/menu-2.png" />
                        </button> <br>
                        <label class="text-white small" for="Profil">Profil</label>
                    </div>

                </div>
            <?php } else { ?>
                <div class="row align-items-center justify-content-center mt-3">

                    <!-- Bouton 1-->
                    <div class="col text-center">
                        <button class="btn btn-outline-light border-5 btnHome" type="button">
                            <a href="../controllers/controller-home.php">
                                <img src="https://img.icons8.com/sf-black/48/FFFFFF/u-turn-to-left.png" />
                            </a>
                        </button><br>
                        <label class="text-white small" for="goals">Return Home</label>
                    </div>

                    <!-- Bouton 2 -->
                    <div class="col text-center ">
                        <?php if ($controller === 'controller-todos' || $controller === 'controller-trophies' || $controller === 'controller-boarding-home') { ?>
                            <button class="btn btn-outline-light border-5" type="button">
                                <a href="../controllers/controller-goals.php">
                                    <img src="https://img.icons8.com/external-yogi-aprelliyanto-basic-outline-yogi-aprelliyanto/48/FFFFFF/external-achievement-award-yogi-aprelliyanto-basic-outline-yogi-aprelliyanto-2.png" />
                                </a>
                            </button> <br>
                            <label class="text-white small" for="goals">Goals</label>
                        <?php } else { ?>
                            <button class="btn btn-outline-light border-5" type="button">
                                <a href="../controllers/controller-todos.php">
                                    <img src="https://img.icons8.com/sf-black-filled/48/FFFFFF/todo-list.png" />
                                </a>
                            </button> <br>
                            <label class="text-white small" for="todolist">To-do list</label>
                        <?php } ?>
                    </div>
                </div>
                <div class="row justify-content-center align-items-center">
                    <!-- Bouton 3 -->
                    <div class="col text-center">
                        <?php if ($controller === 'controller-trophies' || $controller === 'controller-boarding-home') { ?>
                            <button class="btn btn-outline-light border-5" type="button">
                                <a href="../controllers/controller-todos.php">
                                    <img src="https://img.icons8.com/sf-black-filled/48/FFFFFF/todo-list.png" />
                                </a>
                            </button> <br>
                            <label class="text-white small" for="todolist">To-do list</label>
                        <?php } else { ?>
                            <button class="btn btn-outline-light border-5" type="button">
                                <a href="../controllers/controller-trophies.php">
                                    <img src="https://img.icons8.com/ios-filled/48/FFFFFF/laurel-wreath.png" />
                                </a>
                            </button> <br>
                            <label class="text-white small" for="Trophies">Trophies</label>
                        <?php } ?>
                    </div>

                    <!-- Bouton 4 -->
                    <div class="col text-center">
                        <?php if ($controller === 'controller-boarding-home') { ?>
                            <button class="btn btn-outline-light border-5" type="button">
                                <a href="../controllers/controller-trophies.php">
                                    <img src="https://img.icons8.com/ios-filled/48/FFFFFF/laurel-wreath.png" />
                                </a>
                            </button> <br>
                            <label class="text-white small" for="Trophies">Trophies</label>
                        <?php } else { ?>
                            <button class="btn btn-outline-light border-5">
                                <a href="../controllers/controller-boarding-home.php"><img src="https://img.icons8.com/ios-glyphs/48/FFFFFF/house-with-a-garden.png" /></a>
                            </button> <br>
                            <label class="text-white small" for="Boarding-home">Boarding-Home</label>
                        <?php } ?>
                    </div>
                </div>

            <?php } ?>
        </div>
        <div class="row justify-content-center">
            <img src="../assets/img/banner.png" alt="Logo" class="banner" />
        </div>
        <div class="row justify-content-center m-3">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/app.js"></script>