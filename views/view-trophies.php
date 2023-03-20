<?php include 'components/head.php'; ?>

<body>
    <!-- mise en place du Header -->
    <?php include 'components/header-trophies.php'; ?>

    <main>
        <div class="container">
            <div class="row ">
                <?php if (isset($_GET['history'])) { ?>
                    <!-- mise en place du menu -->
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link <?= empty($goalsList) ? "disabled" : "" ?>" href="controller-trophies.php?CompletedGoals">Achieved Goals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= empty($todosList) ? "disabled" : "" ?>" href="controller-trophies.php?CompletedTodos">Achieved todos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= empty($missedGoals) ? "disabled" : "" ?>" href="controller-trophies.php?MissedGoals">Missed Goals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= empty($missedTodos) ? "disabled" : "" ?>" href="controller-trophies.php?MissedTodos">Missed todos</a>
                        </li>
                    </ul>

                    <!-- Liste des goals complétées -->
                    <?php if (empty($goalsList)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <p class="text-center">You didn't complete any goals yet !</p>
                        </div>
                    <?php } else { ?>
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


                } elseif (isset($_GET['CompletedGoals'])) { ?>
                    <!-- mise en place du menu -->
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link active" href="controller-trophies.php?CompletedGoals">Achieved Goals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= empty($todosList) ? "disabled" : "" ?>" href="controller-trophies.php?CompletedTodos">Achieved todos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= empty($missedGoals) ? "disabled" : "" ?>" href="controller-trophies.php?MissedGoals">Missed Goals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= empty($missedTodos) ? "disabled" : "" ?>" href="controller-trophies.php?MissedTodos">Missed todos</a>
                        </li>
                    </ul>
                    <!-- affichage des goals complétés -->
                    <div class="col-12">
                        <h1 class="text-center">Achieved Goals</h1>
                        <?php foreach ($goalsList as $goal) { ?>
                            <div class="mb-1"><?= $goal['creation'] ?> : Goal "<?= $goal['name'] ?>" completed the <?= $goal['achievement_day'] ?> </div>
                        <?php } ?>
                    </div>


                <?php } elseif (isset($_GET['CompletedTodos'])) { ?>
                    <!-- mise en place du menu -->
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link <?= empty($goalsList) ? "disabled" : "" ?>" href="controller-trophies.php?CompletedGoals">Achieved Goals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="controller-trophies.php?CompletedTodos">Achieved todos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= empty($missedGoals) ? "disabled" : "" ?>" href="controller-trophies.php?MissedGoals">Missed Goals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= empty($missedTodos) ? "disabled" : "" ?>" href="controller-trophies.php?MissedTodos">Missed todos</a>
                        </li>
                    </ul>
                    <!-- affichage des todos complétés -->
                    <div class="col-12">
                        <h1 class="text-center">Achieved todos</h1>
                        <?php foreach ($todosList as $todo) { ?>
                            <div class="mb-1 text-muted"><?= $todo['creation'] ?> : To-do "<?= $todo['name'] ?>" </div>
                        <?php } ?>
                    </div>

                <?php } elseif (isset($_GET['MissedGoals'])) { ?>
                    <!-- mise en place du menu -->
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link <?= empty($goalsList) ? "disabled" : "" ?>" href="controller-trophies.php?CompletedGoals">Achieved Goals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= empty($todosList) ? "disabled" : "" ?>" href="controller-trophies.php?CompletedTodos">Achieved todos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="controller-trophies.php?MissedGoals">Missed Goals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= empty($missedTodos) ? "disabled" : "" ?>" href="controller-trophies.php?MissedTodos">Missed todos</a>
                        </li>
                    </ul>
                    <!-- affichage des goals manqués -->
                    <div class="col-12">
                        <h1 class="text-center">Missed Goals</h1>
                        <?php foreach ($missedGoals as $missedGoal) { ?>
                            <div class="mb-1"><?= $missedGoal['creation'] ?> : Goal "<?= $missedGoal['name'] ?>" missed the <?= $missedGoal['deadline'] ?> </div>
                        <?php } ?>
                    </div>

                <?php } elseif (isset($_GET['MissedTodos'])) { ?>
                    <!-- mise en place du menu -->
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link <?= empty($goalsList) ? "disabled" : "" ?>" href="controller-trophies.php?CompletedGoals">Achieved Goals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= empty($todosList) ? "disabled" : "" ?>" href="controller-trophies.php?CompletedTodos">Achieved todos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= empty($missedGoals) ? "disabled" : "" ?>" href="controller-trophies.php?MissedGoals">Missed Goals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="controller-trophies.php?MissedTodos">Missed todos</a>
                        </li>
                    </ul>
                    <!-- affichage des todos manqués -->
                    <div class="col-12">
                        <h1 class="text-center">Missed todos</h1>
                        <?php foreach ($missedTodos as $missedTodo) { ?>
                            <div class="mb-1 text-muted"><?= $missedTodo['creation'] ?> : To-do "<?= $missedTodo['name'] ?>" </div>
                        <?php } ?>
                    </div>

                <?php } else if ($empty) { ?>
                    <div class="alert alert-danger" role="alert">
                        <p class="text-center">You don't have any trophy yet !</p>
                    </div>

                <?php } else if ($trophiesList) { ?>
                    <?php foreach ($trophiesList as $trophy) { ?>
                        <div class="col-2 text-center">
                            <img src="https://img.icons8.com/fluency/48/null/trophy.png" />
                            <p><?= $trophy['title'] ?></p>
                            <p>(<?= $trophy['creation'] ?>)</p>

                        </div>
                    <?php } ?>
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