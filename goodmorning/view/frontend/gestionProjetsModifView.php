<?php $title = 'Projets'; ?>
<?php ob_start(); ?>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" onclick="window.location.href='index.php';">Menu Principal</button>
            </div>
        </div>

        <header class="page-header">
            <h1> Gestion des Projets CIS </h1>
        </header>
            <br>
            <div id="message"><?php echo $message ?></div>
            <br>
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="codeProjet">Code Projet</label>
                        <input type="text" class="form-control" placeholder="Code Projet" id="codeProjet" name="codeProjet"
                        value=<?php echo $project['Code']; ?> title="Code Projet">
                    </div>
                    <div class="col-sm-3">
                        <label for="titreProjet">Titre Projet</label>
                        <input type="text" class="form-control" placeholder="Titre Projet" id="titreProjet" 
                        value=<?php echo "'".$project['Titre']."'"; ?> title="Titre Projet" title="Titre Projet">
                    </div>
                    <div class="col-sm-3">
                        <label for="PU">Production Unit Mandataire</label>
                        <select id="PU" class="form-control" title="Production Unit Mandataire">
                           <?php 
                           if ($puList) {
                                while ($data=$puList->fetch()) {?>
                                    <option value=<?php  echo $data['ID'];?> <?php if($data['ID']==$project['ID_PU']){echo "selected";} ?>><?php  echo $data['Nom'];?></option>
                                <?php
                                }
                           } 
                           ?> 
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="client">Client</label>
                        <select id="client" class="form-control" title="Client">
                            <?php
                            if ($clientList) {
                                while ($data=$clientList->fetch()) { ?>
                                    <option value=<?php echo $data['ID'];?> <?php if($data['ID']==$project['ID_Client']){echo "selected";} ?> > <?php echo $data['NomClient']; ?> </option>
                                    <?php
                                }
                            }    
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <label for="typeProjet">Type de Projet </label>
                        <!-- <select id="typeProjet" class="form-control" title="Type de Projet" onchange="getGeneriqueCode(this.value,'codeGen');"> -->
                        <select id="typeProjet" class="form-control" title="Type de Projet" onchange="getGeneriqueCode(this.value,'codeGen');">
                            <option value="Assistance Technique Simple" <?php if($project['TypeProjet']=="Assistance Technique Simple"){echo "selected";} ?>>Assistance Technique Simple</option>
                            <option value="Engagement de Moyen" <?php if($project['TypeProjet']=="Engagement de Moyen"){echo "selected";} ?>>Engagement de Moyen</option>
                            <option value="Engagement de Résultat" <?php if($project['TypeProjet']=="Engagement de Résultat"){echo "selected";} ?>>Engagement de Résultat</option>
                            <option value="Activité Interne" <?php if($project['TypeProjet']=="Activité Interne"){echo "selected";} ?>>Activité Interne</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="VolJourVendu">Volume Jour Vendu</label>
                        <input type="text" class="form-control" title="Volume Jour Vendu" id="VolJourVendu" value=<?php echo $project['VolJourVendu']; ?>>
                        <br>
                        <label for="BudgetVendu">Budget Vendu</label>
                        <input type="text" class="form-control" title="Budget Vendu" id="BudgetVendu" value=<?php echo $project['budget']; ?>>
                        <br>
                        <label for="RFA">Remise de Fin d'Année</label>
                        <input type="text" class="form-control" title="Remise de Fin d'Année" id="RFA" value=<?php echo $project['RFA']; ?>>
                        <br>
                        <label for="anneeProjTypeGen">Année (Projet avec Code générique)</label>
                        <select name="anneeProjTypeGen" class="form-control" id="anneeProjTypeGen" <?php if($project['codeGenerique']==0){echo "disabled";} ?> >
                            <option value=""></option>
                            <option value=<?php echo date("Y")-1; ?>><?php echo date("Y")-1; ?></option>
                            <option value=<?php echo date("Y"); ?>><?php echo date("Y"); ?></option>
                            <option value=<?php echo date("Y")+1; ?> ><?php echo date("Y")+1; ?></option>
                        </select>
                        <br>
                        <input type="hidden" class="form-control" name="projID" value=<?php echo $project['ID']; ?>>
                    </div>
                    <div class="col-sm-3">
                        <label for="Commercial">Commercial</label>
                        <input type="text" class="form-control" title="Commercial" id="Commercial" value=<?php echo "'".$project['Commercial']."'"; ?>>   
                    </div>
                    <div class="col-sm-3">
                        Code Générique   <input type="checkbox" name="codeGenerique" id="codeGen" <?php if($project['codeGenerique']==1){echo "checked";} ?> onchange="enableDisableYear(this.id,'anneeProjTypeGen');">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button"  id="newTask" class="btn btn-primary btn-block" onclick="taskCreation();" >Nouvelle Tâche</button>
                    </div>
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="taskAffectModif" value="Affecter Une Tâche"> 
                    </div>
                </div>
                <br>
               

                <div class="row ">
                    <section class="table responsive ">
                        <table class="table table-bordered table-striped table-condensed ">
                            <thead>
                                <tr>
                                    <th class="col-xs-2">Tâche</th>
                                    <th class="col-xs-1">Type Activité</th>
                                    <th class="col-xs-1">Impact TACE</th>
                                    <th class="col-xs-1">Facturable</th>
                                    <th class="col-xs-2">Action</th>
                                <tr>
                            </thead>
                            <tbody id="tbody">
                                <?php
                                if ($taskList) {
                                    while ($data=$taskList->fetch()) {
                                        $id1="task-".$data['taskID'];
                                        $id2="activity-".$data['taskID'];
                                        $id3="TACE-".$data['taskID'];
                                        $id4="Fact-".$data['taskID'];
                                        $val1=$data['Nom_Tache'];
                                        $val2=$data['typeActivityID'];
                                        $val3=$data['Impact_TACE'];
                                        $val4=$data['Facturable'];
                                        ?>
                                        <tr>
                                            <td><input type="text" class="form-control" value=<?php echo "'".$data['Nom_Tache']."'";?> id=<?php echo "task-".$data['taskID'];?> disabled ></td>
                                            <td>
                                                <select id=<?php echo $id2;?>  class="form-control" name="typeActivite" onchange="getTACEandFact(this.id,'<?php echo $id3;?>','<?php echo $id4;?>');" disabled> 
                                                  <?php
                                                  foreach ($arrayAT as $key => $value) {
                                                    ?>
                                                    <option value=<?php echo $key;?> <?php if($key==$data['typeActivityID']){echo "selected";}?>>
                                                        <?php echo $value;?></option>
                                                    <?php
                                                  }
                                                  ?>  
                                                </select>
                                            </td>
                                            <!-- <td><input type="text" class="form-control" value=<?php //echo "'".$data['Nom_typeActivite']."'";?> id=<?php //echo "activity-".$data['typeActivityID'];?> disabled></td> -->
                                            <td><input type="text"  class="form-control" value=<?php echo "'".$data['Impact_TACE']."'";?> id=<?php echo "TACE-".$data['taskID'];?> disabled></td>
                                            <td><input type="checkbox" class="form-control" <?php if($data['Facturable']==1){echo "checked";} ?> id=<?php echo "Fact-".$data['taskID']; ?> disabled></td>
                                            <td>
                                            <button type="button" id=<?php echo "edit-".$data['taskID'];?> onclick="allowTaskModif(this.id,'<?php echo $id1;?>');">
                                            <span class="glyphicon glyphicon-edit" ></span> Editer</button>
                                            <button type="button" id=<?php echo "validation-".$data['taskID'];?> disabled
                                             onclick="taskUpdateValidation('<?php echo $id1; ?>','<?php echo $id2; ?>','<?php echo $id3; ?>','<?php echo $id4; ?>',this.id);">
                                            <span class="glyphicon glyphicon-ok"></span>Valider</button>
                                            <button type="button" id=<?php echo "annulation-".$data['taskID'];?> disabled
                                             onclick="cancelTaskModif('<?php echo $id1; ?>','<?php echo $id2; ?>','<?php echo $id3; ?>','<?php echo $id4; ?>',this.id,'<?php echo 'validation-'.$data['taskID'];?>');">
                                            <span class="glyphicon glyphicon-refresh"></span> Rafraichir/Annuler</button>
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
                <br>
                <div class="row" id="projAction">
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-primary btn-block" id=<?php echo "Proj-".$project['ID'];?>
                        onclick="projectModifRecord('PU','codeProjet','titreProjet','Commercial','RFA','client','typeProjet','VolJourVendu','BudgetVendu','codeGen',this.id);">Enregistrer</button>
                    </div>
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="projCancel" value="Annuler / Retour"> 
                    </div>
<!--                <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="taskAffectModif" value="Affecter Une Tâche"> 
                    </div> -->
                </div>
            </form>
    </div>
    
    <script src="public/js/functions/taskCreation.js"></script>
    <script src="public/js/functions/projectModifRecord.js"></script>
    <script src="public/js/functions/allowTaskModif.js"></script>
    <script src="public/js/functions/taskUpdateValidation.js"></script>
    <script src="public/js/functions/taskCreateValidation.js"></script>
    <script src="public/js/functions/getTACEandFact.js"></script>
    <script src="public/js/functions/getGeneriqueCode.js"></script>
    <script src="public/js/functions/cancelTaskModif.js"></script>
    <script src="public/js/functions/enableDisableYear.js"></script>



<!--<script src="public/js/functions/allowJOCollabModif.js"></script>
    <script src="public/js/functions/JOCollabUpdateValidation.js"></script>
    <script src="public/js/functions/getGradeAndRateCard.js"></script>
    <script src="public/js/functions/getSiteRoleList.js"></script>
    <script src="public/js/functions/collabModification.js"></script> -->

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>