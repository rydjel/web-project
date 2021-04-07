<?php $title = 'marketion Unit'; ?>
<?php ob_start(); ?>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" onclick="window.location.href='index.php';">Menu Principal</button>
            </div>
        </div>

        <header class="page-header">
            <h1> Gestion de l'Equipe Support CIS </h1>
        </header>
        <br>
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="nomSupport">Nom</label>
                        <input type="text" class="form-control input-lg"  id="nomSupport" name="nomSupport"/>
                    </div>
                    <div class="col-sm-3">
                        <label for="prenomSupport">Prénom</label>
                        <input type="text" class="form-control input-lg"  id="prenomSupport" name="prenomSupport"/>
                    </div>
                </div>

                <br><br><br><br>
                <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="supportRegistrationCreation" value="Enregistrer">
                    </div>

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="supportCancel" value="Retour">
                    </div> 
                <div>  
            </form>

    </div>

<!--script auto fetching the client to find the corresponding Market Unit -->
<script src="public/js/functions/mufetch.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>