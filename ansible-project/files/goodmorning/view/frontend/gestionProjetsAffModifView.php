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
            <div id="message"><?php echo $message; ?></div>
            <br>
            <form action="" method="post">
                <div><input type="hidden" value=<?php echo $caller;?> name="callerView"></div>
                <div class="row">
                    <div class="col-sm-3">
                        <label for="codeProjet">Code Projet</label>
                        <input type="text" class="form-control" placeholder="Code Projet" id="codeProjet" name="codeProjet" 
                        value=<?php echo $project['Code']; ?> title="Code Projet" readonly>
                    </div>
                    <div class="col-sm-3">
                        <label for="titreProjet">Titre Projet</label>
                        <input type="text" class="form-control" placeholder="Titre Projet" id="titreProjet" 
                        value=<?php echo "'".$project['Titre']."'"; ?> title="Titre Projet" title="Titre Projet" disabled> 
                    </div>
                    <div class="col-sm-3">
                        <label for="PU">Production Unit Mandataire</label>
                        <select id="PU" class="form-control" title="Production Unit Mandataire">
                           <?php 
                           if ($puList) {
                            while ($data=$puList->fetch()) {?>
                                <option value=<?php  echo $data['ID'];?> <?php if($data['ID']==$project['ID_PU']){echo "selected";} ?> disabled><?php  echo $data['Nom'];?></option>
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
                                    <option value=<?php echo $data['ID'];?> <?php if($data['ID']==$project['ID_Client']){echo "selected";} ?> disabled> <?php echo $data['NomClient']; ?> </option>
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
                        <select id="typeProjet" class="form-control" title="Type de Projet">
                            <option value="Assistance Technique Simple" <?php if($project['TypeProjet']=="Assistance Technique Simple"){echo "selected";} ?> disabled>Assistance Technique Simple</option>
                            <option value="Engagement de Moyen" <?php if($project['TypeProjet']=="Engagement de Moyen"){echo "selected";} ?> disabled>Engagement de Moyen</option>
                            <option value="Engagement de Résultat" <?php if($project['TypeProjet']=="Engagement de Résultat"){echo "selected";} ?> disabled>Engagement de Résultat</option>
                            <option value="Activité Interne" <?php if($project['TypeProjet']=="Activité Interne"){echo "selected";} ?> disabled>Activité Interne</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="VolJourVendu">Volume Jour Vendu</label>
                        <input type="text" class="form-control" title="Volume Jour Vendu" id="VolJourVendu" value=<?php echo $project['VolJourVendu']; ?> disabled>
                        <br>
                        <label for="BudgetVendu">Budget Vendu</label>
                        <input type="text" class="form-control" title="Budget Vendu" id="BudgetVendu" value=<?php echo $project['budget']; ?> disabled>
                        <br>
                        <label for="RFA">Remise de Fin d'Année</label>
                        <input type="text" class="form-control" title="Remise de Fin d'Année" id="RFA" value=<?php echo $project['RFA']; ?> disabled>
                        <br>
                        <input type="hidden" class="form-control" name="projID" value=<?php echo $project['ID']; ?> disabled>
                    </div>
                    <div class="col-sm-3">
                        <label for="Commercial">Commercial</label>
                        <input type="text" class="form-control" title="Commercial" id="Commercial" value=<?php echo "'".$project['Commercial']."'"; ?> disabled>   
                    </div>
                    <div class="col-sm-3">
                        Code Générique   <input type="checkbox" name="codeGenerique" id="codeGen" <?php if($project['codeGenerique']==1){echo "checked";}?> disabled>
                    </div>
                </div>
                <br>
                <!-- <div class="row">
                    <div class="col-sm-3">
                        <button type="button"  id="newTask" class="btn btn-primary btn-block" onclick="taskCreation();" >Nouvelle Tâche</button>
                    </div>
                </div> -->
                <br>
                
                <section class="table-responsive col-sm-12">
                    <table id="tableTaskAffModif">
                        <thead>
                            <tr>
                                <th>Collaborateur</th>
                                <th>Rate Card</th>
                                <th>Tâche</th>
                                <th>TJM</th>
                                <th>Type Activité</th>
                                <th>Coverage</th>
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
                                <th>SOW-ID</th>
                                <th>ODM</th>
                                <th>FOP</th>
                                <th>Action</th>
                            <tr>
                        </thead>
                        <tbody id="tbody">
                                <?php
                                if ($listAffect) {
                                    while ($data=$listAffect->fetch()) {
                                        ?>
                                    <tr>
                                            <td><?php echo $data['Nom']." ".$data['Prénom'];?></td>
                                            <td><?php echo $data['RateCard'];?></td>
                                            <td><?php echo $data['Nom_Tache'];?></td>
                                            <td><input type="number" min="0" step="any" disabled id=<?php echo "tjm-".$data['idTJM'];?> value=<?php echo $data['Valeur']; ?>></td>
                                            <td><?php echo $data['Nom_typeActivite'];?></td>

                                            <td>
                                                <select id=<?php echo "coverage-".$data['idTJM'];?> name="coverage" disabled>
                                                    <option value="firm" <?php if($data['coverage']=="firm"){echo "selected";}?>>firm</option> 
                                                    <option value="named" <?php if($data['coverage']=="named"){echo "selected";}?>>named</option>
                                                </select>
                                            </td>

                                            <td><?php echo $data['Impact_TACE'];?></td>
                                            <td><input type="checkbox" disabled <?php if($data['Facturable']==1){echo "checked";}?> readonly> </td>
                                            <td><input type="number" min="0" step="any" disabled id=<?php echo "budgetInit-".$data['idTJM'];?> value=<?php echo $data['BudgetInit']; ?>> </td>
                                            <td><input type="number" min="0" step="any"  disabled id=<?php echo "budgetComp-".$data['idTJM'];?> value=<?php echo $data['BudgetComp']; ?>> </td>
                                            <td><input type="number" min="0" step="any" disabled id=<?php echo "volJourInit-".$data['idTJM'];?> value=<?php echo $data['VolJourInit']; ?>> </td>
                                            <td><input type="number" min="0" step="any" disabled id=<?php echo "volJourComp-".$data['idTJM'];?> value=<?php echo $data['VolJourComp']; ?>> </td>
                                            <td><input type="number" min="0" step="any" disabled id=<?php echo "fraisInit-".$data['idTJM'];?> value=<?php echo $data['FraisInit']; ?>> </td>
                                            <td><input type="number" min="0" step="any" disabled id=<?php echo "fraisComp-".$data['idTJM'];?> value=<?php echo $data['FraisComp']; ?>> </td>
                                            <td><input type="number" min="0" step="any" disabled id=<?php echo "autresCouts-".$data['idTJM'];?> value=<?php echo $data['AutresCouts'];?>></td>
                                            <td><?php if($data['Valeur']==0){echo 0;}else{echo round(($data['Valeur']-$data['RateCard'])/$data['Valeur']*100,2);}?></td>
                                            <td>
                                            <select id=<?php echo "debutAnnee-".$data['idTJM'];?> disabled>
                                                <option value=<?php echo date("Y")-1;?> <?php if($data['Annee_Debut']==date("Y")-1){echo "selected";}?>><?php echo date("Y")-1;?></option>
                                                <option value=<?php echo date("Y");?> <?php if($data['Annee_Debut']==date("Y")){echo "selected";}?>><?php echo date("Y");?></option>
                                                <option value=<?php echo date("Y")+1;?> <?php if($data['Annee_Debut']==date("Y")+1){echo "selected";}?>><?php echo date("Y")+1;?></option>
                                            </select> 
                                                <!-- <input type="text" id=<?php //echo "debutAnnee-".$data['idTJM'];?> value=<?php //echo $data['Annee_Debut'];?> readonly> -->
                                            </td>
                                        <td>
                                            <select id=<?php echo "debutMois-".$data['idTJM'];?> disabled>
                                                <option value="1" <?php if($data['Mois_Debut']==1){echo "selected";}?>><?php echo "Janvier";?></option>
                                                <option value="2" <?php if($data['Mois_Debut']==2){echo "selected";}?>><?php echo "Fevrier";?></option>
                                                <option value="3" <?php if($data['Mois_Debut']==3){echo "selected";}?>><?php echo "Mars";?></option>
                                                <option value="4" <?php if($data['Mois_Debut']==4){echo "selected";}?>><?php echo "Avril";?></option>
                                                <option value="5" <?php if($data['Mois_Debut']==5){echo "selected";}?>><?php echo "Mai";?></option>
                                                <option value="6" <?php if($data['Mois_Debut']==6){echo "selected";}?>><?php echo "Juin";?></option>
                                                <option value="7" <?php if($data['Mois_Debut']==7){echo "selected";}?>><?php echo "Juillet";?></option>
                                                <option value="8" <?php if($data['Mois_Debut']==8){echo "selected";}?>><?php echo "Août";?></option>
                                                <option value="9" <?php if($data['Mois_Debut']==9){echo "selected";}?>><?php echo "Septembre";?></option>
                                                <option value="10" <?php if($data['Mois_Debut']==10){echo "selected";}?>><?php echo "Octobre";?></option>
                                                <option value="11" <?php if($data['Mois_Debut']==11){echo "selected";}?>><?php echo "Novembre";?></option>
                                                <option value="12" <?php if($data['Mois_Debut']==12){echo "selected";}?>><?php echo "Décembre";?></option>
                                            </select>      
                                        </td>
                                        <td>
                                            <select id=<?php echo "finAnnee-".$data['idTJM'];?> disabled>
                                                <option value=<?php echo date("Y")-1;?> <?php if($data['Annee_Fin']==date("Y")-1){echo "selected";}?>><?php echo date("Y")-1;?></option>
                                                <option value=<?php echo date("Y");?> <?php if($data['Annee_Fin']==date("Y")){echo "selected";}?>><?php echo date("Y");?></option>
                                                <option value=<?php echo date("Y")+1;?> <?php if($data['Annee_Fin']==date("Y")+1){echo "selected";}?>><?php echo date("Y")+1;?></option>
                                            </select>
                                            <!-- <input type="text" id=<?php //echo "finAnnee-".$data['idTJM'];?> value=<?php //echo $data['Annee_Fin'];?> readonly> -->
                                        </td>
                                        <td>
                                            <select id=<?php echo "finMois-".$data['idTJM'];?> disabled>
                                                <option value="1" <?php if($data['Mois_Fin']==1){echo "selected";}?>><?php echo "Janvier";?></option>
                                                <option value="2" <?php if($data['Mois_Fin']==2){echo "selected";}?>><?php echo "Fevrier";?></option>
                                                <option value="3" <?php if($data['Mois_Fin']==3){echo "selected";}?>><?php echo "Mars";?></option>
                                                <option value="4" <?php if($data['Mois_Fin']==4){echo "selected";}?>><?php echo "Avril";?></option>
                                                <option value="5" <?php if($data['Mois_Fin']==5){echo "selected";}?>><?php echo "Mai";?></option>
                                                <option value="6" <?php if($data['Mois_Fin']==6){echo "selected";}?>><?php echo "Juin";?></option>
                                                <option value="7" <?php if($data['Mois_Fin']==7){echo "selected";}?>><?php echo "Juillet";?></option>
                                                <option value="8" <?php if($data['Mois_Fin']==8){echo "selected";}?>><?php echo "Août";?></option>
                                                <option value="9" <?php if($data['Mois_Fin']==9){echo "selected";}?>><?php echo "Septembre";?></option>
                                                <option value="10" <?php if($data['Mois_Fin']==10){echo "selected";}?>><?php echo "Octobre";?></option>
                                                <option value="11" <?php if($data['Mois_Fin']==11){echo "selected";}?>><?php echo "Novembre";?></option>
                                                <option value="12" <?php if($data['Mois_Fin']==12){echo "selected";}?>><?php echo "Décembre";?></option>
                                            </select>                         
                                        </td>
                                        <td>
                                            <select id=<?php echo "isow-".$data['idTJM'];?> name="isow" disabled>
                                                <option value="A faire" <?php if($data['ISOW']=="A faire"){echo "selected";}?>><?php echo "A faire";?></option> 
                                                <option value="En cours" <?php if($data['ISOW']=="En cours"){echo "selected";}?>><?php echo "En cours";?></option>
                                                <option value="Sign Off" <?php if($data['ISOW']=="Sign Off"){echo "selected";}?>><?php echo "Sign Off";?></option>
                                                <option value="S.O" <?php if($data['ISOW']=="S.O"){echo "selected";}?>><?php echo "S.O";?></option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="sowid" id=<?php echo "sowid-".$data['idTJM'];?> value=<?php echo $data['SOW_ID']; ?> disabled>
                                        </td>
                                        <td>
                                            <select id=<?php echo "odm-".$data['idTJM'];?> name="odm" disabled>
                                                <option value="A faire" <?php if($data['ODM']=="A faire"){echo "selected";}?>><?php echo "A faire";?></option> 
                                                <option value="En cours" <?php if($data['ODM']=="En cours"){echo "selected";}?>><?php echo "En cours";?></option>
                                                <option value="Sign Off" <?php if($data['ODM']=="Sign Off"){echo "selected";}?>><?php echo "Sign Off";?></option>
                                                <option value="S.O" <?php if($data['ODM']=="S.O"){echo "selected";}?>><?php echo "S.O";?></option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="checkbox" class="form-control" title="fop" id=<?php echo "fop-".$data['idTJM'];?> <?php if($data['FOP']==1){echo "checked";} ?> disabled>        
                                        </td>
                                        <td>
                                        <button type="button" id=<?php echo "edit-".$data['idTJM'];?> onclick="allowAffModif(this.id);">
                                        <span class="glyphicon glyphicon-edit"></span> Editer</button>
                                        <button type="button" id=<?php echo "validation-".$data['idTJM'];?> disabled
                                        onclick="affUpdateValidation('<?php echo 'tjm-'.$data['idTJM'];?>','<?php echo 'budgetInit-'.$data['idTJM'];?>','<?php echo 'budgetComp-'.$data['idTJM'];?>',
                                                                    '<?php echo 'volJourInit-'.$data['idTJM'];?>','<?php echo 'volJourComp-'.$data['idTJM'];?>',
                                                                    '<?php echo 'fraisInit-'.$data['idTJM'];?>','<?php echo 'fraisComp-'.$data['idTJM'];?>',
                                                                    '<?php echo 'autresCouts-'.$data['idTJM'];?>','<?php echo 'debutAnnee-'.$data['idTJM'];?>',
                                                                    '<?php echo 'debutMois-'.$data['idTJM'];?>','<?php echo 'finAnnee-'.$data['idTJM'];?>',
                                                                    '<?php echo 'finMois-'.$data['idTJM'];?>','<?php echo 'isow-'.$data['idTJM'];?>','<?php echo 'sowid-'.$data['idTJM'];?>',
                                                                    '<?php echo 'odm-'.$data['idTJM'];?>','<?php echo 'fop-'.$data['idTJM'];?>',this.id,'<?php echo 'coverage-'.$data['idTJM'];?>',
                                                                    '<?php echo $data['idCollab'];?>','<?php echo $data['idTask'];?>');">
                                        <span class="glyphicon glyphicon-ok"></span>Valider</button>
                                        <button type="button" id=<?php echo "annulation-".$data['idTJM'];?> disabled
                                        onclick="cancelAffUpdate('<?php echo 'tjm-'.$data['idTJM'];?>','<?php echo 'budgetInit-'.$data['idTJM'];?>','<?php echo 'budgetComp-'.$data['idTJM'];?>',
                                                                    '<?php echo 'volJourInit-'.$data['idTJM'];?>','<?php echo 'volJourComp-'.$data['idTJM'];?>',
                                                                    '<?php echo 'fraisInit-'.$data['idTJM'];?>','<?php echo 'fraisComp-'.$data['idTJM'];?>',
                                                                    '<?php echo 'autresCouts-'.$data['idTJM'];?>','<?php echo 'debutAnnee-'.$data['idTJM'];?>',
                                                                    '<?php echo 'debutMois-'.$data['idTJM'];?>','<?php echo 'finAnnee-'.$data['idTJM'];?>',
                                                                    '<?php echo 'finMois-'.$data['idTJM'];?>','<?php echo 'isow-'.$data['idTJM'];?>','<?php echo 'sowid-'.$data['idTJM'];?>',
                                                                    '<?php echo 'odm-'.$data['idTJM'];?>','<?php echo 'fop-'.$data['idTJM'];?>',this.id,'<?php echo 'validation-'.$data['idTJM'];?>',
                                                                    '<?php echo 'coverage-'.$data['idTJM'];?>');">
                                        <span class="glyphicon glyphicon-refresh"></span> Rafraichir/Annuler</button>
                                        </td>
                                    </tr>
                                        <?php
                                    }   
                                }
                                    
                                ?>
                                <tr>
                                    <td>
                                        <select id="collabChoice" name="collab" onchange="getCollabRateCard(this.value,'rateCard');">
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
                                        <input type="text" title="rateCard" id="rateCard" disabled>
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
                                        <input type="number" min="0" step="any" title="TJM" id="TJM" name="tjm" value="" onchange="getContrib(this.value,'rateCard','Contrib');">
                                    </td>
                                    <td>
                                        <input type="text" title="typeActivite" id="typeActivite" value="" disabled>
                                    </td>
                                    <td>
                                        <select id="coverage" name="coverage">
                                            <option value="firm" <?php echo "selected";?>>firm</option> 
                                            <option value="named">named</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" title="TACE" id="tace" value="" disabled>  
                                    </td>
                                    <td>
                                        <input type="checkbox" title="facturable" id="facturable" value="" disabled>
                                    </td>
                                    <td>
                                        <input type="number" min="0" step="any" title="budgetInit" id="budgetInit" name="budgetInit" value="">
                                    </td>
                                    <td>
                                        <input type="number" min="0" step="any" title="budgetComp" id="budgetComp" name="budgetComp" value="">
                                    </td>
                                    <td>
                                        <input type="number" min="0" step="any" title="volJoursInit" id="volJoursInit" name="volJoursInit" value="">
                                    </td>
                                    <td>
                                        <input type="number" min="0" step="any" title="volJoursComp" id="volJoursComp" name="volJoursComp" value="">
                                    </td>
                                    <td>
                                        <input type="number" min="0" step="any" title="fraisInit" id="fraisInit" name="fraisInit" value="">
                                    </td>
                                    <td>
                                        <input type="number" min="0" step="any" title="fraisComp" id="fraisComp" name="fraisComp" value="">
                                    </td>
                                    <td>
                                        <input type="number" min="0" step="any" title="Autres Coûts" id="autresCouts" name="autresCouts" value="">
                                    </td>
                                    <td>
                                        <input type="number" min="0" step="any" title="Contrib" id="Contrib" disabled>
                                    </td>
                                    <td>
                                        <select id="debutAnnee" name="debutAnnee">
                                            <option value=<?php echo date("Y")-1;?>><?php echo date("Y")-1;?></option>
                                            <option value=<?php echo date("Y");?> selected><?php echo date("Y");?></option>
                                            <option value=<?php echo date("Y")+1;?>><?php echo date("Y")+1;?></option>
                                        </select>
                                    </td>
                                    <td>
                                        <select id="debutMois" name="debutMois">
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
                                        <select id="finAnnee" name="finAnnee">
                                            <option value=<?php echo date("Y")-1;?>><?php echo date("Y")-1;?></option>
                                            <option value=<?php echo date("Y");?> selected><?php echo date("Y");?></option>
                                            <option value=<?php echo date("Y")+1;?>><?php echo date("Y")+1;?></option>
                                        </select>
                                    </td>
                                    <td>
                                        <select id="finMois" name="finMois">
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
                                            <option value="S.O"><?php echo "S.O";?></option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="sowid" id="sowid">
                                    </td>
                                    <td>
                                        <select id="odm" name="odm">
                                            <option value="A faire"><?php echo "A faire";?></option> 
                                            <option value="En cours"><?php echo "En cours";?></option>
                                            <option value="Sign Off"><?php echo "Sign Off";?></option>
                                            <option value="S.O"><?php echo "S.O";?></option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="form-control" id="fop" name="FOPCheck"/>        
                                    </td>
                                    <td>
                                        <!-- <button type="submit" id="AffectValidation" name="AffectValidation">
                                        <span class="glyphicon glyphicon-ok"></span>Valider</button> -->
                                        <button type="button" id="AffectValidation" 
                                        onclick="taskAffectValidation('collabChoice','task','TJM','budgetInit','budgetComp','volJoursInit','volJoursComp',
                                        'fraisInit','fraisComp','autresCouts','debutAnnee','debutMois','finAnnee','finMois','isow','odm','fop','coverage','sowid','codeProjet');">
                                        <span class="glyphicon glyphicon-ok"></span>Valider</button>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </section>
                
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="projTaskAffCancel" value="Retour">
                        <!-- <button type="button" class="btn btn-primary btn-block" onclick="window.history.back();">Retour</button>  -->
                    </div>
                </div>
            </form>

    </div>
    
    <script src="public/js/functions/allowAffModif.js"></script>
    <script src="public/js/functions/taskAffectValidation.js"></script>
    <script src="public/js/functions/affUpdateValidation.js"></script>
    <script src="public/js/functions/closeAffModal.js"></script>
    <script src="public/js/functions/affModalValidate.js"></script>
    <script src="public/js/functions/getCollabRateCard.js"></script>
    <script src="public/js/functions/getTaskActivity.js"></script>
    <script src="public/js/functions/cancelAffUpdate.js"></script>
    <script src="public/js/functions/getContrib.js"></script>


