<?php include 'components/head.php'; ?>

<body>
    <main>
        <div class="row endGame justify-content-center align-items-center">
            <div class="card rounded-5 border border-light border-5">
                <div class="card-body">
                    <div id="carousel-gameover" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active text-center">
                                <img src="https://new-game-plus.fr/wp-content/uploads/2019/07/Game-Freak-Pikachu-KO.jpg" alt="" class="w-25">
                                <h1>Oh no, <?= $procrastimon->name ?> is KO</h1>
                            </div>
                            <div class="carousel-item text-center">
                                <div class="h3">Don't worry <?= $procrastimon->name ?> is in a better place ...</div>
                            </div>
                            <div class="carousel-item text-center">
                                <div class="h3">Take care of your new procratimon and keep motivated !</div>
                                <img src="" alt="">
                                <button type="button" class="btn btn-outline-info rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal">Of course !</button>
                                <button type="button" class="btn btn-outline-info rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal">I'll do my best ...</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center w-100">
                <div class="col-3 text-center">
                    <button type="button" id="next" class="btn btn-outline-secondary rounded-pill border-5 fw-bold" data-bs-target="#carousel-gameover" data-bs-slide="next"> next
                    </button>
                </div>

            </div>
        </div>


    </main>

    <!-- Modal de creation d'un nouveau procrastimon -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-5 border border-light border-5">
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="h3 fw-bold text-center">Name your new procrastimon</div>
                        <div class="row mb-3">

                            <div class="input-group mb-3">
                                <span class="col-1 my-auto" id="basic-addon1"> <?= $arrayErrors['procrastimon'] ?? '<i class="bi bi-emoji-laughing-fill"></i>' ?></span>
                                <input type="text" class="col form-control rounded-pill" placeholder="Procrastimon's name" aria-label="procrastimon" aria-describedby="procrastimon" name="newProcrastimon">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-outline-info rounded-pill fw-bold" value="let's go!">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/gameover.js"></script>


</body>