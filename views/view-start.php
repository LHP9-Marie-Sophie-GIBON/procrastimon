<?php include 'components/head.php'; ?>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    function onSubmit(token) {
        document.getElementById("demo-form").submit();
    }
</script>

<main>
    <?php if (isset($_GET['newGame'])) { ?>
        <div class="container mt-3 p-3">
            <form action="" method="post" id="demo-form">

                <!-- user part -->
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['login'] ?? '<i class="bi bi-person-circle"></i>' ?></span>
                    <input type="text" class="form-control" placeholder="Login" aria-label="login" aria-describedby="login" name="login" value="<?= $login ?? '' ?><?= $message ?? '' ?>">
                </div>


                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['mail'] ?? '<i class="bi bi-envelope-fill"></i>' ?></span>
                    <input type="text" class="form-control" placeholder="Mail" aria-label="mail" aria-describedby="mail" name="mail" value="<?= $mail ?? '' ?>">
                </div>


                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['password'] ?? '<i class="bi bi-shield-lock"></i>' ?></span>
                    <input type="password" class="form-control" placeholder="password" aria-label="password" aria-describedby="password" name="password">
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['confirm-password'] ?? '<i class="bi bi-shield-lock-fill"></i>' ?></span>
                    <input type="password" class="form-control" placeholder="confirm-password" aria-label="confirm-password" aria-describedby="confirm-password" name="confirm-password">
                </div>


                <!-- Procrastimon part -->
                <div class="mb-3">
                    <!-- <label for="procrastimon">Name your procrastimon</label> -->
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['procrastimon'] ?? '<i class="bi bi-emoji-laughing-fill"></i>' ?></span>
                        <input type="text" class="form-control" placeholder="Procrastimon's name" aria-label="procrastimon" aria-describedby="procrastimon" name="procrastimon" value="<?= $name ?? '' ?>">
                    </div>
                </div>



                <!-- submit -->
                <div>
                    <input type="submit" class="btn btn-outline-light g-recaptcha" value="let's go!" data-sitekey="6Lfv6xwlAAAAAPBgq_F5vme5N36xVvFKhbLXTJVo" data-callback='onSubmit' data-action='submit'>
                    <button class="btn btn-outline-light"><a href="controller-start.php">return</a></button>

                </div>
            </form>
        </div>

    <?php } else { ?>
        <div class="row justify-content-center">
            <button class="col-3 btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#modalLogin">
                LOAD GAME
            </button>
        </div>
        <div class="row justify-content-center">
            <button class="col-3 btn btn-outline-light">
                <a href="controller-start.php?newGame">
                    NEW GAME
                </a>
            </button>
        </div>

        <!-- Modal Login-->
        <div class="modal fade <?= !empty($arrayErrors) ? 'openModal' : '' ?> " id="modalLogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <?php
                        if (isset($_SESSION['user_id'])) {
                            echo '
                        <div class="row progressbar">
                            <div class="col">
                                <img src="' . $sprite->sprite . '" alt="" class="img-fluid">
                            </div>
                            <div class="col-7">
                                <div>
                                    ' . $procrastimon->name . ' (lvl ' . $procrastimon->level . ')
                                </div>
                                <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="' . $procrastimon->hp . '" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar barPV" style="width: ' . $procrastimon->hp . '%"></div>
                                </div>
                                <div class="progress" role="progressbar" aria-label="Info example" aria-valuenow="' . $procrastimon->exp . '" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar barPP" style="width: ' . $procrastimon->exp . '%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button class="btn btn-outline-light">
                                <a href="controller-home.php"><img src="https://img.icons8.com/sf-black-filled/18/FFFFFF/play.png"/></a>
                            </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Return</button>
                    </div>
                    ';
                        } else { ?>

                            <div class="row justify-content-center">
                                <form method="post" action="" id="loginForm">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="errorLogin"><?= $arrayErrors['login'] ?? '<i class="bi bi-person-circle"></i>' ?></span>
                                        <input id="login" type="text" class="form-control" placeholder="Login" aria-label="login" aria-describedby="login" name="login" value="<?= $login ?? '' ?>">
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="errorPassword"> <?= $arrayErrors['password'] ?? '<i class="bi bi-shield-lock"></i>' ?></span>
                                        <input id="password" type="password" class="form-control" placeholder="password" aria-label="password" aria-describedby="password" name="password">
                                    </div>
                                    <button type="submit" class="col-3 btn btn-outline-light">
                                        Log in
                                    </button>
                                </form>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Return</button>
                    </div>
                <?php
                        }
                ?>

                </div>
            </div>
        </div>
    <?php } ?>
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script>
    // creation de l'objet openModal, nous ciblons la classe openModal
    let openModal = new bootstrap.Modal(document.querySelector('.openModal'), {
        keyboard: false
    })
    // nous l'ouvrons avec la methode show()
    openModal.show()
</script>

</body>