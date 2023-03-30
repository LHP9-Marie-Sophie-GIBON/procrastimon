<?php include 'components/head.php'; ?>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    function onSubmit(token) {
        document.getElementById("demo-form").submit();
    }
</script>

<main>
    <div class="container start">
        <?php if (isset($_GET['newGame'])) { ?>

            <div class="row newGame justify-content-center align-items-center">

                <div class="card rounded-5 border border-light border-5">
                    <div class="card-body pt-0 ps-5 pe-5">
                        <h1 class="text-center fw-bold m-1">New Player</h1>
                        <form action="" method="post" id="demo-form" class="container">

                            <!-- user part -->
                            <div class="row mb-1">
                                <span class="col-1 my-auto" id="basic-addon1"> <?= $arrayErrors['login'] ?? '<i class="bi bi-person-circle"></i>' ?></span>
                                <input type="text" class="col form-control rounded-pill <?= $arrayErrors['danger'] ?? '' ?>" placeholder="login" aria-label="login" aria-describedby="login" name="login" value="<?= $login ?? '' ?><?= $arrayErrors['login-error'] ?? '' ?>">
                            </div>


                            <div class="row mb-1">
                                <span class="col-1 my-auto" id="basic-addon1"> <?= $arrayErrors['mail'] ?? '<i class="bi bi-envelope-fill"></i>' ?></span>
                                <input type="text" class="col form-control rounded-pill <?= $arrayErrors['danger'] ?? '' ?>" placeholder="Mail" aria-label="mail" aria-describedby="mail" name="mail" value="<?= $mail ?? '' ?><?= $arrayErrors['mail-error'] ?? '' ?>">
                            </div>


                            <div class="row mb-1">
                                <span class="col-1 my-auto" id="basic-addon1"> <?= $arrayErrors['password'] ?? '<i class="bi bi-shield-lock"></i>' ?></span>
                                <input type="password" class="col form-control rounded-pill <?= $arrayErrors['danger'] ?? '' ?>" placeholder="<?= $arrayErrors['password-error'] ?? 'password' ?>" aria-label="password" aria-describedby="password" name="password">
                            </div>

                            <div class="row mb-1">
                                <span class="col-1 my-auto" id="basic-addon1"> <?= $arrayErrors['confirm-password'] ?? '<i class="bi bi-shield-lock-fill"></i>' ?></span>
                                <input type="password" class="col form-control rounded-pill <?= $arrayErrors['danger'] ?? '' ?>" placeholder="<?= $arrayErrors['confirm-password-error'] ?? 'confirm-password' ?>" aria-label="confirm-password" aria-describedby="confirm-password" name="confirm-password">
                            </div>


                            <!-- Procrastimon part -->
                            <div class="row">
                                <span class="col-1 my-auto" id="basic-addon1"> <?= $arrayErrors['procrastimon'] ?? '<i class="bi bi-emoji-laughing-fill"></i>' ?></span>
                                <input type="text" class="col form-control rounded-pill <?= $arrayErrors['danger'] ?? '' ?>" placeholder="Procrastimon's name" aria-label="procrastimon" aria-describedby="procrastimon" name="procrastimon" value="<?= $name ?? '' ?><?= $arrayErrors['procrastimon-error'] ?? '' ?>">
                            </div>

                            <!-- submit -->
                            <div class="text-center m-3">
                                <input type="submit" class="btn btn-outline-info fw-bold rounded-pill g-recaptcha" value="let's go!" data-sitekey="6Lfv6xwlAAAAAPBgq_F5vme5N36xVvFKhbLXTJVo" data-callback='onSubmit' data-action='submit'>
                                <a href="controller-start.php" class="btn btn-outline-secondary fw-bold rounded-pill ">Cancel</a>

                            </div>
                        </form>
                    </div>
                </div>

            </div>


        <?php } else { ?>

            <div class="row start justify-content-center align-items-end">
                <img src="../assets/img/banner.png" alt="">
                <div class="col-7 text-center">
                    <!-- Bouton LOAD GAME -->
                    <button class="btn btnStart rounded-pill border border-light border-5 m-1" data-bs-toggle="modal" data-bs-target="#modalLogin">
                        LOAD GAME
                    </button>
                    <!-- Bouton NEW GAME -->
                    <a href="controller-start.php?newGame" class="btn btnStart  rounded-pill border border-light border-5 m-1">
                        NEW GAME
                    </a>
                </div>
            </div>

            <!-- Modal Login-->
            <div class="modal fade <?= !empty($errorsLogin) ? 'openModal' : '' ?> " id="modalLogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered">

                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <!-- REPRENDRE SA PARTIE EN COURS -->
                        <div class="modal-content  rounded-5 border border-light border-5">
                            <div class="modal-body p-0">
                                <div class="row login img-fluid rounded-top-5 mx-auto pt-2 pb-1">
                                    <div class="col">
                                        <img src="<?= $sprite->sprite ?>" alt="" class="img-fluid">
                                    </div>
                                    <div class="col-7">
                                        <div class="text-white fw-bold">
                                            <?= $procrastimon->name ?> (lvl <?= $procrastimon->level ?>)
                                        </div>
                                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="<?= $procrastimon->hp ?>" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar barPV" style="width: <?= $procrastimon->hp ?>%"><?= $procrastimon->hp ?>/100</div>
                                        </div>
                                        <div class="progress mb-5" role="progressbar" aria-label="Info example" aria-valuenow="<?= $procrastimon->exp ?>" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar barPP" style="width: <?= $procrastimon->exp ?>%"><?= $procrastimon->exp ?>/100</div>
                                        </div>
                                        <span class="badge ms-2 mt-2 rounded-pill text-bg-primary">Goals : <?= $numberOfGoals ?> </span>
                                        <span class="badge ms-2 mt-2 rounded-pill text-bg-secondary">Todos : <?= $numberOfTodos ?> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer pt-2">
                                <a href="controller-home.php" class="btn btn-outline-info rounded-pill ">Let's go</a>
                                <button type="button" class="btn btn-outline-secondary rounded-pill fw-bold" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>

                    <?php } else { ?>
                        <!-- LOG IN APRES DECONNECTION -->
                        <div class="modal-content rounded-5 border border-light border-5">
                            <form method="post" action="" id="loginForm">
                                <div class="modal-body">
                                    <div class="row mb-1">
                                        <span class="col-1 my-auto" id="errorLogin"><?= $errorsLogin['login'] ?? '<i class="bi bi-person-circle"></i>' ?></span>
                                        <input id="login" type="text" class="col form-control rounded-pill <?= $errorsLogin['danger'] ?? '' ?>" placeholder="<?= $errorsLogin['login-error'] ?? 'Login' ?>" aria-label="login" aria-describedby="login" name="user" value="<?= $login ?? '' ?>">
                                    </div>

                                    <div class="row mb-3">
                                        <span class="col-1 my-auto" id="errorPassword"> <?= $errorsLogin['password'] ?? '<i class="bi bi-shield-lock"></i>' ?></span>
                                        <input id="password" type="password" class="col form-control rounded-pill <?= $errorsLogin['danger'] ?? '' ?>" placeholder="<?= $errorsLogin['password-error'] ?? 'password' ?>" aria-label="password" aria-describedby="user-password" name="user-password">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-outline-info rounded-pill">Let's go</button>
                                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>

                    <?php } ?>
                </div>
            </div>

        <?php } ?>
    </div>

</main>

<footer>
    <nav class="navbar start options fixed-bottom justify-content-center" tabindex="1">
        <button type="button" class="btn btnML text-light">Mentions légales</button>
    </nav>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="../assets/js/app.js"></script>

</body>