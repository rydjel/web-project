<?php $title = 'PNL KPI Type'; ?>
<?php ob_start(); ?>
<?php
// session_start(); // initialize session
// session_destroy(); // destroy session
// setcookie("PHPSESSID","",time()-3600,"/");
?>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" onclick="window.location.href='index.php';">Menu Principal</button>
            </div>
        </div>
        
        <header class="page-header">
            <h1> Gestion des Types de KPI CIS </h1>
        </header>
        <br>
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-primary btn-block form-control" onclick="openCreationKpiTypeModal('creationKpiTypeModal');">Création</button>
                        <!-- <input type="submit" class="btn btn-primary btn-block" name="marketUnitCreation" value="Création"> -->
                    </div> 

                    <!-- <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="marketUnitCancel" value="Annuler" >
                    </div>    -->
                </div>

                <br> <br>

                <div id="message"><?php echo $message; ?> </div>
                
                <div class="row">

                    <section class="table responsive ">
                        <table class="table  table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th class="col-xs-1">Type</th>
                                    <th class="col-xs-1"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_id">
                                <?php
                                if ($kpiTypesList) {
                                    while ($data=$kpiTypesList->fetch()) {
                                        $kpiType_ID="kpiType-".$data['id_pnlkpitype'];
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" value=<?php echo "'".$data['type']."'";?>
                                                id=<?php echo $kpiType_ID;?> disabled="disabled">
                                            </td>
                                            <td>
                                                <button type="button" id=<?php echo 'edit-'.$data['id_pnlkpitype'];?> onclick="allowKpiTypeModif(this.id);">
                                                <span class='glyphicon glyphicon-edit' ></span> Editer</button>
                                                <button type="button" id=<?php echo "validation-".$data['id_pnlkpitype'];?> disabled
                                                onclick="kpiTypeUpdateValidation('<?php echo $kpiType_ID; ?>',this.id);">
                                                <span class='glyphicon glyphicon-ok' ></span> Valider</button>
                                                <button type="button" id=<?php echo 'annuler-'.$data['id_pnlkpitype'];?> 
                                                onclick="cancelKpiTypeModif('<?php echo $kpiType_ID; ?>',this.id,'<?php echo 'validation-'.$data['id_pnlkpitype'];?>');">
                                                <span class='glyphicon glyphicon-refresh' ></span> Rafraichir/Annuler</button>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                }
                                    
                                ?>
                            </tbody>

                </div>
            </form>

    </div>

    <script src="public/js/functions/allowMUModif.js"></script>
    <script src="public/js/functions/muUpdateValidation.js"></script>
    <script src="public/js/functions/cancelMUModif.js"></script>
    <script src="public/js/functions/openCreationMUModal.js"></script>
    <script src="public/js/functions/createMU.js"></script>
    <script src="public/js/functions/closeCreationMUModal.js"></script>


    <script src="public/js/functions/allowKpiTypeModif.js"></script>
    <script src="public/js/functions/kpiTypeUpdateValidation.js"></script>
    <script src="public/js/functions/cancelKpiTypeModif.js"></script>
    <script src="public/js/functions/openCreationKpiTypeModal.js"></script>
    <script src="public/js/functions/createKpiType.js"></script>
    <script src="public/js/functions/closeCreationKpiTypeModal.js"></script>


<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


<!-- Fenêtre Modal de création d'un nouveau type de KPI -->
<div class="modal" id="creationKpiTypeModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title"><strong>Création d'un nouveau type de KPI</strong></h3>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-7">
                <input type="text" class="form-control input-lg"  id="kpiType" name="kpiType" placeholder="Type de KPI" />
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="createKpiType('kpiType','creationKpiTypeModal');">Valider</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeCreationKpiTypeModal('creationKpiTypeModal');" >Annuler</button>
      </div>
    </div>
  </div>
</div>