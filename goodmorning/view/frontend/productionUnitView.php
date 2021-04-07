<?php $title = 'Production Unit'; ?>
<?php ob_start(); ?>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" onclick="window.location.href='index.php';">Menu Principal</button>
            </div>
        </div>
        
        <header class="page-header">
            <h1> Gestion des Production Unit CIS </h1>
        </header>
        <br>

            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-primary btn-block form-control" onclick="openCreationPUModal('creationPUModal');">Création</button>
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
                                    <th class="col-xs-1">Nom Production Unit</th>
                                    <th class="col-xs-1">Région</th>
                                    <th class="col-xs-1">MU</th> <!-- Indique si la PU est de type MU -->
                                    <th class="col-xs-2">Entité</th>
                                    <!-- <th class="col-xs-1">Date Début</th> -->
                                    <th class="col-xs-3"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_id">
                                <?php
                                    if ($puRows) {
                                        while ($data=$puRows->fetch()) {
                                            $PU_ID="PU-".$data['ID'];
                                            $regionID="region-".$data['ID'];
                                            $muID="mu-".$data['ID'];
                                            $entiteID="entite-".$data['ID'];
                                            //$pu=$data['Nom'];
                                            //$region=$data['Region'];
                                            //$dateDebutID="dateDebut-".$data['ID'];
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" value=<?php echo "'".$data['Nom']."'";?>
                                                    id=<?php echo $PU_ID;?> disabled="disabled">
                                                </td>
                                                <td>
                                                <input type="checkbox" id=<?php echo $regionID;?> name="regionPU" <?php if($data['Region']==1){echo "checked";}?> disabled>
                                                </td>
                                                <td>
                                                <input type="checkbox" id=<?php echo $muID;?> name="muPU" <?php if($data['MU']==1){echo "checked";}?> disabled>
                                                </td>
                                                <td>
                                                    <select class="form-control" id=<?php echo $entiteID;?> disabled>
                                                        <option></option>
                                                        <?php
                                                            foreach ($entList as $k) {
                                                                $entDetails=explode("-",$k['Details']);
                                                                ?>
                                                                <option value=<?php echo $entDetails[0];?> <?php if($data['ID_entite']==$entDetails[0]){echo "selected";}?>><?php echo $entDetails[1];?></option>
                                                            <?php
                                                            }
                                                        ?>                                                     
                                                    </select>
                                                </td>
                                                <!-- <td>
                                                    <input type="date" class="form-control input-lg" value=<?php //echo "'".$data['Date_Debut']."'";?>  
                                                    id=<?php //echo $dateDebutID;?> name="dateDebut" disabled/>
                                                </td> -->
                                                <td>
                                                    <button type="button" id=<?php echo 'edit-'.$data['ID'];?> onclick="allowPUModif(this.id);">
                                                    <span class='glyphicon glyphicon-edit' ></span> Editer</button>
                                                    <button type="button" id=<?php echo "validation-".$data['ID'];?> disabled
                                                    onclick="puUpdateValidation('<?php echo $PU_ID; ?>','<?php echo $regionID;?>',this.id,'<?php echo $muID;?>','<?php echo $entiteID;?>');">
                                                    <span class='glyphicon glyphicon-ok' ></span> Valider</button>
                                                    <button type="button" id=<?php echo 'annuler-'.$data['ID'];?> 
                                                    onclick="cancelPUModif('<?php echo $PU_ID; ?>','<?php echo $regionID;?>',this.id,'<?php echo 'validation-'.$data['ID'];?>','<?php echo $muID;?>','<?php echo $entiteID;?>');">
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
<!--script auto fetching the client to find the corresponding Market Unit -->
<script src="public/js/functions/clientsFetch.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

<!-- Fenêtre Modal de création d'une nouvelle Production Unit -->
<div class="modal" id="creationPUModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title"><strong>Création d'une nouvelle PU</strong></h3>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-5">
                <input type="text" class="form-control input-lg"  id="PU" name="PU" placeholder="Nom Production Unit" />
            </div>
            <div class=" input-lg form-check form-check-inline">
                <!-- <label>Région </label> -->
                <input type="checkbox" id="regionPU" name="regionPU">
                <label class="form-check-label" for="regionPU">Région</label>
            </div>
            <div class=" input-lg form-check form-check-inline">
                <!-- <label>MU </label> -->
                <input type="checkbox" id="muPU" name="muPU">
                <label class="form-check-label" for="muPU">MU</label>
            </div>
            <div class="col-sm-5">
                <select class="form-control" id="entitePU" >
                    <option value="" disabled selected>Sélectionner une Entité...</option>
                    <?php
                        foreach ($entList as $k) {
                            $entDetails=explode("-",$k['Details']);
                            ?>
                            <option value=<?php echo $entDetails[0];?>><?php echo $entDetails[1];?></option>
                        <?php
                        }
                    ?>                                                     
                </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="createPU('PU','regionPU','creationPUModal','muPU','entitePU');">Valider</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeCreationPUModal('creationPUModal');" >Annuler</button>
      </div>
    </div>
  </div>
</div>