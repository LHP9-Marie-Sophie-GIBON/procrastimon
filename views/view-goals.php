<?php include 'components/head.php'; ?>

<body>
    <!-- mise en place du Header -->
    <?php include 'components/header-task.php'; ?>

    <!-- mise en place du menu -->
    <main>
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




    </main>

    <!-- mise en place du footer -->
    <?php include 'components/footer-task.php'; ?>
</body>