<!--<script src="public/js/functions/allowJOCollabModif.js"></script>
    <script src="public/js/functions/JOCollabUpdateValidation.js"></script>
    <script src="public/js/functions/getGradeAndRateCard.js"></script>
    <script src="public/js/functions/getSiteRoleList.js"></script>
    <script src="public/js/functions/collabModification.js"></script> -->



<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

<!-- Fenêtre Modal en cas de modification de périodes pour des affection ayant des imputations -->
<div class="modal" id="ModifPeriodAffModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" id="modalClose" class="close form-group" data-dismiss="modal" onclick="closeAffModal('ModifPeriodAffModal');">&times;</button>
        <h4 class="modal-title">Modification d'Affectations</h4>
      </div>
      <div class="modal-body">
        <p><strong><h3>Le(s) mois supprimé(s) par le changement de période d'affectation contient des imputations.
        En poursuivant, vous allez les supprimer. Êtes-vous sûrs de continuer ? Si oui, Merci de VALIDER.</h3></strong></p>
        <input type="hidden" val="" id="AffModifParam">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="affModalValidate('AffModifParam','ModifPeriodAffModal');">Valider</button>
      </div>
    </div>
  </div>
</div>

<!-- <script>
    $(function () {
        $('#modalClose').on('click', function () {
            $('#ModifPeriodAffModal').hide();
            location.reload(true);
        })
    })

</script> -->

