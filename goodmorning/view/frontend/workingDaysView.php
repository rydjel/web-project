<?php $title = 'Jours Ouvrables'; ?>
<?php ob_start(); ?>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" onclick="window.location.href='index.php';">Menu Principal</button>
            </div>
        </div>

        <header class="page-header">
            <h1> Jours Ouvrables CIS </h1>
        </header>
        <br>
            <form action="" method="post">
<!--                 <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="JOModification" value="Modification">
                    </div> 

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="clientCancel" value="Annuler" disabled>
                    </div>   
                </div> -->

                <br> <br>

                <div id="message"></div>

                <div class="row">
                    <div class="col-sm-3">
                        <select id="select" class="form-control" name="yearJO">
                            <option value=<?php  echo date("Y")-1;?> <?php if($year==date("Y")-1){echo "selected";}?> ><?php  echo date("Y")-1;?></option>
                            <option value=<?php  echo date("Y");?> <?php if($year==date("Y")){echo "selected";}?> ><?php  echo date("Y");?></option>
                            <option value=<?php  echo date("Y")+1;?> <?php if($year==date("Y")+1){echo "selected";}?> ><?php  echo date("Y")+1;?></option>
                        </select>
                    </div>
                    <!-- </div> -->
                   <div class="col-xs-1">
                        <input type="submit" class="btn btn-primary btn-block"name="yearJOFilter" value="Filter">
                    </div> 
                </div>


                <div class="row ">
                    <section class="table responsive ">
                        <table class="table table-bordered table-striped table-condensed ">
                            <thead>
                                <tr>
                                    <th class="col-xs-1">Mois</th>
                                    <th class="col-xs-1">Jours Ouvrables</th>
                                    <th class="col-xs-3"></th>
                                <tr>
                            <thead>
                            <tbody>
                                <?php
                                    $Mois = array('1' => 'Janvier' ,'2' => 'Février','3' => 'Mars','4' => 'Avril','5' => 'Mai','6' => 'Juin',
                                    '7' => 'Juillet','8' => 'Août','9' => 'Septembre','10' => 'Octobre','11' => 'Novembre','12' => 'Décembre' );
                                    while ($data=$workingDays->fetch()) {
                                        $JOfieldID="JO-".$data['ID'];
                                        $jo=$data['NbJours'];
                                        ?>
                                            <tr>
                                                <td><?php echo $Mois[$data['Mois']]; ?></td>
                                                <td><input type="text" class="form-control" value=<?php echo "'".$data['NbJours']."'"?> 
                                                    id=<?php echo $JOfieldID;?>  disabled ></td>
                                                <td>
                                                <button type="button" id=<?php echo 'edit-'.$data['ID'];?> onclick="allowJOModif(this.id);">
                                                <span class='glyphicon glyphicon-edit' ></span> Editer</button>
                                                <button type="button" id=<?php echo "validation-".$data['ID'];?> disabled
                                                onclick="JOUpdateValidation('<?php echo $JOfieldID; ?>',this.id);">
                                                <span class='glyphicon glyphicon-ok' ></span> Valider</button>
                                                <button type="button" id=<?php echo 'annuler-'.$data['ID'];?> 
                                                onclick="cancelJOModif('<?php echo $JOfieldID; ?>',this.id,'<?php echo 'validation-'.$data['ID'];?>');">
                                                <span class='glyphicon glyphicon-refresh' ></span> Rafraichir/Annuler</button>
                                            </td>
                                            </tr>
                                    <?php
                                    }
                                ?>
                                
                            </tbody>
                </div>
            </form>

    </div>

    <script src="public/js/functions/allowJOModif.js"></script>
    <script src="public/js/functions/JOUpdateValidation.js"></script>
    <script src="public/js/functions/cancelJOModif.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>