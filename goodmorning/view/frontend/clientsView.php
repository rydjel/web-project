<?php $title = 'Clients'; ?>
<?php ob_start(); ?>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" onclick="window.location.href='index.php';">Menu Principal</button>
            </div>
        </div>
        
        <header class="page-header">
            <h1> Gestion des clients CIS </h1>
        </header>
        <br>

            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-primary btn-block form-control" onclick="openCreationClientModal('creationClientModal');">Création</button>
                        <!-- <input type="submit" class="btn btn-primary btn-block" name="clientCreation" value="Création"> -->
                    </div> 

                    <!-- <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="clientCancel" value="Annuler" >
                    </div>    -->
                </div>

                <br> <br>

                <div id="message"><?php echo $message; ?></div>

                <div class="row">

                    <section class="table responsive ">
                        <table class="table  table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th class="col-xs-2">Nom Client</th>
                                    <th class="col-xs-2">Market Unit</th>
                                    <th class="col-xs-2"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_id">
                                <?php
                                if ($clientsRows) {
                                    while ($data=$clientsRows->fetch()) {
                                        $clientfieldID="testCli-".$data['ID'];
                                        $marketUnitID="marketUnit-".$data['ID'];
                                        //$client=$data['NomClient'];
                                        //$marketUnit=$data['nomMU'];
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" value=<?php echo "'".$data['NomClient']."'";?>
                                                id=<?php echo $clientfieldID;?> disabled="disabled">
                                            </td>
                                            <td>
                                                <select id=<?php echo $marketUnitID;?> class="form-control" disabled>
                                                    <?php
                                                    foreach($MUnits as $k)
                                                    {
                                                    ?>
                                                        <option value=<?php echo "'".$k['Nom']."'";?> <?php if($k['Nom']==$data['nomMU']){echo "selected";}?> > <?php echo $k['Nom'];?> </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" id=<?php echo 'edit-'.$data['ID'];?> onclick="allowClientModif(this.id);">
                                                <span class='glyphicon glyphicon-edit' ></span> Editer</button>
                                                <button type="button" id=<?php echo "validation-".$data['ID'];?> disabled
                                                onclick="clientUpdateValidation('<?php echo $clientfieldID; ?>','<?php echo $marketUnitID;?>',this.id);">
                                                <span class='glyphicon glyphicon-ok' ></span> Valider</button>
                                                <button type="button" id=<?php echo 'annuler-'.$data['ID'];?> 
                                                onclick="cancelClientModif('<?php echo $clientfieldID; ?>','<?php echo $marketUnitID;?>',this.id,
                                                '<?php echo 'validation-'.$data['ID'];?>');">
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

    <script src="public/js/functions/allowClientModif.js"></script>
    <script src="public/js/functions/clientUpdateValidation.js"></script>
    <script src="public/js/functions/cancelClientModif.js"></script>
    <script src="public/js/functions/openCreationClientModal.js"></script>
    <script src="public/js/functions/closeCreationCLientModal.js"></script>
    <script src="public/js/functions/createClient.js"></script>

<!--script auto fetching the client to find the corresponding Market Unit -->
<script src="public/js/functions/clientsFetch.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

<!-- Fenêtre Modal de création d'un nouveau client -->
<div class="modal" id="creationClientModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title"><strong>Création d'un nouveau Client</strong></h3>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-7">
                <label for="client">Nom Client</label> 
                <input type="text" class="form-control input-lg" value=""  id="client" name="client"/>
            </div>
            <div class="col-sm-12 ">
                <label for="marketUnit">Market Unit</label>
                <select id="marketUnit" placeholder="Market Unit" name="marketUnit"  class="form-control input-lg">
                    <option value=""></option>
                    <?php
                    if ($listMU) {
                        while ($data=$listMU->fetch()) {
                            ?>
                            <option value=<?php echo "'".$data['Nom']."'";?> > <?php echo $data['Nom'];?> </option>
                        <?php
                        }
                    }     
                    ?>
                </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="createClient('client','marketUnit','creationClientModal');">Valider</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeCreationCLientModal('creationClientModal');" >Annuler</button>
      </div>
    </div>
  </div>
</div>