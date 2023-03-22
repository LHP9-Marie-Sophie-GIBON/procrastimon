<?php include 'components/head.php'; ?>

<body>

    <!-- mise en place du Header -->
    <?php include 'components/header.php'; ?>

    <!-- mise en place du menu -->
    <main>


        <div class="row character justify-content-center">
            <img src="<?= $sprite->sprite ?>" alt="character">
            <div class="oval"></div>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="modalOptions" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Profil</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Login : <?= $user->login ?> </p>
                    <p>Mail : <?= $user->mail ?> </p>
                    <p>Procrastimon's name : <?= $procrastimon->name ?></p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#modalEditProfil">
                        Edit your profil
                    </button>
                    <form action="../config/deconnect.php" method="post">
                        <button type="submit" class="btn btn-outline-light">
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Profil-->
    <div class="modal fade <?= !empty($arrayErrors) ? 'openModal' : '' ?>" id="modalEditProfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit you Profil</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">

                        <!-- user part -->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['login'] ?? '<i class="bi bi-person-circle"></i>' ?></span>
                            <input type="text" class="form-control" placeholder="Login" aria-label="login" aria-describedby="login" name="login" value="<?= $user->login ?>">
                        </div>


                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['mail'] ?? '<i class="bi bi-envelope-fill"></i>' ?></span>
                            <input type="text" class="form-control" placeholder="Mail" aria-label="mail" aria-describedby="mail" name="mail" value="<?= $user->mail ?>">
                        </div>


                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['oldPassword'] ?? '<i class="bi bi-shield-lock"></i>' ?></span>
                            <input type="password" class="form-control" placeholder="Old password" aria-label="oldPassword" aria-describedby="oldPassword" name="oldPassword">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['password'] ?? '<i class="bi bi-shield-lock-fill"></i>' ?></span>
                            <input type="password" class="form-control" placeholder="New password" aria-label="password" aria-describedby="password" name="password">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['password'] ?? '<i class="bi bi-shield-lock-fill"></i>' ?></span>
                            <input type="password" class="form-control" placeholder="Confirm password" aria-label="password" aria-describedby="password" name="confirmPassword">
                        </div>


                        <!-- Procrastimon part -->
                        <div class="mb-3">
                            <!-- <label for="procrastimon">Name your procrastimon</label> -->
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['procrastimon'] ?? '<i class="bi bi-emoji-laughing-fill"></i>' ?></span>
                                <input type="text" class="form-control" placeholder="Procrastimon's name" aria-label="procrastimon" aria-describedby="procrastimon" name="procrastimon" value="<?= $procrastimon->name ?>">
                            </div>
                        </div>

                        <!-- submit -->
                        <div>
                            <input type="submit" class="btn btn-outline-primary" value="Save">
                            <input type="button" class="btn btn-outline-secondary" value="Return" data-bs-dismiss="modal" aria-label="Close">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- mise en place du footer -->
    <footer>
        <?php include 'components/footer.php'; ?>
    </footer>
    

    <script>
    // creation de l'objet openModal, nous ciblons la classe openModal
    let openModal = new bootstrap.Modal(document.querySelector('.openModal'), {
        keyboard: false
    })
    // nous l'ouvrons avec la methode show()
    openModal.show()
</script>
</body>