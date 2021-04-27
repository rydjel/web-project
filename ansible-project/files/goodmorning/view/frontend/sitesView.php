<?php $title = 'Sites'; ?>
<?php ob_start(); ?>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" onclick="window.location.href='index.php';">Menu Principal</button>
            </div>
        </div>
        
        <header class="page-header">
            <h1> Gestion des Sites CIS </h1>
        </header>
        <br>

            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-primary btn-block form-control" onclick="openCreationSiteModal('creationSiteModal');">Création</button>
                        <!-- <input type="submit" class="btn btn-primary btn-block" name="productUnitCreation" value="Création"> -->
                    </div> 

                    <!-- <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="productUnitCancel" value="Annuler" >
                    </div>    -->
                </div>

                <br> <br>

                <div id="message"><?php echo $message; ?> </div>

                <div class="row">

                    <section class="table responsive ">
                        <table class="table  table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th class="col-xs-1">Nom Site</th>
                                    <th class="col-xs-1">Région</th>
                                    <!-- <th class="col-xs-1">Date Début</th> -->
                                    <th class="col-xs-1"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_id">
                                <?php
                                    if ($sitesRows) {
                                        while ($data=$sitesRows->fetch()) {
                                            $site_ID="site-".$data['ID'];
                                            $regionID="region-".$data['ID'];
                                            //$pu=$data['Nom'];
                                            //$region=$data['Region'];
                                            //$dateDebutID="dateDebut-".$data['ID'];
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" value=<?php echo "'".$data['Nom']."'";?>
                                                    id=<?php echo $site_ID;?> disabled="disabled">
                                                </td>
                                                <td>
                                                <input type="checkbox" id=<?php echo $regionID;?> name="regionSIte" <?php if($data['Region']==1){echo "checked";}?> disabled>
                                                </td>
                                                <!-- <td>
                                                    <input type="date" class="form-control input-lg" value=<?php //echo "'".$data['Date_Debut']."'";?>  
                                                    id=<?php //echo $dateDebutID;?> name="dateDebut" disabled/>
                                                </td> -->
                                                <td>
                                                    <button type="button" id=<?php echo 'edit-'.$data['ID'];?> onclick="allowSiteModif(this.id);">
                                                    <span class='glyphicon glyphicon-edit' ></span> Editer</button>
                                                    <button type="button" id=<?php echo "validation-".$data['ID'];?> disabled
                                                    onclick="siteUpdateValidation('<?php echo $site_ID; ?>','<?php echo $regionID;?>',this.id);">
                                                    <span class='glyphicon glyphicon-ok' ></span> Valider</button>
                                                    <button type="button" id=<?php echo 'annuler-'.$data['ID'];?> 
                                                    onclick="cancelSiteModif('<?php echo $site_ID; ?>','<?php echo $regionID;?>',this.id,'<?php echo 'validation-'.$data['ID'];?>');">
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

    <script src="public/js/functions/allowPUModif.js"></script>
    <script src="public/js/functions/puUpdateValidation.js"></script>
    <script src="public/js/functions/cancelPUModif.js"></script>
    <script src="public/js/functions/openCreationPUModal.js"></script>
    <script src="public/js/functions/createPU.js"></script>
    <script src="public/js/functions/closeCreationPUModal.js"></script>

    <script src="public/js/functions/allowSiteModif.js"></script>
    <script src="public/js/functions/siteUpdateValidation.js"></script>
    <script src="public/js/functions/cancelSiteModif.js"></script>
    <script src="public/js/functions/openCreationSiteModal.js"></script>
    <script src="public/js/functions/createSite.js"></script>
    <script src="public/js/functions/closeCreationSiteModal.js"></script>

<!--script auto fetching the client to find the corresponding Market Unit -->
<script src="public/js/functions/clientsFetch.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

<!-- Fenêtre Modal de création d'un nouveau site -->
<div class="modal" id="creationSiteModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title"><strong>Création d'un nouveau site</strong></h3>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-7">
                <input type="text" class="form-control input-lg"  id="Site" name="Site" placeholder="Nom Site" />
            </div>

            <div class="col-sm-3 input-lg">
                <label>Région </label>
                <input type="checkbox" id="regionSite" name="regionSite">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="createSite('Site','regionSite','creationSiteModal');">Valider</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeCreationSiteModal('creationSiteModal');" >Annuler</button>
      </div>
    </div>
  </div>
</div>