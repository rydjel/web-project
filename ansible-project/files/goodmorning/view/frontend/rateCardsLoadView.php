<?php $title = 'Rate Cards'; ?>
<!-- <link href="public/css/screens/rateCardView.css" rel="stylesheet"/> -->
<?php ob_start(); ?>
    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" onclick="window.location.href='index.php';">Menu Principal</button>
            </div>
        </div>

        <header class="page-header">
            <h1> Gestion des ADRC des Consultants CIS </h1>
        </header>


        <form action="" method="post">
            <br><br>
            <div id="message"><?php echo $message; ?></div>
            <br><br>

            <div class="row">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-primary btn-block form-control" onclick="openCreationRCModal('creationRCModal');">Création</button>
                    <!-- <input type="submit" class="btn btn-primary btn-block" name="rateCardCreation" value="Création"> -->
                </div>
                
                <!-- <div class="col-sm-3">
                    <input type="submit" class="btn btn-primary btn-block" name="rateCardCancel" value="Annuler" >
                </div> -->
            </div>

            <br><br>

            <?php $traduction= array('0' =>'IDF','1'=>'Région','2'=>'Tous');?>
            <div class="container">
                <div class="row">
                        <div class="col-sm-3">
                            <select id="region" name="regionRC"> 
                                <option value="Région" <?php if($traduction[$region]=="Région") {echo "selected";} ?>>Région</option>
                                <option value ="IDF" <?php if($traduction[$region]=="IDF") {echo "selected";} ?> >IDF</option>
                                <option value="Tous"  <?php if($traduction[$region]=="Tous") {echo "selected";} ?> >Tous</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <select id="select" name="yearRC">
                                <option value=<?php  echo date("Y")-1;?> <?php if($year==date("Y")-1){echo "selected";}?> ><?php  echo date("Y")-1;?></option>
                                <option value=<?php  echo date("Y");?> <?php if($year==date("Y")){echo "selected";}?> ><?php  echo date("Y");?></option>
                                <option value=<?php  echo date("Y")+1;?> <?php if($year==date("Y")+1){echo "selected";}?> ><?php  echo date("Y")+1;?></option>
                            </select>
                        </div>
                    <div class="col-xs-1">
                            <input type="submit" class="btn btn-primary btn-block"name="RegionRCFilter" value="Filtrer">
                        </div>
                </div>
            </div>
            <div class="container-fluid">
                <section class="col-sm-12 table responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="col-xs-1">Région</th>
                                <th class="col-xs-2">Role</th>
                                <th class="col-xs-1">Code</th>
                                <th class="col-xs-1">Grade</th>
                                <th class="col-xs-1">ADRC</th>
                                <th class="col-xs-1">CTB 50</th>
                                <th class="col-xs-1">CTB 45</th>
                                <th class="col-xs-1">CTB 40</th>
                                <th class="col-xs-5"></th>
                            </tr>
                        </thead>
                        <tbody id="tbody_id">
                            <?php
                                $libRegion = array('0' =>'IDF','1'=>'Région');
                                if ($rateCards) {
                                    while ($data=$rateCards->fetch()) {
                                        $regionID="region-".$data['ID'];
                                        $roleID="role-".$data['ID'];
                                        $codeID="code-".$data['ID'];
                                        $gradeID="grade-".$data['ID'];
                                        $rateCardID="rateCard-".$data['ID'];
                                        $ctb50ID="ctb50-".$data['ID'];
                                        $ctb45ID="ctb45-".$data['ID'];
                                        $ctb40ID="ctb40-".$data['ID'];
    
                                        // Values for Modification reset
                                        //$region=$libRegion[$data['Region']];
                                        $region=$data['Region'];
                                        $role=$data['Role'];
                                        $code=$data['Code'];
                                        $grade=$data['Grade'];
                                        $rateCard=$data['RateCard'];
                                        
                                        //-------- Contrib
                                        $ctb50=$data['RateCard']/((100-50)/100);
                                        $ctb45=$data['RateCard']/((100-45)/100);
                                        $ctb40=$data['RateCard']/((100-40)/100);

                                        //-------- Convert to 2 digit float format
                                        $ctb50=number_format((float)$ctb50, 2, '.', '');
                                        $ctb45=number_format((float)$ctb45, 2, '.', '');
                                        $ctb40=number_format((float)$ctb40, 2, '.', '');
                                        ?>
                                        <tr>
                                            <td>
                                                <select id=<?php echo $regionID;?> disabled class="form-control"> 
                                                    <option value="1" <?php if($data['Region']=="1") {echo "selected";} ?>>Région</option>
                                                    <option value ="0" <?php if($data['Region']=="0") {echo "selected";} ?> >IDF</option>
                                                </select>
                                            </td>
                                            <!-- <td><input type="text" class="form-control" value=<?php //echo "'".$libRegion[$data['Region']]."'";?> id=<?php //echo $regionID;?> disabled></td> -->
                                            <td><input class="inputrole form-control" type="text" value=<?php echo "'".$data['Role']."'";?> id=<?php echo $roleID;?> disabled></td>
                                            <td><input class="inputOther form-control" type="text" value=<?php echo "'".$data['Code']."'";?> id=<?php echo $codeID;?> disabled></td>
                                            <td>
                                                
                                                    <select id=<?php echo $gradeID;?> name="grade" disabled class="form-control">
                                                        <option value="A" <?php if ($data['Grade']=='A') {echo "selected";}?>>A</option>
                                                        <option value="B" <?php if ($data['Grade']=='B') {echo "selected";}?>>B</option>
                                                        <option value="C" <?php if ($data['Grade']=='C') {echo "selected";}?>>C</option>
                                                        <option value="D" <?php if ($data['Grade']=='D') {echo "selected";}?>>D</option>
                                                        <option value="E" <?php if ($data['Grade']=='E') {echo "selected";}?>>E</option>
                                                        <option value="F" <?php if ($data['Grade']=='F') {echo "selected";}?>>F</option>
                                                    </select>
                                            
                                            </td>
                                            <td><input class="inputOther form-control" type="number" value=<?php echo "'".$data['RateCard']."'";?> id=<?php echo $rateCardID;?> 
                                             onchange="ctbvalues(this.value,'<?php echo $ctb50ID;?>','<?php echo $ctb45ID;?>','<?php echo $ctb40ID;?>');" disabled></td>
                                            <td><input class="inputOther form-control" type="text" value=<?php echo "'".$ctb50."'";?> id=<?php echo $ctb50ID;?> disabled></td>
                                            <td><input class="inputOther form-control" type="text" value=<?php echo "'".$ctb45."'";?> id=<?php echo $ctb45ID;?> disabled></td>
                                            <td><input  class="inputOther form-control" type="text" value=<?php echo "'".$ctb40."'";?> id=<?php echo $ctb40ID;?> disabled></td>
                                            <td>
                                                 <div class='btn-group'>
                                                    <button type="button" id=<?php echo 'edit-'.$data['ID'];?> onclick="allowRCModif(this.id);">
                                                    <span class='glyphicon glyphicon-edit' ></span> Editer</button>
                                                    <button type="button" id=<?php echo "validation-".$data['ID'];?> disabled
                                                    onclick="RCUpdateValidation('<?php echo $regionID; ?>','<?php echo $roleID;?>','<?php echo $codeID;?>',
                                                    '<?php echo $gradeID;?>','<?php echo $rateCardID;?>',this.id,'select');">
                                                    <span class='glyphicon glyphicon-ok'></span> Valider</button>
                                                    <button type="button" id=<?php echo 'annuler-'.$data['ID'];?> 
                                                    onclick="cancelRCModif('<?php echo $regionID; ?>','<?php echo $roleID;?>','<?php echo $codeID;?>',
                                                    '<?php echo $gradeID;?>','<?php echo $rateCardID;?>',this.id,'<?php echo 'validation-'.$data['ID'];?>',
                                                    '<?php echo $ctb50ID;?>','<?php echo $ctb45ID;?>','<?php echo $ctb40ID;?>');">
                                                    <span class='glyphicon glyphicon-refresh' ></span> Rafraichir/Annuler</button>
                                                 </div>
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


    <script src="public/js/functions/allowRCModif.js"></script>
    <script src="public/js/functions/RCUpdateValidation.js"></script>
    <script src="public/js/functions/cancelRCModif.js"></script>
    <script src="public/js/functions/ctbvalues.js"></script>
    <script src="public/js/functions/openCreationRCModal.js"></script>
    <script src="public/js/functions/createRC.js"></script>
    <script src="public/js/functions/closeCreationRCModal.js"></script>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script src="public/js/functions/newselection.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


