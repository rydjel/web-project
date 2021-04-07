<?php $title = 'Profil Title'; ?>
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
            <h1> Gestion des Intitulés de Profils CIS </h1>
        </header>
        <br>
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-primary btn-block form-control" onclick="openCreationPTModal('creationPTModal');">Création</button>
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
                                    <th class="col-xs-1">Titre</th>
                                    <!-- <th class="col-xs-1">Région</th> -->
<!--                                     <th class="col-xs-1">Date Début</th>
                                    <th class="col-xs-1">Date Fin</th> -->
                                    <th class="col-xs-1"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_id">
                                <?php
                                if ($PTRows) {
                                    while ($data=$PTRows->fetch()) {
                                        $PT_ID="PT-".$data['ID'];
                                        //$PT=$data['Nom'];
                                        //$regionID="region-".$data['ID'];
                                       // $dateDebutID="dateDebut-".$data['ID'];
                                       // $dateFinID="dateFin-".$data['ID'];
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" value=<?php echo "'".$data['intitule']."'";?>
                                                id=<?php echo $PT_ID;?> disabled="disabled">
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
                                                <button type="button" id=<?php echo 'edit-'.$data['ID'];?> onclick="allowPTModif(this.id);">
                                                <span class='glyphicon glyphicon-edit' ></span> Editer</button>
                                                <button type="button" id=<?php echo "validation-".$data['ID'];?> disabled
                                                onclick="PTUpdateValidation('<?php echo $PT_ID; ?>',this.id);">
                                                <span class='glyphicon glyphicon-ok' ></span> Valider</button>
                                                <button type="button" id=<?php echo 'annuler-'.$data['ID'];?> 
                                                onclick="cancelPTModif('<?php echo $PT_ID; ?>',this.id,'<?php echo 'validation-'.$data['ID'];?>');">
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

    <script src="public/js/functions/allowPTModif.js"></script>
    <script src="public/js/functions/PTUpdateValidation.js"></script>
    <script src="public/js/functions/cancelPTModif.js"></script>
    <script src="public/js/functions/openCreationPTModal.js"></script>
    <script src="public/js/functions/createPT.js"></script>
    <script src="public/js/functions/closeCreationPTModal.js"></script>
<!--script auto fetching the client to find the corresponding Market Unit -->
<script src="public/js/functions/clientsFetch.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


<!-- Fenêtre Modal de création d'un nouveau intitule de profil -->
<div class="modal" id="creationPTModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title"><strong>Création d'un nouvel intitule de profil</strong></h3>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-7">
                <input type="text" class="form-control input-lg"  id="PT" name="PT" placeholder="Intitule Profil"/>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="createPT('PT','creationPTModal');">Valider</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeCreationPTModal('creationPTModal');" >Annuler</button>
      </div>
    </div>
  </div>
</div>