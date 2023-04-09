<?php include 'components/head.php'; ?>

<body>
    <!-- mise en place du loader -->
    <?php include 'components/loader.php'; ?>

    <!-- mise en place du Header -->
    <?php include 'components/header.php'; ?>



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
                    <a href="home.php?tutorial" type="button" class="btn btn-outline-success bg-white rounded-pill fw-bold col-6 m-1">
                        Show tutorial
                    </a>
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
    <div class="modal fade <?= $openModal ?? '' ?>" id="modalTutorial" data-bs-backdrop="static" tabindex="1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content rounded-5 border border-light border-5">

                <div class="modal-body">

                    <div id="carousel-gameover" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <h3>Welcome to <span class="tutorial_logo">Procrastimon</span> !</h3>
                                <p class="mb-0"> This website is designed to help you stay productive by gamifying your to-do list and goals. In this tutorial, we'll go over the features of Procrastimon and how to use them effectively.</p>
                            <div class="text-center">
                                <img src="../assets/img/background1.png" alt="" class="w-100">
                            </div>
                            </div>
                            <div class="carousel-item">
                                <div class="text-center mb-2">
                                    <span class="badge ms-2 mt-2 rounded-pill text-bg-secondary"><img src="https://img.icons8.com/sf-black-filled/48/FFFFFF/todo-list.png" /></span>
                                </div>
                                <p> <span class="fw-bold h5">The Todolist</span> is where you can add and manage your daily tasks. <br>
                                    To create a new task, simply click on
                                    <span class="badge rounded-pill text-bg-secondary"><img src="https://img.icons8.com/sf-black/18/FFFFFF/plus-math.png" /></span>
                                    and enter the details. You can also set a priority level for each task. <br>
                                    Once you've completed a task, make sure to check it off your list by clicking on <img src="https://img.icons8.com/sf-black/35/24f5af/ok.png"> next to the task.
                                </p>
                            </div>
                            <div class="carousel-item">
                                <div class="text-center mb-2">
                                    <span class="badge ms-2 mt-2 rounded-pill text-bg-secondary"><img src="https://img.icons8.com/external-yogi-aprelliyanto-basic-outline-yogi-aprelliyanto/48/FFFFFF/external-achievement-award-yogi-aprelliyanto-basic-outline-yogi-aprelliyanto-2.png" /></span>
                                </div>
                                <p><span class="fw-bold h5">The Goals</span> is where you can set long-term goals for yourself. <br>
                                    To create a new goal, click on
                                    <span class="badge rounded-pill text-bg-secondary"><img src="https://img.icons8.com/sf-black/18/FFFFFF/plus-math.png" /></span>
                                    and enter the details. You can set a deadline for each goal and add subtasks to help you break down the goal into manageable steps. <br>
                                    Once you've completed a goal, make sure to check it off your list by clicking on <img src="https://img.icons8.com/sf-black/35/24f5af/ok.png"> next to the goal.
                                </p>
                            </div>
                            <div class="carousel-item">
                                <div class="text-center mb-2">
                                    <img src="<?= $sprite->sprite ?>" alt="character" style="height : 80px; ">
                                </div>
                                <p><span class="fw-bold h5">The Procrastimon</span> is a virtual pet that <span class="text-success">gains experience points</span> when you complete tasks and goals. 
                                However, if you don't or if you abandon (elete) one, your Procrastimon <span class="text-danger">will take damages</span> . <br>
                                    As your Procrastimon gains experience points, it will <span class="fw-bold">level up</span>  and unlock new features. <br>
                                 </p>
                                <p>When your Procrastimon reaches its maximum level, it will be sent to <span class="fw-bold h5">the Boarding Home</span><span class="badge rounded-pill text-bg-secondary"><img src="https://img.icons8.com/ios-glyphs/20/FFFFFF/house-with-a-garden.png" /></span>
                                    where you can access the history of all the goals you've completed with it.</p>
                            </div>
                            <div class="carousel-item">
                                <div class="text-center mb-2">
                                    <span class="badge ms-2 mt-2 rounded-pill text-bg-secondary"><img src="https://img.icons8.com/ios-filled/48/FFFFFF/laurel-wreath.png" /></span>
                                </div>
                                <p>As you complete tasks and goals, you'll earn <span class="fw-bold h5">trophies</span> that will be displayed in the trophies room. These rewards are a way to track your progress and motivate you to keep going. </p>
                                <p>In the Trophies room, you can also access <span class="fw-bold h5">the game's history</span> 
                                    <span class="badge rounded-pill text-bg-secondary"><img src="https://img.icons8.com/ios-glyphs/20/FFFFFF/repository.png"></span>.
                                    This feature allows you to review your progress, see the goals you've completed, and identify any patterns in your productivity. <br>
                                    Use this information to make adjustments and improve your workflow in the future.
                                </p>
                            </div>
                            <div class="carousel-item">
                                <p class="h5 mt-3">Now that you know the basics of Procrastimon, it's time to get started! Make sure to add your tasks and goals regularly to keep your Procrastimon healthy and happy. Good luck!</p>
                                <div class="text-center">
                                <img src="../assets/img/background2.png" alt="" class="w-100">
                            </div>
                                <div class="mt-5 text-center">
                                    <button type="button" class="btn btn-outline-info rounded-pill fw-bold" data-bs-dismiss="modal" aria-label="Close">let's play ! </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer p-0">
                        <button type="button" id="next" class="btn btn-outline-secondary rounded-pill border-5 fw-bold" data-bs-target="#carousel-gameover" data-bs-slide="next"> next
                        </button>
                    </div>

                </div>
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