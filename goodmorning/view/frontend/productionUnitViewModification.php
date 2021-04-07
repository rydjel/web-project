<?php $title = 'Production Unit'; ?>
<?php ob_start(); ?>
    <div class="container">
        <header class="page-header">
            <h1> Gestion des Production Unit CIS </h1>
        </header>
        <br>
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="productUnitCreation" value="Création" disabled>
                    </div> 

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="productUnitModification" id="clientModification" value="Modification" disabled>
                    </div>

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="productUnitRegistrationModification" value="Enregistrer">
                    </div>

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="productUnitCancel" value="Annuler">
                    </div>   
                </div>

                <br> <br>

                <div class="row">
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-lg"  id="PU" name="PU" placeholder="Nom Production Unit" value=<?php echo $_POST['PU'] ?> />
                    </div>

                    <div class="col-sm-3 input-lg">
                        <label>Région </label>
                        <input type="checkbox" id="regionPU" name="regionPU" <?php if(!empty($_POST['regionPU'])){echo "checked";} ?>>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <label>Date de Début :</label>
                        <input type="date" class="form-control input-lg" value=<?php echo $_POST['dateDebut'] ?>  id="dateDebut" name="dateDebut" placeholder="Date de Début"/>
                    </div>

                    <div class="col-sm-3">
                        <label>Date de Fin :</label>
                        <input type="date" class="form-control input-lg" value=<?php echo $_POST['dateFin'] ?>  id="dateFin" name="dateFin" placeholder="Date de Fin" />
                    </div>

                    <div class="col-sm-3">
                        <input type="hidden" class="form-control input-lg"  id="idPU" name="idPU"  value=<?php echo "'".$idPU['ID']."'"; ?> />
                    </div>
                </div>


            </form>

    </div>

<!--script auto fetching the client to find the corresponding Market Unit -->
<script src="public/js/functions/pufetch.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>