<?php $title = 'types Activités'; ?>
<?php ob_start(); ?>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" onclick="window.location.href='index.php';">Menu Principal</button>
            </div>
        </div>
        
        <header class="page-header">
            <h1> Gestion des Types d'Activité CIS </h1>
        </header>
        <br>

            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-primary btn-block form-control" onclick="openCreationATModal('creationATModal');">Création</button>
                </div>

                <br> <br>

                <div id="message"><?php echo $message; ?> </div>

                <div class="row">

                    <section class="table responsive ">
                        <table class="table  table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th class="col-xs-1">Type d'Activité</th>
                                    <th class="col-xs-1">Impact TACE</th>
                                    <th class="col-xs-1">Facturable</th>
                                    <th class="col-xs-2"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_id">
                                <?php
                                if ($ATRows) {
                                    while ($data=$ATRows->fetch()) {
                                        $AT_ID="AT-".$data['ID'];
                                        $impactTACEID="impactTACE-".$data['ID'];
                                        $facturableID="facturable-".$data['ID'];
                                        $AT=$data['Nom_typeActivite'];
                                        $impactTACE=$data['Impact_TACE'];
                                        $facturable=$data['Facturable'];
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" value=<?php echo "'".$data['Nom_typeActivite']."'";?>
                                                id=<?php echo $AT_ID;?> disabled="disabled">
                                            </td>
                                            <td>
                                                <select id=<?php echo $impactTACEID;?> class="form-control" disabled="disabled">
                                                    <option value="positif" <?php if($data['Impact_TACE']=="positif"){echo "selected";} ?>>positif</option>
                                                    <option value="aucun" <?php if($data['Impact_TACE']=="aucun"){echo "selected";} ?>>aucun</option>
                                                    <option value="négatif" <?php if($data['Impact_TACE']=="négatif"){echo "selected";} ?>>négatif</option>
                                                </select>
                                            </td>
                                            <td>
                                            <input type="checkbox" id=<?php echo $facturableID;?> name="facturable" <?php if($data['Facturable']==1){echo "checked";}?> disabled>
                                            </td>
                                            <td>
                                                <button type="button" id=<?php echo 'edit-'.$data['ID'];?> onclick="allowATModif(this.id);">
                                                <span class='glyphicon glyphicon-edit' ></span> Editer</button>
                                                <button type="button" id=<?php echo "validation-".$data['ID'];?> disabled
                                                onclick="ATUpdateValidation('<?php echo $AT_ID; ?>','<?php echo $impactTACEID;?>','<?php echo $facturableID;?>',this.id);">
                                                <span class='glyphicon glyphicon-ok' ></span> Valider</button>
                                                <button type="button" id=<?php echo 'annuler-'.$data['ID'];?> 
                                                onclick="cancelATModif('<?php echo $AT_ID; ?>','<?php echo $impactTACEID;?>','<?php echo $facturableID;?>',this.id,'<?php echo 'validation-'.$data['ID'];?>');">
                                                <span class='glyphicon glyphicon-refresh' ></span> Rafraichir/Annuler</button>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                }    
                                ?>
                            </tbody>
                        </table>
                    </section>
                </div>
            </form>

    </div>

    <script src="public/js/functions/allowATModif.js"></script>
    <script src="public/js/functions/ATUpdateValidation.js"></script>
    <script src="public/js/functions/cancelATModif.js"></script>
    <script src="public/js/functions/openCreationATModal.js"></script>
    <script src="public/js/functions/createAT.js"></script>
    <script src="public/js/functions/closeCreationATModal.js"></script>

<script src="public/js/functions/clientsFetch.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>



<!-- Fenêtre Modal de création d'un nouveau type d'activité -->
<div class="modal" id="creationATModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title"><strong>Création d'un nouveau Type d'Activité</strong></h3>
      </div>
      <div class="modal-body">
        <div class="row">
            <section class="table responsive ">
                <table class="table  table-striped table-condensed">
                    <thead>
                        <tr>
                            <th class="col-xs-3">Type d'Activité</th>
                            <th class="col-xs-1">Impact TACE</th>
                            <th class="col-xs-1">Facturable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="text" class="form-control" name="AT" id="AT">
                            </td>
                            <td>
                                <select class="form-control" name="impactTACE" id="impactTACE">
                                    <option value=""></option>
                                    <option value="positif">positif</option>
                                    <option value="aucun">aucun</option>
                                    <option value="négatif">négatif</option>
                                </select>
                            </td>
                            <td>
                                <input type="checkbox"  name="facturable" id="facturable">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="createAT('AT','impactTACE','facturable','creationATModal');">Valider</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeCreationATModal('creationATModal');" >Annuler</button>
      </div>
    </div>
  </div>
</div>