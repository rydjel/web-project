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
            <h1> Gestion des Tâches par défaut CIS </h1>
        </header>
        <br>

            <form action="" method="post">

                <div id="message"><?php echo $message; ?></div>

                <div class="row">

                    <section class="table responsive ">
                        <table class="table  table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th class="col-xs-2">Nom Tâche</th>
                                    <th class="col-xs-2">Type Activité</th>
                                    <th class="col-xs-2"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_id">
                                <?php
                                if ($listeDT) {
                                    while ($data=$listeDT->fetch()) {
                                        $taskFieldID="task-".$data['ID_DT'];
                                        $ATFieldID="AT-".$data['ID_DT'];
                                        //$client=$data['NomClient'];
                                        //$marketUnit=$data['nomMU'];
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" value=<?php echo "'".$data['nomTache']."'";?>
                                                id=<?php echo $taskFieldID;?> disabled="disabled">
                                            </td>
                                            <td>
                                                <select id=<?php echo $ATFieldID;?> class="form-control" disabled>
                                                    <?php
                                                        foreach ($AT as $k) {
                                                            $elts=explode("-",$k['Details']);
                                                            ?>
                                                            <option value=<?php echo $elts[0]; ?> <?php if($elts[0]==$data['ID_TypeActivite']){echo "selected";} ?>><?php echo $elts[1];?></option>
                                                        <?php
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" id=<?php echo 'edit-'.$data['ID_DT'];?> onclick="allowDTModif(this.id);">
                                                <span class='glyphicon glyphicon-edit' ></span> Editer</button>
                                                <button type="button" id=<?php echo "validation-".$data['ID_DT'];?> disabled
                                                onclick="DTUpdateValidation('<?php echo $taskFieldID; ?>','<?php echo $ATFieldID;?>',this.id);">
                                                <span class='glyphicon glyphicon-ok' ></span> Valider</button>
                                                <button type="button" id=<?php echo 'annuler-'.$data['ID_DT'];?> 
                                                onclick="cancelDTModif('<?php echo $taskFieldID; ?>','<?php echo $ATFieldID;?>',this.id,
                                                '<?php echo 'validation-'.$data['ID_DT'];?>');">
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

    <script src="public/js/functions/allowDTModif.js"></script>
    <script src="public/js/functions/DTUpdateValidation.js"></script>
    <script src="public/js/functions/cancelDTModif.js"></script>

<!--script auto fetching the client to find the corresponding Market Unit -->
<script src="public/js/functions/clientsFetch.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
