<?php include 'components/head.php'; ?>

<body>
    <!-- mise en place du Header -->
    <?php include 'components/header-task.php'; ?>

    <!-- mise en place du menu -->
    <main>

        <!-- modal de formulaire -->
        <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5 class="modal-title">Add a new Goal</h5>
                        <form class="container" method="post" id="formGoal">

                            <label for="goal">Description : </label>
                            <div class="input-group mb-3">
                                <span class="input-group-text goal" id="basic-addon1"> <?= $arrayErrors['goal'] ?? '<i class="bi bi-star-fill"></i>' ?></span>
                                <input type="text" class="form-control" placeholder="" aria-label="goal" aria-describedby="goal" name="goal" value="<?= $name ?? '' ?>">
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
                <div class="row">

                    <button type="button" class="btn col-1" data-bs-toggle="modal" data-bs-target="#confirmationModal"><img src="https://img.icons8.com/color-glass/28/null/checked.png" /></button>
                    <div class="col"><?= $goal['name'] ?></div>
                    <div class="col-1"><?= $goal['category'] ?></div>
                    <div class="col"><?= $goal['due_date'] ?></div>
                    <button type="button" class="col-2 btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmationModalBis"><i class="bi bi-trash3-fill"></i></button>

                </div>

                <!-- modal de confirmation -->
                <div class="modal fade" id="confirmationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                Are your sure ?
                            </div>
                            <div class="modal-footer">
                                <form action="" method="post">
                                    <input type="hidden" name="goalId" value="<?= $goal['id'] ?>">
                                    <button type="submit" name="checked" class="btn btn-primary">Yes</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- modal de confirmationBis -->
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







    </main>

    <!-- mise en place du footer -->
    <?php include 'components/footer-task.php'; ?>
</body>