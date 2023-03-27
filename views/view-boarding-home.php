<?php include 'components/head.php'; ?>

<body>
    <!-- mise en place du Header -->
    <?php include 'components/header.php'; ?>

    <main>
    <div class="h2 text-center text-white fw-bold m-2">Boarding Home</div>
        <div class="container boarding-home rounded-5 border border-light border-5">

            <?php if (empty($procrastimonList)) { ?>
                <div class="alert alert-primary rounded-5" role="alert">
                    The boarding-home is empty for now
                </div>
                
            <?php } else { 
                // sinon, afficher les procrastimons
                foreach ($procrastimonList as $oldprocrastimon) {

                    $sprite = new Sprite();
                    $sprite->id = $oldprocrastimon['id_sprites'];
                    $sprite->getSpriteById();

                    $goal = new Goal();
                    $goal->id_users = $_SESSION['user_id'];
                    $goalList = $goal->getGoalsHistory($oldprocrastimon['id']);
            ?>
                    <div class="col-2">
                        <button class="btn" data-bs-toggle="modal" data-bs-target="#infoModal<?= $oldprocrastimon['id'] ?>">
                            <img src="<?= $sprite->chibi ?>" class="card-img-top img-fluid" alt="..." data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?= $oldprocrastimon['name'] ?>">
                        </button>
                    </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="infoModal<?= $oldprocrastimon['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-5 border border-light border-5">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Goals achieved with <?= $oldprocrastimon['name'] ?></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php
                        foreach ($goalList as $goal) {
                            echo '<p>' . $goal['creation'] . ' : ' . $goal['name'] . ', achieved the ' . $goal['achievement_day'] . '</p>';
                        } ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary rounded-pill fw-bold" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>


<?php
                }
            }
?>



    </main>

    <!-- mise en place du footer -->
    <?php include 'components/footer.php'; ?>

    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>