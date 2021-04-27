<?php $title = 'Projets'; ?>
<link href="public/css/screens/affectationView.css" rel="stylesheet"/>
<?php ob_start(); ?>
    <div class="container-fluid">
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
            <div id="message"></div>
            <br>
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="codeProjet">Code Projet</label>
                        <input type="text" class="form-control" placeholder="Code Projet" id="codeProjet" 
                        value=<?php echo $codeProj; ?> title="Code Projet" disabled>
                    </div>
                    <div class="col-sm-3">
                        <label for="titreProjet">Titre Projet</label>
                        <input type="text" class="form-control" placeholder="Titre Projet" id="titreProjet" 
                        value=<?php echo $titre; ?> title="Titre Projet" title="Titre Projet" disabled>
                    </div>
                    <div class="col-sm-3">
                        <label for="PU">Production Unit Mandataire</label>
                        <select id="PU" class="form-control" title="Production Unit Mandataire" name="PU" disabled>
                           <?php 
                           if ($puList) {
                                while ($data=$puList->fetch()) {?>
                                    <option value=<?php  echo $data['ID'];?> <?php if($data['ID']==$idPU){echo "selected";} ?>><?php  echo $data['Nom'];?></option>
                                <?php
                                }
                           }     
                           ?> 
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="client">Client</label>
                        <select id="client" class="form-control" title="Client" disabled>
                            <?php
                            if ($clientList) {
                                while ($data=$clientList->fetch()) { ?>
                                    <option value=<?php echo $data['ID'];?> <?php if($data['ID']==$idClient){echo "selected";} ?> > <?php echo $data['NomClient']; ?> </option>
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
                        <select id="typeProjet" class="form-control" title="Type de Projet" disabled>
                            <option value="Assistance Technique Simple" <?php if($typeProjet=="Assistance Technique Simple"){echo "selected";} ?>>Assistance Technique Simple</option>
                            <option value="Engagement de Moyen" <?php if($typeProjet=="Engagement de Moyen"){echo "selected";} ?>>Engagement de Moyen</option>
                            <option value="Engagement de Résultat" <?php if($typeProjet=="Engagement de Résultat"){echo "selected";} ?>>Engagement de Résultat</option>
                            <option value="Activité Interne" <?php if($typeProjet=="Activité Interne"){echo "selected";} ?>>Activité Interne</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="VolJourVendu">Volume Jour Vendu</label>
                        <input type="text" class="form-control" title="Volume Jour Vendu" id="VolJourVendu" value=<?php echo $volJourVendu; ?> disabled>
                        <br>
                        <label for="BudgetVendu">Budget Vendu</label>
                        <input type="text" class="form-control" title="Budget Vendu" id="BudgetVendu" value=<?php echo $budget; ?> disabled>
                        <br>
                        <label for="RFA">Remise de Fin d'Année</label>
                        <input type="text" class="form-control" title="Remise de Fin d'Année" id="RFA" value=<?php echo $RFA; ?> disabled>
                    </div>
                    <div class="col-sm-3">
                        <label for="Commercial">Commercial</label>
                        <input type="text" class="form-control" title="Commercial" id="Commercial" value=<?php echo "'".$project['Commercial']."'"; ?> disabled>   
                    </div>
                    <div class="col-sm-3">
                        Code Générique   <input type="checkbox" name="codeGenerique" id="codeGen" <?php if($codeGenerique==1){echo "checked";}?> disabled>
                    </div>
                </div>
                <br>
                <!-- <div class="row">
                    <div class="col-sm-3">
                        <button type="button"  id="newAff" class="btn btn-primary btn-block" onclick="newAff();">Nouvelle Affectation</button>.
                    </div>
                </div>
                <br> -->
               
                <!-- <input type="hidden" value=1 id="numberAffect"> -->

               
                    <section class="table-responsive col-xs-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Collaborateur</th>
                                    <th>Rate Card</th>
                                    <th>Tâche</th>
                                    <th>TJM</th>
                                    <th>Type Activité</th>
                                    <th>Impact TACE</th>
                                    <th>Facturable</th>
                                    <th>Budget(init.)</th>
                                    <th>Budget(comp.)</th>
                                    <th>Volume Jours (init.)</th>
                                    <th>Volume Jours (comp.)</th>
                                    <th>Frais (init.)</th>
                                    <th>Frais (comp.)</th>
                                    <th>Autres Coûts </th>
                                    <th>Contrib</th>
                                    <th>Année-Initiale</th>
                                    <th>Mois-Initial</th>
                                    <th>Année-Finale</th>
                                    <th>Mois-Final</th>
                                    <th>ISOW</th>
                                    <th>ODM</th>
                                    <th>FOP</th>
                                    <th>Action</th>
                                <tr>
                            </thead>
                            <tbody id="tbody">
                                    <tr>
                                        <td>
                                            <select id="collabChoice" class="form-control" name="collab" onchange="getCollabRateCard(this.value,'rateCard','Contrib');">
                                                <option value="" selected></option> 
                                                <?php
                                                if ($collabs) {
                                                    while ($data=$collabs->fetch()) { ?>
                                                        <option value=<?php echo $data['ID']; ?> > <?php echo $data['Nom']." ".$data['Prénom']; ?> </option>
                                                        <?php
                                                    }
                                                }
                                                    
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" title="rateCard" id="rateCard">
                                        </td>
                                        <td>
                                            <select id="task" name="task" onchange="getTaskActivity(this.value,'typeActivite','tace','facturable');">
                                                <option value="" selected></option> 
                                                <?php
                                                if ($taskList) {
                                                    while ($data=$taskList->fetch()) { ?>
                                                        <option value=<?php echo $data['taskID']; ?> > <?php echo $data['Nom_Tache']; ?> </option>
                                                        <?php
                                                    }
                                                }   
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" title="TJM" id="TJM" value="">
                                        </td>
                                        <td>
                                            <input type="text" title="typeActivite" id="typeActivite" value="">
                                        </td>
                                        <td>
                                            <input type="text" title="TACE" id="tace" value="">  
                                        </td>
                                        <td>
                                            <input type="checkbox" class="form-control" title="facturable" id="facturable" value="">
                                        </td>
                                        <td>
                                            <input type="text"  class="form-control" title="budgetInit" id="budgetInit" value="">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" title="budgetComp" id="budgetComp" value="">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" title="volJoursInit" id="volJoursInit" value="">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" title="volJoursComp" id="volJoursComp" value="">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" title="fraisInit" id="fraisInit" value="">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" title="fraisComp" id="fraisComp" value="">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" title="Autres Coûts" id="autresCouts" value="">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" title="Contrib" id="Contrib">
                                        </td>
                                        <td>
                                            <select id="debutAnnee">
                                                <option value=<?php echo date("Y")-1;?>><?php echo date("Y")-1;?></option>
                                                <option value=<?php echo date("Y");?> selected><?php echo date("Y");?></option>
                                                <option value=<?php echo date("Y")+1;?>><?php echo date("Y")+1;?></option>
                                            </select>
                                        </td>
                                        <td>
                                            <select id="debutMois">
                                                <option value="Janvier"><?php echo "Janvier";?></option>
                                                <option value="Fevrier"><?php echo "Fevrier";?></option>
                                                <option value="Mars"><?php echo "Mars";?></option>
                                                <option value="Avril"><?php echo "Avril";?></option>
                                                <option value="Mai"><?php echo "Mai";?></option>
                                                <option value="Juin"><?php echo "Juin";?></option>
                                                <option value="Juillet"><?php echo "Juillet";?></option>
                                                <option value="Août"><?php echo "Août";?></option>
                                                <option value="Septembre"><?php echo "Septembre";?></option>
                                                <option value="Octobre"><?php echo "Octobre";?></option>
                                                <option value="Novembre"><?php echo "Novembre";?></option>
                                                <option value="Décembre"><?php echo "Décembre";?></option>
                                            </select>      
                                        </td>
                                        <td>
                                            <select id="finAnnee">
                                                <option value=<?php echo date("Y")-1;?>><?php echo date("Y")-1;?></option>
                                                <option value=<?php echo date("Y");?> selected><?php echo date("Y");?></option>
                                                <option value=<?php echo date("Y")+1;?>><?php echo date("Y")+1;?></option>
                                            </select>
                                        </td>
                                        <td>
                                            <select id="finMois">
                                                <option value="Janvier"><?php echo "Janvier";?></option>
                                                <option value="Fevrier"><?php echo "Fevrier";?></option>
                                                <option value="Mars"><?php echo "Mars";?></option>
                                                <option value="Avril"><?php echo "Avril";?></option>
                                                <option value="Mai"><?php echo "Mai";?></option>
                                                <option value="Juin"><?php echo "Juin";?></option>
                                                <option value="Juillet"><?php echo "Juillet";?></option>
                                                <option value="Août"><?php echo "Août";?></option>
                                                <option value="Septembre"><?php echo "Septembre";?></option>
                                                <option value="Octobre"><?php echo "Octobre";?></option>
                                                <option value="Novembre"><?php echo "Novembre";?></option>
                                                <option value="Décembre"><?php echo "Décembre";?></option>
                                            </select>                         
                                        </td>
                                        <td>
                                            <select id="isow" name="isow">
                                                <option value="A faire"><?php echo "A faire";?></option> 
                                                <option value="En cours"><?php echo "En cours";?></option>
                                                <option value="Sign Off"><?php echo "Sign Off";?></option>
                                            </select>
                                        </td>
                                        <td>
                                            <select id="odm" name="odm">
                                                <option value="A faire"><?php echo "A faire";?></option> 
                                                <option value="En cours"><?php echo "En cours";?></option>
                                                <option value="Sign Off"><?php echo "Sign Off";?></option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="checkbox" class="form-control" title="fop" id="fop" value="">        
                                        </td>
                                        <td>
                                            <button type="button" id="AffectValidation" 
                                            onclick="taskAffectValidation('collabChoice','task','TJM','budgetInit','budgetComp','volJoursInit','volJoursComp',
                                            'fraisInit','fraisComp','autresCouts','debutAnnee','debutMois','finAnnee','finMois','isow','odm','fop');">
                                            <span class="glyphicon glyphicon-ok"></span>Valider</button>
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                    </section>
               
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="projCancel" value="Retour"> 
                    </div>
                </div>
            </form>

    </div>
    

    <script src="public/js/functions/getCollabRateCard.js"></script>
    <script src="public/js/functions/getTaskActivity.js"></script>
    <script src="public/js/functions/taskAffectValidation.js"></script>

    <script src="public/js/functions/taskCreation.js"></script>
    <script src="public/js/functions/projectModifRecord.js"></script>
    <script src="public/js/functions/allowTaskModif.js"></script>
    <script src="public/js/functions/taskUpdateValidation.js"></script>
    <script src="public/js/functions/taskCreateValidation.js"></script>


<!--<script src="public/js/functions/allowJOCollabModif.js"></script>
    <script src="public/js/functions/JOCollabUpdateValidation.js"></script>
    <script src="public/js/functions/getGradeAndRateCard.js"></script>
    <script src="public/js/functions/getSiteRoleList.js"></script>
    <script src="public/js/functions/collabModification.js"></script> -->

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>