<?php $title = 'Market Unit'; ?>
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
            <h1> Gestion des Market Unit CIS </h1>
        </header>
        <br>
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-primary btn-block form-control" onclick="openCreationMUModal('creationMUModal');">Création</button>
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
                                    <th class="col-xs-1">Nom Market Unit</th>
                                    <!-- <th class="col-xs-1">Région</th> -->
<!--                                     <th class="col-xs-1">Date Début</th>
                                    <th class="col-xs-1">Date Fin</th> -->
                                    <th class="col-xs-1"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_id">
                                <?php
                                if ($muRows) {
                                    while ($data=$muRows->fetch()) {
                                        $MU_ID="PU-".$data['ID'];
                                        //$MU=$data['Nom'];
                                        //$regionID="region-".$data['ID'];
                                       // $dateDebutID="dateDebut-".$data['ID'];
                                       // $dateFinID="dateFin-".$data['ID'];
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" value=<?php echo "'".$data['Nom']."'";?>
                                                id=<?php echo $MU_ID;?> disabled="disabled">
                                            </td>
<!--                                             <td>
                                            <input type="checkbox" id=<?php //echo $regionID;?> name="regionPU" <?php //if($data['Region']==1){echo "checked";}?> disabled>
                                            </td> -->
<!--                                             <td>
                                                <input type="date" class="form-control input-lg" value=<?php //echo "'".$data['Date_Debut']."'";?>  
                                                id=<?php //echo $dateDebutID;?> name="dateDebut" disabled/>
                                            </td>
                                            <td>
                                                <input type="date" class="form-control input-lg" value=<?php //echo "'".$data['Date_Fin']."'";?>  
                                                id=<?php //echo $dateFinID;?> name="dateFin" disabled/>
                                            </td> -->
                                            <td>
                                                <button type="button" id=<?php echo 'edit-'.$data['ID'];?> onclick="allowMUModif(this.id);">
                                                <span class='glyphicon glyphicon-edit' ></span> Editer</button>
                                                <button type="button" id=<?php echo "validation-".$data['ID'];?> disabled
                                                onclick="muUpdateValidation('<?php echo $MU_ID; ?>',this.id);">
                                                <span class='glyphicon glyphicon-ok' ></span> Valider</button>
                                                <button type="button" id=<?php echo 'annuler-'.$data['ID'];?> 
                                                onclick="cancelMUModif('<?php echo $MU_ID; ?>',this.id,'<?php echo 'validation-'.$data['ID'];?>');">
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
<!--script auto fetching the client to find the corresponding Market Unit -->
<script src="public/js/functions/clientsFetch.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


<!-- Fenêtre Modal de création d'une nouvelle market Unit -->
<div class="modal" id="creationMUModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title"><strong>Création d'une nouvelle Market Unit</strong></h3>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-7">
                <input type="text" class="form-control input-lg"  id="MU" name="MU" placeholder="Nom market Unit" />
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="createMU('MU','creationMUModal');">Valider</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeCreationMUModal('creationMUModal');" >Annuler</button>
      </div>
    </div>
  </div>
</div>