<?php

include 'components/head.php';

?>

<body>
    <div class="container p-5">
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
                <input type="text" class="form-control" placeholder="password" aria-label="password" aria-describedby="password" name="password">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['confirm-password'] ?? '<i class="bi bi-shield-lock-fill"></i>' ?></span>
                <input type="text" class="form-control" placeholder="confirm-password" aria-label="confirm-password" aria-describedby="confirm-password" name="confirm-password">
            </div>


            <!-- procrastimon part -->
            <div class="mb-3">
                <label for="procrastimon">Name your procrastimon</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['name'] ?? '<i class="bi bi-emoji-laughing-fill"></i>' ?></span>
                    <input type="text" class="form-control" placeholder="" aria-label="name" aria-describedby="name" name="name" value="<?= $procrastimon ?? '' ?>">
                </div>
            </div>
    

            <!-- task part -->
            <div class="mb-3">
                <label for="todo">Create your first task in your to-do list</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['todo'] ?? '<i class="bi bi-list-task"></i>' ?></span>
                    <input type="text" class="form-control" placeholder="" aria-label="todo" aria-describedby="todo" name="todo" value="<?= $todo ?? '' ?>">
                </div>
            </div>

            <div class="mb-3">
                <label for="goal">Create your first goal</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['goal'] ?? '<i class="bi bi-star-fill"></i>' ?></span>
                    <input type="text" class="form-control" placeholder="" aria-label="goal" aria-describedby="goal" name="goal" value="<?= $goal ?? '' ?>">
                </div>
            </div>


            <!-- submit -->
            <div>
                <input type="submit" class="btn btn-primary" value="let's go!">

            </div>
        </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>