<?php include 'components/head.php'; ?>

<body>
    <!-- mise en place du Header -->
    <?php include 'components/header.php'; ?>

    <!-- mise en place du loader -->
    <?php include 'components/loader.php'; ?>

    <main>
        <div class="container">
            <div class="row ">
                <?php if (isset($_GET['history'])) { ?>
                    <!-- mise en place du menu -->
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link <?= empty($goalsList) ? "disabled" : "" ?>" href="trophies.php?history">Achieved Goals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= empty($todosList) ? "disabled" : "" ?>" href="trophies.php?history=completedtodos">Achieved todos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= empty($missedGoals) ? "disabled" : "" ?>" href="trophies.php?history=missedgoals">Missed Goals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= empty($missedTodos) ? "disabled" : "" ?>" href="trophies.php?history=missedtodos">Missed todos</a>
                        </li>
                    </ul>

                    <!-- Historique  -->
                    <div class="container History rounded-5 border border-light border-5 p-3">

                        <!-- liste des GOALS -->
                        <?php if (empty($goalsList) && $_GET['history'] == '') { ?>
                            <div class="alert alert-danger rounded-5" role="alert">
                                <p class="text-center fw-bold my-auto">You didn't complete any goals yet !</p>
                            </div>
                        <?php } elseif ($goalsList && $_GET['history'] == '') { ?>
                            <h1 class="text-center"><img src="../assets/img/sprite07-happy.png" alt="" class="sprite-icon"> Achieved Goals <img src="../assets/img/sprite04-happy.png" alt="" class="sprite-icon"></h1>
                            <?php foreach ($goalsList as $goal) { ?>
                                <div class="mb-1">
                                    <?php displayCategory($goal['category']); ?>
                                    <span class="fw-bold">"<?= $goal['name'] ?>"</span> completed the <?= $goal['achievement_day'] ?>
                                </div>
                            <?php  } ?>

                            <!-- Liste des TODOS -->
                        <?php }
                        if (isset($_GET['history']) && $_GET['history'] == 'completedtodos') { ?>
                            <h1 class="text-center"><img src="../assets/img/sprite01-happy.png" alt="" class="sprite-icon"> Achieved Todos <img src="../assets/img/sprite04.png" alt="" class="sprite-icon"></h1>
                            <?php foreach ($todosList as $todo) { ?>
                                <div class="mb-1">
                                    <i class="bi bi-emoji-smile"></i> "<?= $todo['name'] ?>"
                                </div>
                            <?php } ?>

                            <!-- Liste des GOALS manqués -->
                        <?php } elseif (isset($_GET['history']) && $_GET['history'] === 'missedgoals') { ?>
                            <h1 class="text-center"><img src="../assets/img/sprite07-angry.png" alt="" class="sprite-icon"> Missed Goals <img src="../assets/img/sprite01.png" alt="" class="sprite-icon"></h1>
                            <?php foreach ($missedGoals as $missedGoal) { ?>
                                <div class="mb-1 text-muted"><?php displayCategory($missedGoal['category']); ?> <i class="bi bi-emoji-frown"></i> "<?= $missedGoal['name'] ?>" </div>
                            <?php } ?>

                            <!-- Liste des TODOS manqués -->
                        <?php } elseif (isset($_GET['history']) && $_GET['history'] === 'missedtodos') { ?>
                            <h1 class="text-center"><img src="../assets/img/sprite01-angry.png" alt="" class="sprite-icon"> Missed Todos <img src="../assets/img/sprite04-angry.png" alt="" class="sprite-icon"></h1>
                            <?php foreach ($missedTodos as $missedTodo) { ?>
                                <div class="mb-1 text-muted"><i class="bi bi-emoji-frown"></i> "<?= $missedTodo['name'] ?>" </div>
                            <?php } ?>
                        <?php } ?>
                        <div class="row justify-content-center mt-1">
                            <img src="../assets/img/background.png" alt="" class="banner">
                        </div>

                    </div>


                <?php } else if ($empty) { ?>
                    <div class="h2 text-center text-white fw-bold m-2">Trophie's room</div>
                    <div class="alert alert-danger rounded-5 border-5" role="alert">
                        <p class="text-center fw-bold my-auto">You don't have any trophy yet !</p>
                    </div>

                    <!-- Liste des trophés -->
                <?php } else if ($trophiesList) { ?>
                    <div class="h2 text-center text-white fw-bold m-2">Trophie's room</div>
                    <div class="container Trophies rounded-5 border border-light border-5 p-3 mt-4">
                        <div class="row justify-content-around">
                            <?php foreach ($trophiesList as $trophy) { ?>
                                <div class="col-2 text-center m-1">
                                    <button type="button" class="btn" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-trigger="focus" data-bs-custom-class="custom-popover" data-bs-title="<?= $trophy['title'] ?>" data-bs-content="obtained the <?= $trophy['creation'] ?>">
                                        <img src="<?= $trophy['image'] ?>" class="trophies" />
                                    </button>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row banner justify-content-center">
                            <img src="../assets/img/background2.png" alt="">
                        </div>

                    </div>

                <?php } ?>
            </div>

    </main>

    <!-- mise en place du footer -->
    <?php include 'components/footer.php'; ?>

    <script>
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
    </script>

</body>