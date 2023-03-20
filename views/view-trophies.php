<?php include 'components/head.php'; ?>

<body>
    <!-- mise en place du Header -->
    <?php include 'components/header-trophies.php'; ?>

    <main>
        <div class="container">
            <div class="row ">
                <?php if (isset($_GET['history'])) {
                    // Liste des Goals complétés
                    if (empty($goalsList)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <p class="text-center">You didn't complete any goals yet !</p>
                        </div>
                    <?php
                    } else { ?>
                        <p>Goals achieved : </p>
                        <?php foreach ($goalsList as $goal) { ?>
                            <div class="mb-1"><?= $goal['creation'] ?> : Goal "<?= $goal['name'] ?>" completed the <?= $goal['achievement_day'] ?> </div>
                        <?php  }
                    }
                    // Liste des todos complétées
                    if (empty($todosList)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <p class="text-center">You didn't complete any tasks yet !</p>
                        </div>
                    <?php
                    } else { ?>
                        <p>To-Dos completed : </p>
                        <?php foreach ($todosList as $todo) { ?>
                            <div class="mb-1 text-muted"><?= $todo['creation'] ?> : To-do "<?= $todo['name'] ?>" </div>
                        <?php }
                    }
                    // Liste des goals et todos inachevées
                    if ($missedGoals) { ?>
                    <p>Goals missed : </p>
                        <?php foreach ($missedGoals as $missedGoal) ?>
                        <div class="mb-1 text-muted"><?= $missedGoal['creation'] ?> : Goal "<?= $missedGoal['name'] ?>" </div>
                    <?php }

                    if ($missedTodos) { ?>
                    <p>To-dos missed : </p>
                    <?php foreach ($missedTodos as $missedTodo) ?>
                    <div class="mb-1 text-muted"><?= $missedTodo['creation'] ?> : To-do "<?= $missedTodo['name'] ?>" </div>
                    <?php }
                } elseif ($empty) { ?>
                    <div class="alert alert-danger" role="alert">
                        <p class="text-center">You don't have any trophy yet !</p>
                    </div>

                <?php } else { ?>
                    <?php foreach ($trophiesList as $trophy) { ?>
                        <div class="col-2 text-center">
                            <img src="https://img.icons8.com/fluency/48/null/trophy.png" />
                            <p><?= $trophy['title'] ?></p>
                            <p>(<?= $trophy['creation'] ?>)</p>

                        </div>
                    <?php } ?>
            </div>
        <?php } ?>
        </div>

    </main>

    <!-- mise en place du footer -->
    <?php include 'components/footer-trophies.php'; ?>

    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>