<?php include 'components/head.php'; ?>

<body>
    <!-- mise en place du Header -->
    <?php include 'components/header.php'; ?>

    <!-- mise en place du loader -->
    <?php include 'components/loader.php'; ?>

    <!-- modal de formulaire -->
    <div class="modal fade <?= !empty($arrayErrors) ? 'openModal' : '' ?>" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content rounded-5 border border-light border-5">
                <form class="container" method="post" id="formtask">
                    <div class="modal-body">
                        <h5 class="modal-title">Add a new task</h5>


                        <div class="row mb-1">
                            <span class="col-1 my-auto task" id="basic-addon1"> <?= $arrayErrors['task'] ?? '<i class="bi bi-star-fill"></i>' ?></span>
                            <input type="text" class="col form-control rounded-pill" placeholder="Description" aria-label="task" aria-describedby="task" name="task">
                        </div>

                        <div class="row mb-3">
                            <span class="col-1 my-auto task_priority_level" id="basic-addon2"><?= $arrayErrors['task_priority_level'] ?? '<i class="bi bi-filter-circle"></i>' ?></span>
                            <select class="col form-control rounded-pill" name="task_priority_level" id="task_priority_level">
                                <option value="default" selected disabled>Choose a priority level</option>
                                <option value="1">Must do now (due today) </option>
                                <option value="2">Should do soon (2 days)</option>
                                <option value="3">Could do later (4 days)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-info rounded-pill" name="insert">Save</button>
                        <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal de confirmation -->
    <div class="modal fade <?= $_SESSION['newTask'] ? 'openModal' : '' ?>" id="confirmMyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-5 border border-light border-5">
                <div class="modal-body">
                    <h5 class="modal-title mb-2">Do you want to add this new task ? </h5>
                    <p><span class="fw-bold">Description :</span> "<?= $_SESSION['newTask']['task'] ?>"</p>
                    <p><span class="fw-bold">Task priority level :</span>
                        <?php
                        if ($_SESSION['newTask']['task_priority_level'] == 1) {
                            echo 'Must Do Now (1 day)';
                        } elseif ($_SESSION['newTask']['task_priority_level'] == 2) {
                            echo 'Should Do Soon (3 days)';
                        } elseif ($_SESSION['newTask']['task_priority_level'] == 3) {
                            echo 'Could Do Later (5 days)';
                        }
                        ?>
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="controller-todos.php?newTask" class="btn btn-outline-info rounded-pill">Yes</a>
                    <button type="button" class="btn btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <!-- mise en place de la page TO DO LIST -->
    <main>
        <div class="h2 text-center text-white fw-bold m-2">TO-DO List <?= $message['trophy'] ?? ''?></div>
        <?php if ($empty) { ?>
            <!-- Liste des todos vide -->
            <div class="container">
                <div class="alert alert-primary rounded-5" role="alert">
                    <p class="text-center">You don't have any task yet !</p>
                </div>
            </div>

        <?php } elseif ($expiredTodos) { ?>
            <!-- Liste des todos expirées -->
            <div class="container">
                <div class="alert alert-danger rounded-5" role="alert">
                    <p class="text-center">You have some expired tasks !</p>

                    <?php foreach ($expiredTodos as $expiredTodo) {
                        $procrastimon->removeHp(5, $procrastimon->id);
                        $todo->expiredTodo($expiredTodo['id']);
                    ?>

                        <p class="text-center">Your Task : "<?= $expiredTodo['name'] ?>" is expired (due day : <?= $expiredTodo['due_date'] ?>) </p>

                    <?php } ?>
                    <a href="controller-todos.php" class="btn btn-danger">Next</a>
                </div>
            </div>

        <?php } else { ?>
            <!-- Affichage des tasks -->
            <div class="container Todolist ">
                <?php
                foreach ($todolist as $task) {
                    // déterminer le nombre de jour restant jusqu'à duedate
                    $date = new DateTime($task['due_date']);
                    $now = new DateTime();
                    $interval = $date->diff($now);
                    $days = $interval->format('%a');

                    // si $days == 0, echo "today"
                    if ($days == 0) {
                        $priority = "danger";
                        $timeleft = 'today';
                    } elseif ($days <= 1) {
                        $priority = "danger";
                        $timeleft = "$days day";
                    } elseif ($days <= 3) {
                        $priority = "warning";
                        $timeleft = "$days days";
                    } else {
                        $priority = "info";
                        $timeleft = "$days days";
                    }
                ?>
                    <div class="row rounded-pill tasks border border-light border-5 ">
                        <button class="btn checked" value="checked" id="<?= $task['id'] ?>" data-bs-toggle="modal" data-bs-target="#confirmationModal<?= $task['id'] ?>"><img src="https://img.icons8.com/sf-black/35/24f5af/ok.png" /></button>
                        <div class="col-2 my-auto"><span class="badge rounded-pill text-white text-bg-<?= $priority ?>"><?= $timeleft ?></span></div>
                        <div class="col fw-bold my-auto ">
                            <?= $task['name'] ?>
                        </div>
                        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#modal<?= $task['id'] ?>"><img src="https://img.icons8.com/sf-black-filled/35/acccfc/about.png" /></button>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmationModalBis<?= $task['id'] ?>"><img src="https://img.icons8.com/fluency/30/null/delete-forever.png" /></button>
                    </div>

                    <!-- modal d'informations -->
                    <div class="modal fade" id="modal<?= $task['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-5 border border-light border-5">

                                <div class="modal-body h4">
                                    <div class="modal-title mb-5"><?= $task['name'] ?></div>
                                    <p><span class="fw-bold">Creation :</span> <?= $task['creation'] ?></p>
                                    <p><span class="fw-bold">Task priority level :</span>
                                        <?php
                                        if ($task['task_priority_level'] == 1) {
                                            echo '<span class="text-danger">Must Do Now</span>';
                                        } elseif ($task['task_priority_level'] == 2) {
                                            echo '<span class="text-warning">Should Do Soon</span>';
                                        } elseif ($task['task_priority_level'] == 3) {
                                            echo '<span class="text-primary">Could Do Later</span>';
                                        }
                                        ?>
                                    </p>

                                    <p><span class="fw-bold">Due Date :</span> <span class="badge rounded-pill text-white text-bg-<?= $priority ?>"><?= $timeleft ?></span> <span class="small text-muted">(<?= $task['due_date'] ?>)</span> </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- modal de confirmation checked-->
                    <div class="modal fade" id="confirmationModal<?= $task['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-5 border border-light border-5">
                                <div class="modal-body text-center">
                                    <p class="h4">Did you complete :</p>
                                    <p class="h3 fw-bold">"<?= $task['name'] ?>"</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="controller-todos.php" method="post">
                                        <input type="hidden" name="taskId" value="<?= $task['id'] ?>">
                                        <button type="submit" name="checked" class="btn btn-outline-info rounded-pill">Yes</button>
                                    </form>
                                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- modal de confirmation delete -->
                    <div class="modal fade" id="confirmationModalBis<?= $task['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-5 border border-light border-5">
                                <div class="modal-body text-center">
                                    <p class="h4">Are you sure, you want to delete :</p>
                                    <p class="h3 fw-bold">"<?= $task['name'] ?>"</p>
                                    <p class="text-muted">Your procrastimon will take damages...</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="" method="post">
                                        <input type="hidden" name="taskId" value="<?= $task['id'] ?>">
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

<!-- TOAST trophé  -->
<div class="toast <?= $message['trophy'] ?? '' ?> rounded-5 pt-2 ps-2 ms-4 align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            <p class="h6">Congrats, you just won a new trophy !</p>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>





<!-- mise en place du footer -->
<?php include 'components/footer.php'; ?>

</body>