<?php include 'components/head.php'; ?>

<body>

    <!-- mise en place du Header -->
    <?php include 'components/header.php'; ?>

    <!-- mise en place du loader -->
    <?php include 'components/loader.php'; ?>

    <!-- mise en place du menu -->
    <main>

        <div class="row character justify-content-center">
            <img src="<?= $sprite->sprite ?>" alt="character" id="myProcrastimon" onclick="changeMood()">
            <div class="oval"></div>
        </div>
    </main>


    <!-- Toasts -->
    <div class="toast-container">
        <!-- Toast new goals -->
        <div class="toast <?= $todayGoals ? 'openToast' : '' ?> rounded-5 pt-2 ps-2 ms-4 align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <p class="h6">Hello, you have some goals to achieved today !</p>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <!-- toast new todos -->
        <div class="toast <?= $todayTodos ? 'openToast' : '' ?> rounded-5 align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <p class="h6">Hello, you have some tasks to achieved today !</p>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <!-- Toast modification password-->
        <div class="toast <?= $toast['password'] ?? '' ?> rounded-5 align-items-center text-bg-info text-light fw-bold  border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <p class="h6">Password updated !</p>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <!-- Toast modification profil-->
        <div class="toast <?= $toast['profil'] ?? '' ?> rounded-5 align-items-center text-bg-info text-light fw-bold border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <p class="h6">Profil updated !</p>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Modal Profil-->
    <div class="modal fade" id="modalOptions" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-5 border border-light border-5">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Profil</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><span class="fw-bold">Login :</span> <?= $user->login ?> </p>
                    <p><span class="fw-bold">Mail :</span> <?= $user->mail ?> </p>
                    <p><span class="fw-bold">Procrastimon's name :</span> <?= $procrastimon->name ?></p>

                </div>
                <div class="row justify-content-center profil">
                    <button type="button" class="btn btn-outline-info rounded-pill fw-bold col-6 m-1" data-bs-toggle="modal" data-bs-target="#modalEditProfil">
                        Edit your profil
                    </button>
                    <button type="button" class="btn btn-outline-primary bg-white rounded-pill fw-bold col-6 m-1" data-bs-toggle="modal" data-bs-target="#modalEditPassword">
                        Change your password
                    </button>
                    <button type="button" class="btn btn-outline-danger bg-white rounded-pill fw-bold col-6 m-1" data-bs-toggle="modal" data-bs-target="#modalDeleteAccount">
                        Delete your account
                    </button>
                </div>
                <div class="modal-footer">

                    <form action="../config/deconnect.php" method="post">
                        <button type="submit" class="btn">
                            <img src="https://cdn.discordapp.com/attachments/1039537189169676388/1089815832785334292/icon-logout.png" alt="">

                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Profil-->
    <div class="modal fade <?= !empty($arrayErrors) ? 'openModal' : '' ?>" id="modalEditProfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-5 border border-light border-5">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit your Profil</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">

                        <!-- user part -->
                        <div class="row mb-1">
                            <span class="col-1 my-auto" id="basic-addon1"> <?= $arrayErrors['login'] ?? '<i class="bi bi-person-circle"></i>' ?></span>
                            <input type="text" class="col form-control rounded-pill <?= $arrayErrors['danger'] ?? '' ?>" placeholder="Login" aria-label="login" aria-describedby="login" name="login" value="<?= $user->login ?><?= $arrayErrors['login-error'] ?? '' ?>">
                        </div>


                        <div class="row mb-1">
                            <span class="col-1 my-auto" id="basic-addon1"> <?= $arrayErrors['mail'] ?? '<i class="bi bi-envelope-fill"></i>' ?></span>
                            <input type="text" class="col form-control rounded-pill <?= $arrayErrors['danger'] ?? '' ?>" placeholder="Mail" aria-label="mail" aria-describedby="mail" name="mail" value="<?= $user->mail ?><?= $arrayErrors['mail-error'] ?? '' ?>">
                        </div>


                        <!-- Procrastimon part -->
                        <div class="row mb-1">
                            <span class="col-1 my-auto" id="basic-addon1"> <?= $arrayErrors['procrastimon'] ?? '<i class="bi bi-emoji-laughing-fill"></i>' ?></span>
                            <input type="text" class="col form-control rounded-pill <?= $arrayErrors['danger'] ?? '' ?>"" placeholder=" Procrastimon's name" aria-label="procrastimon" aria-describedby="procrastimon" name="procrastimon" value="<?= $procrastimon->name ?><?= $arrayErrors['procrastimon-error'] ?? '' ?>">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-outline-info rounded-pill" value="Save">
                        <input type="button" class="btn btn-outline-secondary rounded-pill" value="Return" data-bs-dismiss="modal" aria-label="Close">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Password-->
    <div class="modal fade <?= !empty($passwordErrors) ? 'openModal' : '' ?>" id="modalEditPassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-5 border border-light border-5">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Change your password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">

                        <div class="row mb-1">
                            <span class="col-1 my-auto" id="basic-addon1"> <?= $passwordErrors['oldPassword'] ?? '<i class="bi bi-shield-lock"></i>' ?></span>
                            <input type="password" class="col form-control rounded-pill <?= $passwordErrors['danger'] ?? '' ?>" placeholder="<?= $passwordErrors['oldPassword-error'] ?? 'Old password' ?>" aria-label="oldPassword" aria-describedby="oldPassword" name="oldPassword">
                        </div>

                        <div class="row mb-1">
                            <span class="col-1 my-auto" id="basic-addon1"> <?= $passwordErrors['password'] ?? '<i class="bi bi-shield-lock-fill"></i>' ?></span>
                            <input type="password" class="col form-control rounded-pill <?= $passwordErrors['danger'] ?? '' ?>" placeholder="<?= $passwordErrors['password-error'] ?? 'New password' ?>" aria-label="password" aria-describedby="password" name="password">
                        </div>

                        <div class="row mb-1">
                            <span class="col-1 my-auto" id="basic-addon1"> <?= $passwordErrors['confirm-password'] ?? '<i class="bi bi-shield-lock-fill"></i>' ?></span>
                            <input type="password" class="col form-control rounded-pill <?= $passwordErrors['danger'] ?? '' ?>" placeholder="<?= $passwordErrors['confirm-password-error'] ?? 'Confirm password' ?>" aria-label="password" aria-describedby="password" name="confirmPassword">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-outline-info rounded-pill" value="Save">
                        <input type="button" class="btn btn-outline-secondary rounded-pill" value="Return" data-bs-dismiss="modal" aria-label="Close">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete Account-->
    <div class="modal fade" id="modalDeleteAccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-5 border border-light border-5">
                <form action="" method="post">
                    <div class="modal-body">
                        <p class="fw-bold h5 text-danger">Are you sure you want to delete your account?</p>
                        <p class="small text-danger">Deletion is irreversible.</p>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-outline-info rounded-pill" value="Yes" name="deleteAccount">
                        <input type="button" class="btn btn-outline-secondary rounded-pill" value="No" data-bs-dismiss="modal" aria-label="Close">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal tutorial -->
    <div class="modal fade <?= $openModal ?? '' ?>" id="modalTutorial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-5 border border-light border-5">

                <div class="modal-body">

                    <div id="carousel-gameover" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active text-center ">
                                <img src="<?= $sprite->sprite_happy ?>" alt="procrastimon" class="procrastimon">
                                <h1><?= $procrastimon->name ?> is a full grown up now !</h1>
                                <div class="h6">Time for him to go on a retrait well deserved !</div>
                            </div>
                            <div class="carousel-item text-center">
                                <img src="https://img.icons8.com/external-victoruler-flat-victoruler/64/null/external-stars-christmas-victoruler-flat-victoruler.png" />
                                <img src="https://img.icons8.com/external-victoruler-flat-victoruler/64/null/external-stars-christmas-victoruler-flat-victoruler.png" />
                                <img src="https://img.icons8.com/external-victoruler-flat-victoruler/64/null/external-stars-christmas-victoruler-flat-victoruler.png" />
                                <img src="https://img.icons8.com/external-victoruler-flat-victoruler/64/null/external-stars-christmas-victoruler-flat-victoruler.png" />
                                <div class="h3">Don't worry, you can always visit him at the boarding home </div>
                                <span class="badge text-bg-info rounded-pill"><img src="https://img.icons8.com/ios-glyphs/48/FFFFFF/house-with-a-garden.png" alt="icon Boarding-home"></span>
                            </div>
                            <div class="carousel-item text-center">
                                <div class="h3">Now, you can take care of a new procratimon, let's keep motivated !</div>
                                <img src="../assets/img/background1.png" alt="" class="d-lg-none w-100 mt-5">
                                <div class="mt-5">
                                    <button type="button" class="btn btn-outline-info rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal">Of course !</button>
                                    <button type="button" class="btn btn-outline-info rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal">I'll do my best !</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="next" class="btn btn-outline-secondary rounded-pill border-5 fw-bold" data-bs-target="#carousel-gameover" data-bs-slide="next"> next
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- mise en place du footer -->
    <footer>
        <?php include 'components/footer.php'; ?>
    </footer>

    <script>
        let regularSprite = '<?= $sprite->sprite ?>';
        let happySprite = '<?= $sprite->sprite_happy ?>';
        let angrySprite = '<?= $sprite->sprite_angry ?>';
    </script>
</body>