<?php $title = 'Carrier Manager'; ?>
<?php ob_start(); ?>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" onclick="window.location.href='index.php';">Menu Principal</button>
            </div>
        </div>
        
        <header class="page-header">
            <h1> Gestion des Carrier Managers CIS </h1>
        </header>
        <br>

            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-primary btn-block form-control" onclick="openCreationManagerModal('creationManagerModal');">Création</button>
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
                                    <th class="col-xs-1">PU</th>
                                    <th class="col-xs-1">Site</th>
                                    <th class="col-xs-1">GGID</th>
                                    <th class="col-xs-1">Nom</th>
                                    <th class="col-xs-1">Prénom</th>
                                    <th class="col-xs-1"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_id">
                                <?php
                                if ($CMTeam) {
                                    while ($data=$CMTeam->fetch()) {
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" value=<?php echo "'".$data['nomPU']."'";?> disabled>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value=<?php echo "'".$data['nomSite']."'";?> disabled>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value=<?php echo "'".$data['GGID']."'";?> disabled>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value=<?php echo "'".$data['Nom']."'";?> disabled>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value=<?php echo "'".$data['Prénom']."'";?> disabled>
                                            </td>
                                            <td>
                                                <button type="button" id=<?php echo 'delete-'.$data['idCollab'];?> onclick="deleteManagerPermission(this.id,'deleteManagerModal');">
                                                <span class='glyphicon glyphicon-remove' ></span> Supprimer</button>
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


    <script src="public/js/functions/deleteManagerPermission.js"></script>
    <script src="public/js/functions/closeDeleteManagerModal.js"></script>
    <script src="public/js/functions/deleteManager.js"></script>
    <script src="public/js/functions/deleteCM.js"></script>
    <script src="public/js/functions/getCollabList.js"></script>
    <script src="public/js/functions/getAvailableCollabsToManageList.js"></script>
    <script src="public/js/functions/createManager.js"></script>
    <script src="public/js/functions/createCM.js"></script>
    <script src="public/js/functions/openCreationManagerModal.js"></script>
    <script src="public/js/functions/closeCreationManagerModal.js"></script>


<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

<!-- Fenêtre Modal de suppression d'un manager -->
<div class="modal" id="deleteManagerModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title"><strong>Suppression d'un Carrier Manager</strong></h3>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning alert-dismissible" role="alert">
            <strong>Warning!</strong> Êtes-vous sûr(e)s de vouloir supprimer ce collaborateur de l'équipe ?
        </div>
      </div>
      <input type="hidden" id="managerToDelete">
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="deleteCM('managerToDelete','deleteManagerModal');">Valider</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeDeleteManagerModal('deleteManagerModal');" >Annuler</button>
      </div>
    </div>
  </div>
</div>


<!-- Fenêtre Modal de création d'un nouveau manager -->
<div class="modal" id="creationManagerModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title"><strong>Création d'un nouveau Carrier Manager</strong></h3>
      </div>
      <div class="modal-body">
        <div class="row">
            <select id="puChoice" class="form-control" name="pu" onchange="getAvailableCollabsToManageList(this.value,'collabChoice');">
                <option value="Sélectionner une PU ..." selected readonly>Sélectionner une PU ...</option> 
                <?php
                if ($puList) {
                    while ($data=$puList->fetch()) { ?>
                        <option value=<?php echo $data['ID']; ?> > <?php echo $data['Nom']; ?> </option>
                        <?php
                    }
                }  
                ?>
            </select>
            <br>
            <select id="collabChoice" class="form-control" name="collab">
                <option value=""></option>
            </select>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="createCM('collabChoice','creationManagerModal');">Valider</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeCreationManagerModal('creationManagerModal');" >Annuler</button>
      </div>
    </div>
  </div>
</div>