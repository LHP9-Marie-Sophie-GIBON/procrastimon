<?php include 'components/head.php'; ?>

<body>
    <!-- mise en place du Header -->
    <?php include 'components/header.php'; ?>

    <!-- s'il n'y a pas encore de goals -->
    <?php if ($empty) { ?>
        <div class="alert alert-danger" role="alert">
            <p class="text-center">You don't have any goal yet !</p>
        </div>
    <?php } else ?>

    <!-- mise en place des goals dont le due date est expiré -->
    <?php if ($expiredDate) { ?>

        <div class="alert alert-danger" role="alert">
            <?php
            foreach ($expiredDate as $expiredGoal) {
                $procrastimon->removeHp(10, $procrastimon->id);
                $goal->expiredGoal($expiredGoal['id']);
            ?>
                <p>Your goal : "<?= $expiredGoal['name'] ?>" is expired (due date : <?= $expiredGoal['due_date'] ?>) !</p>
            <?php } ?>
            <a href="controller-goals.php" class="btn btn-danger">Next</a>
        </div>
    <?php } else { ?>
        <!-- mise en place du menu principal-->
        <main>

            <!-- modal de formulaire -->
            <div class="modal fade <?= !empty($arrayErrors) ? 'openModal' : '' ?>" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h5 class="modal-title">Add a new Goal</h5>
                            <form class="container" method="post" id="formGoal">

                                <label for="goal">Description : </label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text goal" id="basic-addon1"> <?= $arrayErrors['goal'] ?? '<i class="bi bi-star-fill"></i>' ?></span>
                                    <input type="text" class="form-control" placeholder="" aria-label="goal" aria-describedby="goal" name="goal">
                                </div>

                                <label for="category">Choose a category : </label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text category" id="basic-addon2"><?= $arrayErrors['category'] ?? '<i class="bi bi-filter-circle"></i>' ?></span>
                                    <select name="category" id="category">
                                        <option value="default" selected disabled></option>
                                        <option value="1">Body</option>
                                        <option value="2">Mind</option>
                                        <option value="3">Work</option>
                                        <option value="4">other</option>
                                    </select>
                                </div>

                                <label for="due_date">Choose a due date : </label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text duedate" id="basic-addon2"><?= $arrayErrors['due_date'] ?? '<i class="bi bi-hourglass"></i>' ?></span>
                                    <select name="due_date" id="due_date">
                                        <option value="default" selected disabled></option>
                                        <option value="1">1 month</option>
                                        <option value="2">6 month</option>
                                        <option value="3">1 year</option>
                                    </select>
                                </div>

                                <label for="comment">Add a comment : </label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text comment" id="basic-addon2"><i class="bi bi-chat-left-text"></i></span>
                                    <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-secondary" name="insert">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- modal de confirmation -->
            <div class="modal fade <?= $_SESSION['newGoal'] ? 'openModal' : '' ?>" id="confirmMyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h5 class="modal-title">Confirm you new goal : </h5>
                            <p> Description : <?= $_SESSION['newGoal']['goal'] ?></p>
                            <p> Category :
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
                            <p> Due date :
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
                            <p> Comment : <?= $_SESSION['newGoal']['comment'] ?></p>
                            <div>
                                <a href="controller-goals.php?newGoal"><button class="btn btn-secondary">Save</button> </a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Affichage des goals -->
            <div class="container">
                <?php
                foreach ($goalsList as $goal) { ?>
                    <div class="row <?= $success ?? '' ?>">
                        <button type="button" class="btn col-1" id="<?= $goal['id'] ?>" data-bs-toggle="modal" data-bs-target="#confirmationModal<?= $goal['id'] ?>"><img src="https://img.icons8.com/color-glass/28/null/checked.png" /></button>
                        <div class="col"><?= $goal['name'] ?></div>
                        <div class="col">
                            <?php
                            // déterminer le nombre de jour restant jusqu'à duedate
                            $date = new DateTime($goal['due_date']);
                            $now = new DateTime();
                            $interval = $date->diff($now);
                            $days = $interval->format('%a');
                            // si $days == 0, echo "today"
                            if ($days == 0) {
                                echo 'today';
                            } else {
                                echo $days . ' days';
                            }

                            ?>
                        </div>
                        <button type="button" class="col-1 btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#modal<?= $goal['id'] ?>"><img src="https://img.icons8.com/ios-glyphs/20/null/visible--v1.png" /></button>
                        <button type="button" class="col-1 btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmationModalBis<?= $goal['id'] ?>"><i class="bi bi-trash3-fill"></i></button>
                    </div>

                    <!-- modal d'informations -->
                    <div class="modal fade" id="modal<?= $goal['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <p>Goal : <?= $goal['name'] ?></p>
                                    <p>Category :
                                        <?php
                                        if ($goal['category'] == 1) {
                                            echo 'Body';
                                        } elseif ($goal['category'] == 2) {
                                            echo 'Mind';
                                        } elseif ($goal['category'] == 3) {
                                            echo 'Work';
                                        } elseif ($goal['category'] == 4) {
                                            echo 'Other';
                                        }
                                        ?>
                                    </p>
                                    <p>Creation : <?= $goal['creation'] ?></p>
                                    <p>Due Date : <?= $goal['due_date'] ?></p>
                                    <p>Comments : <?= $goal['comments'] ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- modal de confirmation checked-->
                    <div class="modal fade" id="confirmationModal<?= $goal['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    Are your sure ?
                                </div>
                                <div class="modal-footer">
                                    <form action="controller-goals.php" method="post">
                                        <input type="hidden" name="goalId" value="<?= $goal['id'] ?>">
                                        <button type="submit" name="checked" class="btn btn-primary">Yes</button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- modal de confirmation delete -->
                    <div class="modal fade" id="confirmationModalBis<?= $goal['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    Are your sure ?
                                </div>
                                <div class="modal-footer">
                                    <form action="" method="post">
                                        <input type="hidden" name="goalId" value="<?= $goal['id'] ?>">
                                        <button type="submit" name="delete" class="btn btn-primary">Yes</button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>

        </main>
    <?php } ?>


    <!-- mise en place du footer -->
    <?php include 'components/footer.php'; ?>

    <script>
        // creation de l'objet openModal, nous ciblons la classe openModal
        let openModal = new bootstrap.Modal(document.querySelector('.openModal'), {
            keyboard: false
        })
        // nous l'ouvrons avec la methode show()
        openModal.show()
    </script>


</body>