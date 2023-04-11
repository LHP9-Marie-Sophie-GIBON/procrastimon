<?php include 'components/head.php'; ?>

<body>
    <!-- mise en place du Header -->
    <?php include 'components/header.php'; ?>

    <!-- mise en place du loader -->
    <?php include 'components/loader.php'; ?>

    <!-- mise en place du  levelup  -->
    <?php include 'components/levelup.php'; ?>


    <!-- modal de formulaire -->
    <div class="modal fade <?= !empty($arrayErrors) ? 'openModal' : '' ?>" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-5 border border-light border-5">
                <form class="container" method="post" id="formGoal">
                    <div class="modal-body">
                        <h5 class="modal-title">Add a new Goal</h5>


                        <div class="row mb-1">
                            <span class="col-1 my-auto goal" id="basic-addon1"> <?= $arrayErrors['goal'] ?? '<i class="bi bi-star-fill"></i>' ?></span>
                            <input type="text" class="col form-control rounded-pill <?= $arrayErrors['danger'] ?? '' ?>" placeholder="<?= $arrayErrors['goal-missing'] ?? 'Description' ?>" aria-label="goal" aria-describedby="goal" name="goal">
                        </div>

                        <div class="row mb-1">
                            <span class="col-1 my-auto category" id="basic-addon2"><?= $arrayErrors['category'] ?? '<i class="bi bi-filter-circle"></i>' ?></span>
                            <select class="col form-control rounded-pill <?= $arrayErrors['danger'] ?? '' ?> " name="category" id="category">
                                <option value="default" selected disabled><?= $arrayErrors['category-missing'] ?? 'Choose a category' ?></option>
                                <option value="1">Body</option>
                                <option value="2">Mind</option>
                                <option value="3">Work</option>
                                <option value="4">other</option>
                            </select>
                        </div>

                        <div class="row mb-1">
                            <span class="col-1 my-auto duedate" id="basic-addon2"><?= $arrayErrors['due_date'] ?? '<i class="bi bi-hourglass"></i>' ?></span>
                            <select class="col form-control rounded-pill <?= $arrayErrors['danger'] ?? '' ?> " name="due_date" id="due_date">
                                <option value="default" selected disabled ><?= $arrayErrors['duedate-missing'] ?? 'Choose a due date' ?></option>
                                <option value="1">1 month</option>
                                <option value="2">6 month</option>
                                <option value="3">1 year</option>
                            </select>
                        </div>

                        <div class="row">
                            <span class="col-1 my-auto comment" id="basic-addon2"><i class="bi bi-chat-left-text"></i></span>
                            <textarea class="col form-control rounded-5" placeholder="Add a comment" name="comment" id="comment" cols="30" rows="3"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-info rounded-pill" name="insert">Save</button>
                        <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal de confirmation -->
    <div class="modal fade <?= $_SESSION['newGoal'] ? 'openModal' : '' ?>" id="confirmMyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-5 border border-light border-5">
                <div class="modal-body">
                    <h5 class="modal-title mb-2">Do you want to add this you new goal ? </h5>
                    <p><span class="fw-bold">Description :</span> "<?= $_SESSION['newGoal']['goal'] ?>"</p>
                    <p><span class="fw-bold">Category :</span>
                        <?php
                        if ($_SESSION['newGoal']['category'] == 1) {
                            echo 'Body';
                        } elseif ($_SESSION['newGoal']['category'] == 2) {
                            echo 'Mind';
                        } elseif ($_SESSION['newGoal']['category'] == 3) {
                            echo 'Work';
                        } elseif ($_SESSION['newGoal']['category'] == 4) {
                            echo 'Other';
                        }
                        ?></p>
                    <p><span class="fw-bold">Due date :</span>
                        <?php

                        if ($_SESSION['newGoal']['due_date'] == 1) {
                            echo '1 month';
                        } elseif ($_SESSION['newGoal']['due_date'] == 2) {
                            echo '6 month';
                        } elseif ($_SESSION['newGoal']['due_date'] == 3) {
                            echo '1 year';
                        }
                        ?>
                    </p>
                    <p><span class="fw-bold">Comment :</span><?= $_SESSION['newGoal']['comment'] ?></p>
                </div>
                <div class="modal-footer">
                    <a href="goals.php?newGoal" class="btn btn-outline-info rounded-pill">Yes</a>
                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <!--mise en place de la page GOALS LIST -->
    <main>
        <div class="h2 text-center text-white fw-bold m-2">GOALS List</div>
        <?php if ($empty) { ?>
            <!-- Liste des goals vide -->
            <div class="container">
                <div class="alert alert-primary rounded-5 border-5" role="alert">
                    <p class="text-center my-auto fw-bold">You don't have any goal yet !</p>
                </div>
            </div>

        <?php } elseif ($expiredDate) { ?>
            <!-- Liste des goals expirés -->
            <div class="container">
                <div class="alert alert-danger rounded-5" role="alert">
                    <?php
                    foreach ($expiredDate as $expiredGoal) {
                        $procrastimon->removeHp(10, $procrastimon->id);
                        $goal->expiredGoal($expiredGoal['id']);
                    ?>
                        <p>Your goal : "<?= $expiredGoal['name'] ?>" is expired (due date : <?= $expiredGoal['due_date'] ?>) !</p>
                    <?php } ?>
                    <a href="goals.php?removehp" class="btn btn-danger rounded-pill">Next</a>
                </div>
            </div>

        <?php } else { ?>
            <div class="container Goallist">
                <?php
                foreach ($goalsList as $goal) {
                    // déterminer le nombre de jour restant jusqu'à duedate
                    $date = new DateTime($goal['due_date']);
                    $now = new DateTime();
                    $interval = $date->diff($now);
                    $days = ($interval->format('%a')) + 1;
                    // si $days == 0, echo "today"
                    if ($days <= 7) {
                        $priority = "danger";
                        $timeleft = 'today';
                    } else if ($days <= 30) {
                        $priority = "warning";
                        $timeleft = "$days days";
                    } else {
                        $priority = "info";
                        $timeleft = "$days days";
                    }
                ?>
                    <div class="row rounded-pill tasks border border-light border-5">
                        <button class="btn checked" value="checked" id="<?= $goal['id'] ?>" data-bs-toggle="modal" data-bs-target="#confirmationModal<?= $goal['id'] ?>"><img src="https://img.icons8.com/sf-black/35/24f5af/ok.png" /></button>
                        <div class="col-2 my-auto">
                            <?php displayCategory($goal['category']); ?>
                            <span class="badge rounded-pill text-white text-bg-<?= $priority ?>"><?= $timeleft ?></span>
                        </div>
                        <div class="col fw-bold my-auto">
                            <?= $goal['name'] ?>
                        </div>
                        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#modal<?= $goal['id'] ?>"><img src="https://img.icons8.com/sf-black-filled/35/acccfc/about.png" /></button>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmationModalBis<?= $goal['id'] ?>"><img src="https://img.icons8.com/fluency/30/null/delete-forever.png" /></button>
                    </div>

                    <!-- modal d'informations -->
                    <div class="modal fade" id="modal<?= $goal['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-5 border border-light border-5">
                                <div class="modal-body h4">
                                    <div class="modal-title mb-5">
                                        <?= $goal['name'] ?>
                                    </div>
                                    <p><span class="fw-bold">Creation :</span><?= $goal['creation'] ?></p>
                                    <p><span class="fw-bold">Category :</span>
                                        <!-- <?php displayCategory($goal['category']); ?> -->
                                        <?php
                                        $category = $goal['category'];
                                        if ($category === 1) {
                                            echo '<button class="btn body text-light" disabled>Body</button>';
                                        } elseif ($category === 2) {
                                            echo '<button class="btn mind text-light" disabled>Mind</button>';
                                        } elseif ($category === 3) {
                                            echo '<button class="btn work text-light" disabled>Work</button>';
                                        } elseif ($category === 4) {
                                            echo '<button class="btn other text-light" disabled>Other</button>';
                                        }
                                        ?>
                                    </p>
                                    <p><span class="fw-bold">Due-Date : </span><span class="badge rounded-pill text-white text-bg-<?= $priority ?>"><?= $timeleft ?></span> <span class="text-muted small">(<?= $goal['due_date'] ?>)</span> </p>
                                    <p><span class="fw-bold">Comments : </span><?= $goal['comments'] ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- modal de confirmation checked-->
                    <div class="modal fade" id="confirmationModal<?= $goal['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-5 border border-light border-5">
                                <div class="modal-body text-center">
                                    <p class="h4">Did you complete :</p>
                                    <p class="h3 fw-bold">"<?= $goal['name'] ?>"</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="goals.php" method="post">
                                        <input type="hidden" name="goalId" value="<?= $goal['id'] ?>">
                                        <button type="submit" name="checked" class="btn btn-outline-info rounded-pill">Yes</button>
                                    </form>
                                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- modal de confirmation delete -->
                    <div class="modal fade" id="confirmationModalBis<?= $goal['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-5 border border-light border-5">
                                <div class="modal-body text-center">
                                    <p class="h4">Are you sure, you want to delete :</p>
                                    <p class="h3 fw-bold">"<?= $goal['name'] ?>"</p>
                                    <p class="text-muted">Your procrastimon will take damages...</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="" method="post">
                                        <input type="hidden" name="goalId" value="<?= $goal['id'] ?>">
                                        <button type="submit" name="delete" class="btn btn-outline-info rounded-pill">Yes</button>
                                    </form>
                                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>

    </main>
<?php } ?>

<!-- TOASTS  -->
<div class="toast-container position-fixed top-50 start-0 translate-middle-y p-3">
    <!-- Toast addExp -->
    <div class="toast addexp <?= $message['addexp'] ?? '' ?> rounded-5 align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <p class="h6"><img src="https://img.icons8.com/emoji/28/null/glowing-star.png" /> <?= $procrastimon->name ?> won some exp !</p>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <!-- Toast removeHP -->
    <div class="toast removehp <?= $message['removehp'] ?? '' ?> rounded-5 align-items-center text-bg-danger border-0 top-0 start-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <p class="h6"><img src="https://img.icons8.com/color/28/null/bandage.png" /> <?= $procrastimon->name ?> got hurt ... </p>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- Toast trophés -->
<div class="toast-container trophy  position-fixed top-50 start-0 translate-middle-y p-3">
    <div class="toast <?= $message['trophy'] ?? '' ?> rounded-5 align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <p class="h6">Congrats, you just won a new trophy !</p>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    
</div>



<!-- mise en place du footer -->
<?php include 'components/footer.php'; ?>

<?= $Fonction ?? '' ?>
</body>