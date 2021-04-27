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
            <h1> Gestion des Market Unit CIS </h1>
        </header>
        <br>
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="marketUnitCreation" value="Création" disabled>
                    </div>    
                </div>

                <br> <br>

                <div class="row">
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-lg"  id="MU" name="MU" placeholder="Nom market Unit" />
                    </div>

<!--                     <div class="col-sm-3 input-lg">
                        <label>Région </label>
                        <input type="checkbox" id="regionMU" name="regionMU">
                    </div> -->
                </div>

<!--                 <div class="row">
                    <div class="col-sm-3">
                        <label>Date de Début :</label>
                        <input type="date" class="form-control input-lg" value=""  id="dateDebut" name="dateDebut" placeholder="Date de Début"/>
                    </div>

                    <div class="col-sm-3">
                        <label>Date de Fin :</label>
                        <input type="date" class="form-control input-lg" value=""  id="dateFin" name="dateFin" placeholder="Date de Fin" />
                    </div>
                </div> -->
                <br><br><br><br>
                <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="marketUnitRegistrationCreation" value="Enregistrer">
                    </div>

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="marketUnitCancel" value="Retour">
                    </div> 
                <div>  
            </form>

    </div>

<!--script auto fetching the client to find the corresponding Market Unit -->
<script src="public/js/functions/mufetch.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>