<?php

include 'components/head.php';

?>

<body>
    <div class="container mt-3 p-3">
        <form action="" method="post">

            <!-- user part -->
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['login'] ?? '<i class="bi bi-person-circle"></i>' ?></span>
                <input type="text" class="form-control" placeholder="Login" aria-label="login" aria-describedby="login" name="login" value="<?= $login ?? '' ?>">
            </div>


            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['mail'] ?? '<i class="bi bi-envelope-fill"></i>' ?></span>
                <input type="text" class="form-control" placeholder="Mail" aria-label="mail" aria-describedby="mail" name="mail" value="<?= $mail ?? '' ?>">
            </div>


            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['password'] ?? '<i class="bi bi-shield-lock"></i>' ?></span>
                <input type="password" class="form-control" placeholder="password" aria-label="password" aria-describedby="password" name="password">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['confirm-password'] ?? '<i class="bi bi-shield-lock-fill"></i>' ?></span>
                <input type="password" class="form-control" placeholder="confirm-password" aria-label="confirm-password" aria-describedby="confirm-password" name="confirm-password">
            </div>


            <!-- Procrastimon part -->
            <div class="mb-3">
                <!-- <label for="procrastimon">Name your procrastimon</label> -->
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['procrastimon'] ?? '<i class="bi bi-emoji-laughing-fill"></i>' ?></span>
                    <input type="text" class="form-control" placeholder="Procrastimon's name" aria-label="procrastimon" aria-describedby="procrastimon" name="procrastimon" value="<?= $name ?? '' ?>">
                </div>
            </div>


            <!-- task part -->
            <!-- <div class="mb-3">
                <label for="todo">Create your first task in your to-do list</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['todo'] ?? '<i class="bi bi-list-task"></i>' ?></span>
                    <input type="text" class="form-control" placeholder="" aria-label="todo" aria-describedby="todo" name="todo" value="<?= $todo ?? '' ?>">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon2"><?= $arrayErrors['priority'] ?? '<i class="bi bi-patch-exclamation"></i>' ?></span>
                    <select name="priority" id="priority">
                        <option value="default" selected disabled>Priority</option>
                        <option value="1">Important & urgent (1 day) </option>
                        <option value="2">Important but not urgent (2 days)</option>
                        <option value="3">Neither (3 days)</option>
                    </select>
                </div>

            </div>

            <div class="mb-3">
                <label for="goal">Create your first goal</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['goal'] ?? '<i class="bi bi-star-fill"></i>' ?></span>
                    <input type="text" class="form-control" placeholder="" aria-label="goal" aria-describedby="goal" name="goal" value="<?= $goal ?? '' ?>">
                </div>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon2"><?= $arrayErrors['category'] ?? '<i class="bi bi-filter-circle"></i>' ?></span>
                    <select name="category" id="category">
                        <option value="default" selected disabled>Category</option>
                        <option value="body">Body</option>
                        <option value="mind">Mind</option>
                        <option value="work">Work</option>
                        <option value="other">other</option>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon2"><?= $arrayErrors['due_date'] ?? '<i class="bi bi-hourglass"></i>' ?></span>
                    <select name="due_date" id="due_date">
                        <option value="default" selected disabled>Due date</option>
                        <option value="1">1 month</option>
                        <option value="2">6 month</option>
                        <option value="3">1 year</option>
                    </select>
                </div> -->

            </div>


            <!-- submit -->
            <div>
                <input type="submit" class="btn btn-primary" value="let's go!">

            </div>
        </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>