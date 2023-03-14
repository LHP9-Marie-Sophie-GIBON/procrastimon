<?php include 'components/head.php'; ?>

<body>
    <main>
        <div class="row text-center justify-content-center align-items-center mt-5">
            <div id="carousel-gameover" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://new-game-plus.fr/wp-content/uploads/2019/07/Game-Freak-Pikachu-KO.jpg" alt="" class="w-25">
                        <h1>Oh no, <?= $procrastimon->name ?> is KO</h1>
                    </div>
                    <div class="carousel-item">
                        <p>Don't worry <?= $procrastimon->name ?> is in a better place ...</p>
                    </div>
                    <div class="carousel-item">
                        <p>Take care of your new procratimon and keep motivated !</p>
                        <div class="col-12">
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">Of course !</button>
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">I'll do my best ...</button>
                        </div>
                    </div>
                </div>
                <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button> -->

            </div>
        </div>
        <div class="row justify-content-center w-100">
            <div class="col-1">
                <button type="button" id="next" class="btn btn-secondary" data-bs-target="#carousel-gameover" data-bs-slide="next"> next
                </button>
            </div>

        </div>

    </main>

    <!-- Modal de creation d'un nouveau procrastimon -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body">

                    <form action="" method="post">


                        <div class="mb-3">
                            <label for="procrastimon">Name your new procrastimon</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"> <?= $arrayErrors['procrastimon'] ?? '<i class="bi bi-emoji-laughing-fill"></i>' ?></span>
                                <input type="text" class="form-control" placeholder="Procrastimon's name" aria-label="procrastimon" aria-describedby="procrastimon" name="newProcrastimon">
                            </div>
                            <img src="https://static.vecteezy.com/system/resources/previews/013/854/814/original/capsule-ball-gashapon-ball-png.png" alt="procrastimon capsule" class="w-25">
                        </div>



                        <!-- submit -->
                        <div>
                            <input type="submit" class="btn btn-outline-primary" value="let's go!">

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
        // Sélectionnez le carousel
        var carousel = document.querySelector('#carousel-gameover');

        // Ajouter un écouteur d'événements sur le carousel
        carousel.addEventListener('slide.bs.carousel', function(event) {
            console.log('woop'); 

            // Récupérer l'index de la slide active et le nombre total de slides
            var activeIndex = event.to;
            var totalSlides = this.querySelectorAll('.carousel-item').length;

            // Vérifier si la slide active est la dernière slide
            if (activeIndex == (totalSlides - 1)) {

                // rendre le bouton next visually hidden
                var nextButton = document.querySelector('#next');
                nextButton.classList.add('visually-hidden');
            }
        });
    </script>


</body>