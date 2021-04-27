<?php $title = 'Support'; ?>
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
                        <button type="button" class="btn btn-primary btn-block form-control" onclick="openCreationSupportModal('creationSupportModal');">Création</button>
                        <!-- <input type="submit" class="btn btn-primary btn-block" name="supportCreation" value="Création"> -->
                    </div> 
                </div>

                <br> <br>

                <div id="message"><?php echo $message; ?> </div>

                <div class="row">

                    <section class="table responsive ">
                        <table class="table  table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th class="col-xs-1">Nom</th>
                                    <th class="col-xs-1">Prénom</th>
                                    <th class="col-xs-1">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_id">
                                <?php
                                    if ($supportTeam) {
                                        while ($data=$supportTeam->fetch()) {
                                            $nomSupport_ID="nomSupport-".$data['ID'];
                                            $prenomSupport_ID="prenomSupport-".$data['ID'];
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" value=<?php echo "'".$data['nom']."'";?>
                                                    id=<?php echo $nomSupport_ID;?> disabled="disabled">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" value=<?php echo "'".$data['prenom']."'";?>
                                                    id=<?php echo $prenomSupport_ID;?> disabled="disabled">
                                                </td>
                                                <td>
                                                    <button type="button" id=<?php echo 'edit-'.$data['ID'];?> onclick="allowSupportModif(this.id);">
                                                    <span class='glyphicon glyphicon-edit' ></span> Editer</button>
                                                    <button type="button" id=<?php echo "validation-".$data['ID'];?> disabled
                                                    onclick="supportUpdateValidation('<?php echo $nomSupport_ID; ?>','<?php echo $prenomSupport_ID; ?>',this.id);">
                                                    <span class='glyphicon glyphicon-ok' ></span> Valider</button>
                                                    <button type="button" id=<?php echo 'annuler-'.$data['ID'];?> 
                                                    onclick="cancelSupportModif('<?php echo $nomSupport_ID; ?>','<?php echo $prenomSupport_ID; ?>',this.id,'<?php echo 'validation-'.$data['ID'];?>');">
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


    <script src="public/js/functions/allowSupportModif.js"></script>
    <script src="public/js/functions/supportUpdateValidation.js"></script>
    <script src="public/js/functions/cancelSupportModif.js"></script>
    <script src="public/js/functions/createSupport.js"></script>
    <script src="public/js/functions/closeCreationSupportModal.js"></script>
    <script src="public/js/functions/openCreationSupportModal.js"></script>

<!--script auto fetching the client to find the corresponding Market Unit -->
<!-- <script src="public/js/functions/clientsFetch.js"></script> -->

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

<!-- Fenêtre Modal de création d'un nouveau support -->
<div class="modal" id="creationSupportModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title"><strong>Création d'un nouveau Support</strong></h3>
      </div>
      <div class="modal-body">
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="createSupport('nomSupport','prenomSupport','creationSupportModal');">Valider</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeCreationSupportModal('creationSupportModal');" >Annuler</button>
      </div>
    </div>
  </div>
</div>