<!-- Fenêtre Modal de création d'une nouvelle rateCard -->
<div class="modal" id="creationRCModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title"><strong>Création d'une nouvelle ADRC</strong></h3>
      </div>
      <div class="modal-body">
        <div class="row">
            <section class="table-responsive">
                <table class="table  table-striped">
                    <thead>
                        <tr>
                            <th class="col-xs-2">Région</th>
                            <th class="col-xs-2">Role</th>
                            <th class="col-xs-1">Code</th>
                            <th class="col-xs-1">Grade</th>
                            <th class="col-xs-1">ADRC</th>
                            <th class="col-xs-1">Année</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select class="form-control" name="RegionRC" id="modalRegionRC">
                                    <option value="Région">Région</option>
                                    <option value="IDF">IDF</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="RoleRC" id="modalRoleRC"></td>
                            <td><input type="text" class="form-control" name="CodeRC" id="modalCodeRC"></td>
                            <td>
                                <select class="form-control" name="GradeRC" id="modalGradeRC">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                </select>
                            </td>
                            <td><input type="number" min="0" step="any" class="form-control" name="rateCardRC" id="modalrateCardRC"></td>
                            <td><input type="number" min="1900" class="form-control" name="AnneeRC" value=<?php echo date("Y"); ?> id="modalAnneeRC"></td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="createRC('modalRegionRC','modalRoleRC','modalCodeRC','modalGradeRC','modalrateCardRC','modalAnneeRC','creationRCModal');">Valider</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeCreationRCModal('creationRCModal');" >Annuler</button>
      </div>
    </div>
  </div>
</div>