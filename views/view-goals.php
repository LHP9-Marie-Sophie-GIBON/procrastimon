<?php include 'components/head.php'; ?>

<body>
    <!-- mise en place du Header -->
    <?php include 'components/header-task.php'; ?>

    <!-- mise en place du menu -->
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
                                    <option value="body">Body</option>
                                    <option value="mind">Mind</option>
                                    <option value="work">Work</option>
                                    <option value="other">other</option>
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
                            <div>
                                <button type="submit" class="btn btn-secondary" value="Add new Goal">Save</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Affichage des goals -->
        <div class="container">
            <?php
            $goalsList = $goal->getGoals();

            foreach ($goalsList as $goal) { ?>
                <div class="row <?= $success ?? '' ?>">
                    <button type="button" class="btn col-1" id="<?= $goal['id'] ?>" data-bs-toggle="modal" data-bs-target="#confirmationModal"><img src="https://img.icons8.com/color-glass/28/null/checked.png" /></button>
                    <div class="col"><?= $goal['name'] ?></div>
                    <button type="button" class="col-2 btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#modal<?= $goal['id'] ?>"><img src="https://img.icons8.com/ios-glyphs/20/null/visible--v1.png" /></button>
                    <button type="button" class="col-2 btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmationModalBis"><i class="bi bi-trash3-fill"></i></button>
                </div>

                <!-- modal d'informations -->
                <div class="modal fade" id="modal<?= $goal['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <p>Goal : <?= $goal['name'] ?></p>
                                <p>Category : <?= $goal['category'] ?></p>
                                <p>Creation : <?= $goal['creation'] ?></p>
                                <p>Due Date : <?= $goal['due_date'] ?></p>
                                <p>Time left :
                                    <?php
                                    // déterminer le nombre de jour restant jusqu'à duedate
                                    $date = new DateTime($goal['due_date']);
                                    $now = new DateTime();
                                    $interval = $date->diff($now);
                                    $days = $interval->format('%a');
                                    echo $days . ' days';
                                    ?>
                                </p>
                                <p>Comments : </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- modal de confirmation checked-->
                <div class="modal fade" id="confirmationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                <div class="modal fade" id="confirmationModalBis" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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

            <!-- modal D-day -->
            <div class="modal fade <?= $Dday['result'] ?? ''?>" id="modalDday" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            Have you achieved your goal ?
                        </div>
                        <div class="modal-footer">
                            <a href="controller-goals.php?statute=success">
                                <button type="button" name="success" class="btn btn-primary">Yes</button>
                            </a>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    No
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="controller-goals.php?statute=reset">Reset</a></li>
                                    <li><a class="dropdown-item" href="controller-goaks.php?statute=drop">Drop</a></li>
                                </ul>
                                <button type="button" class="btn btn-secondary">No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>






    </main>

    <!-- mise en place du footer -->

    <?php include 'components/footer-task.php'; ?>

    <script>
        // creation de l'objet openModal, nous ciblons la classe openModal
        let openModal = new bootstrap.Modal(document.querySelector('.openModal'), {
            keyboard: false
        })
        // nous l'ouvrons avec la methode show()
        openModal.show()
    </script>


</body>