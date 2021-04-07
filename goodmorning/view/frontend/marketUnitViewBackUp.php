<?php $title = 'Market Unit'; ?>
<?php ob_start(); ?>
    <div class="container">
        <header class="page-header">
            <h1> Gestion des Market Unit CIS </h1>
        </header>
        <br>
            <?php echo $message; ?>
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="marketUnitCreation" value="Création">
                    </div> 

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="marketUnitModification" id="muModification" value="Modification">
                    </div>

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="marketUnitRegistration" value="Enregistrer" disabled>
                    </div>

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="marketUnitCancel" value="Annuler" disabled>
                    </div>   
                </div>

                <br> <br>

                <div class="row">
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-lg"  id="MU" name="MU" placeholder="Nom market Unit" 
                        onchange="getElement(this.value,'dateDebut','model/getMUDateDebut.php');
                        getElement(this.value,'dateFin','model/getMUDateFin.php');getElement(this.value,'regionMU','model/getMURegion.php');"/>
                    </div>

                    <div class="col-sm-3 input-lg">
                        <label>Région </label>
                        <input type="checkbox" id="regionMU" name="regionMU">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <label>Date de Début :</label>
                        <input type="date" class="form-control input-lg" value=""  id="dateDebut" name="dateDebut" placeholder="Date de Début"/>
                    </div>

                    <div class="col-sm-3">
                        <label>Date de Fin :</label>
                        <input type="date" class="form-control input-lg" value=""  id="dateFin" name="dateFin" placeholder="Date de Fin" />
                    </div>
                </div>


            </form>

    </div>

<!--script auto fetching the client to find the corresponding Market Unit -->
<script src="public/js/functions/mufetch.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>