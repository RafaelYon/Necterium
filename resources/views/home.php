<?php resource('views/layouts/head.php'); ?>

<title>Home</title>

<?php resource('views/layouts/body.php'); ?>

<div class="container">
    <div class="row p-5">
        <div class="col-md-12 text-center">        
            <h1 class="text-orange"><?=config('app.name')?></h1>
            <p>
                Crie, edite e exclua seus contatos.
                <br>
                A ferramente de gerenciamento completo para seus contatos
            </p>
        </div>
        <div class="col-md-6">

        </div>
    </div>
</div>

<?php resource('views/layouts/scripts.php'); ?>

<?php resource('views/layouts/end.php'); ?>