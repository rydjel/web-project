<?php $title = 'Production Unit'; ?>
<?php ob_start(); ?>
    <div class="container">
        <header class="page-header">
            <h1> Gestion des Production Unit CIS </h1>
        </header>
        <br>
            <?php echo $message; ?>
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="productUnitCreation" value="Création">
                    </div> 

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="productUnitModification" id="clientModification" value="Modification">
                    </div>

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="productUnitRegistration" value="Enregistrer" disabled>
                    </div>

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="productUnitCancel" value="Annuler" disabled>
                    </div>   
                </div>

                <br> <br>

                <div class="row">
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-lg"  id="PU" name="PU" placeholder="Nom Production Unit" 
                        onchange="getElement(this.value,'dateDebut','model/getPUDateDebut.php');
                        getElement(this.value,'dateFin','model/getPUDateFin.php');getElement(this.value,'regionPU','model/getPURegion.php');"/>
                    </div>

                    <div class="col-sm-3 input-lg">
                        <label>Région </label>
                        <input type="checkbox" id="regionPU" name="regionPU">
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
<script src="public/js/functions/pufetch.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>