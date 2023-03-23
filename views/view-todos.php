<?php include 'components/head.php'; ?>

<body>
    <!-- mise en place du Header -->
    <?php include 'components/header.php'; ?>

    <!-- modal de formulaire -->
    <div class="modal fade <?= !empty($arrayErrors) ? 'openModal' : '' ?>" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title">Add a new task</h5>
                    <form class="container" method="post" id="formtask">

                        <label for="task">Description : </label>
                        <div class="input-group mb-3">
                            <span class="input-group-text task" id="basic-addon1"> <?= $arrayErrors['task'] ?? '<i class="bi bi-star-fill"></i>' ?></span>
                            <input type="text" class="form-control" placeholder="" aria-label="task" aria-describedby="task" name="task">
                        </div>

                        <label for="task_priority_level">Choose a priority level : </label>
                        <div class="input-group mb-3">
                            <span class="input-group-text task_priority_level" id="basic-addon2"><?= $arrayErrors['task_priority_level'] ?? '<i class="bi bi-filter-circle"></i>' ?></span>
                            <select name="task_priority_level" id="task_priority_level">
                                <option value="default" selected disabled></option>
                                <option value="1">Must do now (due today) </option>
                                <option value="2">Should do soon (2 days)</option>
                                <option value="3">Could do later (4 days)</option>
                            </select>
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
    <div class="modal fade <?= $_SESSION['newTask'] ? 'openModal' : '' ?>" id="confirmMyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title">Confirm you new task : </h5>
                    <p> Description : <?= $_SESSION['newTask']['task'] ?></p>
                    <p> Task priority level :
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
                    <div>
                        <a href="controller-todos.php?newTask"><button class="btn btn-secondary">Save</button> </a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- mise en place de la page TO DO LIST -->
    <main>
        <div class="h2 text-center text-white fw-bold m-2">TO-DO List</div>
        <?php if ($empty) { ?>
            <!-- Liste des todos vide -->
            <div class="container">
                <div class="alert alert-danger" role="alert">
                    <p class="text-center">You don't have any task yet !</p>
                </div>
            </div>

        <?php } elseif ($expiredTodos) { ?>
            <!-- Liste des todos expirées -->
            <div class="container">
                <div class="alert alert-danger" role="alert">
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
            <div class="container Todolist">
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
                    } else if ($days == 1) {
                        $priority = "warning";
                        $timeleft = "$days days";
                    } else {
                        $priority = "info";
                        $timeleft = "$days days";
                    }
                ?>
                    <div class="row rounded-pill tasks border border-light border-5">

                        <button class="btn" value="checked" id="<?= $task['id'] ?>" data-bs-toggle="modal" data-bs-target="#confirmationModal<?= $task['id'] ?>"><img src="https://img.icons8.com/sf-black/35/24f5af/ok.png" /></button>

                        <div class="col fw-bold my-auto">
                            <?= $task['name'] ?>
                            <span class="badge rounded-pill text-white text-bg-<?= $priority ?>"><?= $timeleft ?></span>
                        </div>

                        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#modal<?= $task['id'] ?>"><img src="https://img.icons8.com/sf-black-filled/35/acccfc/about.png" /></button>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmationModalBis<?= $task['id'] ?>"><img src="https://img.icons8.com/fluency/30/null/delete-forever.png" /></button>
                    </div>

                    <!-- modal d'informations -->
                    <div class="modal fade" id="modal<?= $task['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <p>Description : <?= $task['name'] ?></p>
                                    <p>task_priority_level :
                                        <?php
                                        if ($task['task_priority_level'] == 1) {
                                            echo 'Must Do Now';
                                        } elseif ($task['task_priority_level'] == 2) {
                                            echo 'Should Do Soon';
                                        } elseif ($task['task_priority_level'] == 3) {
                                            echo 'Could Do Later';
                                        }
                                        ?>
                                    </p>
                                    <p>Creation : <?= $task['creation'] ?></p>
                                    <p>Due Date : <?= $task['due_date'] ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- modal de confirmation checked-->
                    <div class="modal fade" id="confirmationModal<?= $task['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    Are your sure ?
                                </div>
                                <div class="modal-footer">
                                    <form action="controller-todos.php" method="post">
                                        <input type="hidden" name="taskId" value="<?= $task['id'] ?>">
                                        <button type="submit" name="checked" class="btn btn-primary">Yes</button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- modal de confirmation delete -->
                    <div class="modal fade" id="confirmationModalBis<?= $task['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    Are your sure ?
                                </div>
                                <div class="modal-footer">
                                    <form action="" method="post">
                                        <input type="hidden" name="taskId" value="<?= $task['id'] ?>">
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