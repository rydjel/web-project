<?php $title = 'Collaborateurs'; ?>
<?php ob_start(); ?>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" onclick="window.location.href='index.php';">Menu Principal</button>
            </div>
        </div>

        <header class="page-header">
            <h1> Gestion des Collaborateurs CIS </h1>
        </header>
            <br>
            <div id="message"><?php echo $message; ?></div>
            <br>
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="Nom">Nom</label>
                        <input type="text" class="form-control" placeholder="Nom" id="Nom" value=<?php echo "'".$collab['Nom']."'"?> >
                    </div>
                    <div class="col-sm-3">
                        <label for="Prénom">Prénom</label>
                        <input type="text" class="form-control" placeholder="Prénom" id="Prénom" value=<?php echo "'".$collab['Prénom']."'"?> >
                    </div>
                    <div class="col-sm-3">
                        <label for="GGID">GGID</label>
                        <input type="text" class="form-control" placeholder="GGID" id="GGID" name="GGID" value=<?php echo "'".$collab['GGID']."'"?> >
                    </div>
                    <div class="col-sm-3">
                        <label for="PU">PU</label>
                        <select id="PU" class="form-control">
                           <?php 
                            if ($puList) {
                                while ($data=$puList->fetch()) { ?>
                                    <option value=<?php  echo $data['Nom'];?> <?php if($data['Nom']==$puname['Nom']){echo "selected";} ?> ><?php  echo $data['Nom'];?></option>
                                 <?php
                                } 
                            }    
                                
                           ?> 
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <label for="Site">Site</label>
                        <select id="Site" class="form-control" onchange="getSiteRoleList(this.value,'role');">
                           <?php 
                            if ($sites) {
                                while ($data=$sites->fetch()) { ?>
                                    <option value=<?php  echo $data['ID'];?> <?php if($data['ID']==$collab['ID_Site']){echo "selected";} ?> ><?php  echo $data['Nom'];?></option>
                                 <?php
                                } 
                            }    
                                
                           ?> 
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="dateEntree">Date Entrée</label>
                        <input type="date" class="form-control" title="Date Entrée" id="dateEntree" value=<?php echo "'".$collab['Date_Entree']."'"?>>
                    </div>
                    <div class="col-sm-3">
                        <label for="dateSortie">Date Sortie</label>
                        <input type="date" class="form-control" title="Date Sortie" id="dateSortie" value=<?php echo "'".$collab['Date_Sortie']."'"?> >
                    </div>
                    <div class="col-sm-3">
                        <label for="Statut">Statut</label>
                        <input type="text" class="form-control" title="Statut" id="statut" 
                        value=<?php if((date("Y-m-d")>= $collab['Date_Entree'] and date("Y-m-d") <=$collab['Date_Sortie']) or (date("Y-m-d")>= $collab['Date_Entree'] and $collab['Date_Sortie']=='0000-00-00' )){echo "Actif";}
                        /*if(date("Y-m-d")> $collab['Date_Sortie'])*/else{echo "Inactif";}?>  readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <label for="role">role</label>
                        <select id="role" class="form-control" onchange="getCurrentYearGradeAndRC(this.value,'Site','Grade','RateCard');">
                            <?php 
                            if ($rolesList) {
                                while ($data=$rolesList->fetch()) { ?>
                                    <option value=<?php  echo "'".$data['Role']."'";?> <?php if($data['Role']==$role['Role']){echo "selected";} ?> ><?php  echo $data['Role'];?></option>
                                    <?php
                                } 
                            }     
                            ?> 
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="Grade">Grade</label>
                        <input type="text" class="form-control" placeholder="Grade" value=<?php echo "'".$grade['Grade']."'"?> id="Grade" >
                    </div>
                    <div class="col-sm-3">
                        <label for="RateCard">ADRC</label>
                        <input type="text" class="form-control" placeholder="ADRC" value=<?php echo "'".$rateCard."'"?> id="RateCard">
                    </div>
                    <div class="col-sm-3">
                        <label for="tjmCible">TJM Cible</label>
                        <input type="number" step="any" class="form-control" placeholder="TJM Cible" id="tjmCible" value=<?php echo $collab['TJMCible']; ?>>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-3">
                        <label for="pourcentageActivite">Pourcentage Activité</label>
                        <input type="text" class="form-control" placeholder="Pourcentage Activité" value=<?php echo "'".$collab['Pourcentage_Activity']."'"?> id="pourcentageActivite" >
                    </div>
                    <div class="col-sm-3">
                        <label for="support">Support</label>
                        <select id="support" class="form-control">
                            <option></option>
                            <?php
                            if ($supportList) {
                                while ($data=$supportList->fetch()) {
                                    ?>
                                    <option value=<?php echo $data['ID'];?> <?php if($data['ID']==$collab['ID_Support']){echo "selected";} ?>><?php echo $data['nom'].' '.$data['prenom'];?></option>
                                    <?php
                                }
                            } 
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="manager">Manager</label>
                        <select id="manager" class="form-control">
                            <option></option>
                            <?php
                            if ($managingList) {
                                while ($data=$managingList->fetch()) {
                                    ?>
                                    <option value=<?php echo $data['idCollab'];?> <?php if($data['idCollab']==$collab['ID_Manager']){echo "selected";} ?>><?php echo $data['Nom'].' '.$data['Prénom'];?></option>
                                    <?php
                                }
                            } 
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="CM">Carrier Manager</label>
                        <select id="CM" class="form-control">
                            <option></option>
                            <?php
                            if ($CMList) {
                                while ($data=$CMList->fetch()) {
                                    ?>
                                    <option value=<?php echo $data['idCollab'];?> <?php if($data['idCollab']==$collab['ID_CM']){echo "selected";} ?>><?php echo $data['Nom'].' '.$data['Prénom'];?></option>
                                    <?php
                                }
                            } 
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="checkbox col-sm-3">
                        <label>
                        <input type="checkbox" name="cvBook" id="cvBook" <?php if($collab['cvBook']==1){echo "checked";} ?>> <strong>CV-Book</strong>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <label for="commentaire">commentaire</label>
                        <textarea class="form-control" rows="2" title="commentaire" id="commentaire"><?php echo $collab['Commentaire'] ?></textarea>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-primary btn-block" 
                        onclick="collabModification('Nom','Prénom','GGID','PU','Site','dateEntree','dateSortie','statut','role','Grade','RateCard','pourcentageActivite','support','manager','commentaire','ID','CM','cvBook','tjmCible');">Enregistrer</button>
                    </div>
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="collabCancel" value="Annuler / Retour"> 
                    </div>
                </div>
                
                <!-- <div class="row">
                    <div class="col-sm-3">
                        <select id="select" class="form-control" name="yearJOCollabModification">
                            <option value=<?php // echo date("Y")-1;?> <?php //if($year==date("Y")-1){echo "selected";}?> ><?php // echo date("Y")-1;?></option>
                            <option value=<?php // echo date("Y");?> <?php //if($year==date("Y")){echo "selected";}?> ><?php  //echo date("Y");?></option>
                            <option value=<?php // echo date("Y")+1;?> <?php //if($year==date("Y")+1){echo "selected";}?> ><?php // echo date("Y")+1;?></option>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <input type="submit" class="btn btn-primary btn-block"name="yearJOCollabModificationFilter" value="Filter">
                        <input type="hidden" name="collab" value=<?php //echo $collab['ID']; ?> id="ID" >
                    </div> 
                </div> -->

                <!-- Profil du Collab -->
                <br><br><br>
                <!-- <div class="row"> -->
                    <!-- Rajout Nouveau Profil au cas où inexistant -->
                    <?php
                        $data=$profil->fetch();
                        if ($data==false) {
                            ?>
                            <div id="bodyProfil">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <button type="button"  id="newProfil" class="btn btn-primary btn-block" onclick="addProfil();">Rajout Profil</button>
                                    </div>
                                </div>
                                <div id="newProfilAdd"></div>
                            </div>
                            <br><br>
                        <?php
                        }else {
                            $profilDetailID="profil-".$data['ID'];
                            $profilTitleID="profilTitle-".$data['ID'];
                            //$profilDetail=$data['détails'];
                            ?>
                            <div class="row">
                                <div class="col-sm-7">
                                    <label for=<?php echo $profilTitleID; ?>>Titre</label>
                                    <select  id=<?php echo $profilTitleID; ?> class="form-control col-sm-7" name="PTChoice" disabled>
                                        <?php 
                                            if ($PTList) {
                                                while ($data2=$PTList->fetch()) {
                                                    ?>
                                                    <option value=<?php echo $data2['ID']; ?> <?php if($data2['ID']==$data['ID_PT']){echo "selected";} ?>><?php echo $data2['intitule'];?></option>
                                                <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-7">
                                    <label for=<?php echo $profilDetailID; ?>>Profil</label>
                                    <textarea class="form-control" rows="2" title="Profil" id=<?php echo $profilDetailID; ?> disabled><?php echo $data['détails'];?></textarea>
                                    <br>
                                    <button type="button" id="profilEdit" onclick="allowProfilModif('<?php echo $profilDetailID; ?>','<?php echo $profilTitleID; ?>','<?php echo 'profilValidation-'.$data['ID'];?>');">
                                    <span class='glyphicon glyphicon-edit' ></span> Editer</button>
                                    <button type="button" id=<?php echo "profilValidation-".$data['ID'];?> disabled
                                    onclick="profilUpdateValidation('<?php echo $profilDetailID; ?>',this.id,'<?php echo $profilTitleID; ?>');">
                                    <span class='glyphicon glyphicon-ok' ></span> Valider</button>
                                    <button type="button" id=<?php echo "annulerProfilModif-".$data['ID'];?> 
                                    onclick="cancelProfilModif('<?php echo $profilDetailID; ?>',this.id,'<?php echo 'profilValidation-'.$data['ID'];?>','<?php echo $profilTitleID; ?>');">
                                    <span class='glyphicon glyphicon-refresh' ></span> Rafraichir/Annuler</button>
                                </div>
                            </div>
                        <?php
                        }
                    ?> 
                    
                <!-- </div> -->
                <br>

                <!-- Compétences du Collab ! -->
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button"  id="newComp" class="btn btn-primary btn-block" onclick="newCompetence();">Nouvelle Compétence</button>
                    </div>
                </div>
                <div class="row">
                    <section class="table responsive">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th class="col-xs-1">Titre</th>
                                    <th class="col-xs-1">Niveau</th>
                                    <th class="col-xs-1"></th>
                                <tr>
                            </thead>
                            <tbody id="bodyComp">
                            <?php
                                    if ($collabComp) {
                                        while ($data=$collabComp->fetch()) {
                                            $compTitleID='compTitle-'.$data['ID'];
                                            $compLevelID='compLevel-'.$data['ID'];
                                            $compTitle=$data['Titre'];
                                            $compLevel=$data['Niveau'];
                                            ?>
                                            <tr>
                                                <td><input type="text" id=<?php echo $compTitleID; ?> class="form-control" value=<?php echo "'".$data['Titre']."'"; ?> disabled></td>
                                                <td>
                                                    <select id=<?php echo $compLevelID; ?> class="form-control" disabled>
                                                        <option value="Académique" <?php if($data['Niveau']=="Académique"){echo "selected";} ?>><?php echo "Académique"; ?></option>
                                                        <option value="Confirmé" <?php if($data['Niveau']=="Confirmé"){echo "selected";} ?>><?php echo "Confirmé"; ?></option>
                                                        <option value="Expert" <?php if($data['Niveau']=="Expert"){echo "selected";} ?>><?php echo "Expert"; ?></option>
                                                        <option value="Guru" <?php if($data['Niveau']=="Guru"){echo "selected";} ?>><?php echo "Guru"; ?></option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <button type="button" id=<?php echo "compEdit-".$data['ID'];?> onclick="allowCompModif(this.id);">
                                                    <span class='glyphicon glyphicon-edit' ></span> Editer</button>
                                                    <button type="button" id=<?php echo "compValidation-".$data['ID'];?> disabled
                                                    onclick="compUpdateValidation('<?php echo $compTitleID; ?>','<?php echo $compLevelID; ?>',this.id);">
                                                    <span class='glyphicon glyphicon-ok' ></span> Valider</button>
                                                    <button type="button" id=<?php echo "annulerCompModif-".$data['ID'];?> 
                                                    onclick="cancelCompModif('<?php echo $compTitleID; ?>','<?php echo $compLevelID; ?>',this.id,'<?php echo 'compValidation-'.$data['ID'];?>');">
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
                <br>

                <!-- Certifications du Collab -->
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button"  id="newCertif" class="btn btn-primary btn-block" onclick="newCertification();" >Nouvelle Certification</button>
                    </div>
                </div>
                
                <div class="row">
                    <section class="table responsive">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th class="col-xs-1">Titre</th>
                                    <th class="col-xs-1"></th>
                                <tr>
                            </thead>
                            <tbody id="bodyCertif">
                            <?php
                                if ($collabCertif) {
                                    while ($data=$collabCertif->fetch()) {
                                        $certifTitleID='certifTitle-'.$data['ID'];
                                        $certifTitle=$data['Titre'];
                                        
                                        ?>
                                            <tr>
                                                <td>
                                                    <input type="text" id=<?php echo $certifTitleID; ?> class="form-control" value=<?php echo "'".$data['Titre']."'";?> disabled>
                                                </td>
                                                <td>
                                                    <button type="button" id=<?php echo "certifEdit-".$data['ID'];?> onclick="allowCertifModif(this.id);">
                                                    <span class='glyphicon glyphicon-edit' ></span> Editer</button>
                                                    <button type="button" id=<?php echo "certifValidation-".$data['ID'];?> disabled
                                                    onclick="certifUpdateValidation('<?php echo $certifTitleID; ?>',this.id);">
                                                    <span class='glyphicon glyphicon-ok' ></span> Valider</button>
                                                    <button type="button" id=<?php echo "annulerCertifModif-".$data['ID'];?> 
                                                    onclick="cancelCertifModif('<?php echo $certifTitleID; ?>',this.id,'<?php echo 'certifValidation-'.$data['ID'];?>');">
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

                <!-- Expériences -->
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button"  id="newExp" class="btn btn-primary btn-block" onclick="newExperience();">Nouvelle Experience</button>
                    </div>
                </div>
                
                <div class="row">
                    <section class="table responsive">
                        <table class="table table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th class="col-xs-1">Date Debut</th>
                                <th class="col-xs-1">Date Fin</th>
                                <th class="col-xs-5">Détails</th>
                                <th class="col-xs-5"></th>
                            <tr>
                        </thead>
                        <tbody id="bodyExp">
                            <?php
                                if ($collabExp) {
                                    while ($data=$collabExp->fetch()) {
                                        $dateDebutExpID='debutExp-'.$data['ID'];
                                        $dateFinExpID='finExp-'.$data['ID'];
                                        $detailsExpID='detailExp-'.$data['ID'];
                                        $dateDebutExp=$data['Date_Debut'];
                                        $dateFinExp=$data['Date_Fin'];
                                        $detailsExp=$data['Details'];
                                        ?>
                                        <tr>
                                            <td><input type="date" id=<?php echo $dateDebutExpID; ?> class="form-control" value=<?php echo $data['Date_Debut'] ;?> disabled></td>
                                            <td><input type="date" id=<?php echo $dateFinExpID; ?> class="form-control" value=<?php echo $data['Date_Fin'] ;?> disabled></td>
                                            <td>
                                                <textarea class="form-control" rows="3" id=<?php echo $detailsExpID; ?> disabled><?php echo $data['Details'] ;?></textarea>
                                            </td>
                                            <td>
                                                <button type="button" id=<?php echo "expEdit-".$data['ID'];?> onclick="allowExpModif(this.id);">
                                                <span class='glyphicon glyphicon-edit' ></span> Editer</button>
                                                <button type="button" id=<?php echo "expValidation-".$data['ID'];?> disabled
                                                onclick="expUpdateValidation('<?php echo $dateDebutExpID; ?>','<?php echo $dateFinExpID; ?>','<?php echo $detailsExpID; ?>',this.id);">
                                                <span class='glyphicon glyphicon-ok' ></span> Valider</button>
                                                <button type="button" id=<?php echo "annulerExpModif-".$data['ID'];?> 
                                                onclick="cancelExpModif('<?php echo $dateDebutExpID; ?>','<?php echo $dateFinExpID; ?>','<?php echo $detailsExpID; ?>',this.id,'<?php echo 'expValidation-'.$data['ID'];?>');">
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

                <br><br><br>

                <div class="row">
                    <div class="col-sm-3">
                        <select id="select" class="form-control" name="yearJOCollabModification">
                            <option value=<?php  echo date("Y")-1;?> <?php if($year==date("Y")-1){echo "selected";}?> ><?php  echo date("Y")-1;?></option>
                            <option value=<?php  echo date("Y");?> <?php if($year==date("Y")){echo "selected";}?> ><?php  echo date("Y");?></option>
                            <option value=<?php  echo date("Y")+1;?> <?php if($year==date("Y")+1){echo "selected";}?> ><?php  echo date("Y")+1;?></option>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <input type="submit" class="btn btn-primary btn-block"name="yearJOCollabModificationFilter" value="Filtrer">
                        <input type="hidden" name="collab" value=<?php echo $collab['ID']; ?> id="ID" >
                    </div> 
                </div>

                <div class="row ">
                    <section class="table responsive ">
                        <table class="table table-bordered table-striped table-condensed ">
                            <thead>
                                <tr>
                                    <th class="col-xs-1">Mois</th>
                                    <th class="col-xs-1">Jours Ouvrables</th>
                                    <th class="col-xs-1">Jours Ouvrables Collaborateurs</th>
                                    <th class="col-xs-2"></th>
                                <tr>
                            </thead>
                            <tbody>
                                <?php
                                    $Mois = array('1' => 'Janvier' ,'2' => 'Février','3' => 'Mars','4' => 'Avril','5' => 'Mai','6' => 'Juin',
                                    '7' => 'Juillet','8' => 'Août','9' => 'Septembre','10' => 'Octobre','11' => 'Novembre','12' => 'Décembre');
                                    while ($data1=$workingDays->fetch() and $data2=$workingDaysCollab->fetch()) {
                                        $JOCollabFieldID="JO-".$data2['ID'];
                                        $JOCollab=$data2['NbJours'];
                                        ?>
                                            <tr>
                                                <td><?php echo $Mois[$data1['Mois']]; ?></td>
                                                <td><?php echo $data1['NbJours'];?></td>
                                                <td><input type="text" class="form-control" value=<?php if($data2['NbJours']==""){echo 0;} else{echo "'".$data2['NbJours']."'";}?> 
                                                id=<?php echo $JOCollabFieldID;?> disabled ></td>
                                                <td>
                                                <button type="button" id=<?php echo 'edit-'.$data2['ID'];?> 
                                                onclick="allowJOCollabModif('<?php echo $JOCollabFieldID;?>','<?php echo 'validation-'.$data2['ID'];?>');">
                                                <span class='glyphicon glyphicon-edit' ></span> Editer</button>
                                                <button type="button" id=<?php echo "validation-".$data2['ID'];?> disabled
                                                onclick="JOCollabUpdateValidation('<?php echo $JOCollabFieldID; ?>',this.id);">
                                                <span class='glyphicon glyphicon-ok' ></span> Valider</button>
                                                <button type="button" id=<?php echo 'annulerJOModif-'.$data2['ID'];?> 
                                                onclick="cancelJOCollabModif('<?php echo $JOCollabFieldID; ?>',this.id,'<?php echo 'validation-'.$data2['ID'];?>');">
                                                <span class='glyphicon glyphicon-refresh' ></span> Rafraichir/Annuler</button>
                                                </td>
                                            </tr>
                                    <?php
                                    }
                                ?>  
                            </tbody>
                        </table>
                    </section>
                </div>
                <br>
                <!-- <div class="row">
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-primary btn-block" 
                        onclick="collabModification('Nom','Prénom','GGID','PU','Site','dateEntree','dateSortie','statut','role','Grade','RateCard','pourcentageActivite','commentaire','ID');">Enregistrer</button>
                    </div>
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="collabCancel" value="Annuler / Retour"> 
                    </div>
                </div> -->

            </form>

    </div>
    <script src="public/js/functions/allowJOCollabModif.js"></script>
    <script src="public/js/functions/JOCollabUpdateValidation.js"></script>
    <script src="public/js/functions/getGradeAndRateCard.js"></script>
    <script src="public/js/functions/getCurrentYearGradeAndRC.js"></script>
    <script src="public/js/functions/getSiteRoleList.js"></script>
    <script src="public/js/functions/collabModification.js"></script>
    <script src="public/js/functions/newCompetence.js"></script>
    <script src="public/js/functions/collabCompValidation.js"></script>
    <script src="public/js/functions/newCertification.js"></script>
    <script src="public/js/functions/collabCertifValidation.js"></script>
    <script src="public/js/functions/newExperience.js"></script>
    <script src="public/js/functions/collabExpValidation.js"></script>
    <script src="public/js/functions/addProfil.js"></script>
    <script src="public/js/functions/collabProfilAdd.js"></script>
    <script src="public/js/functions/allowProfilModif.js"></script>
    <script src="public/js/functions/profilUpdateValidation.js"></script>
    <script src="public/js/functions/allowCompModif.js"></script>
    <script src="public/js/functions/compUpdateValidation.js"></script>
    <script src="public/js/functions/allowCertifModif.js"></script>
    <script src="public/js/functions/certifUpdateValidation.js"></script>
    <script src="public/js/functions/allowExpModif.js"></script>
    <script src="public/js/functions/expUpdateValidation.js"></script>
    <script src="public/js/functions/cancelProfilModif.js"></script>
    <script src="public/js/functions/cancelCompModif.js"></script>
    <script src="public/js/functions/cancelCertifModif.js"></script>
    <script src="public/js/functions/cancelExpModif.js"></script>
    <script src="public/js/functions/cancelJOCollabModif.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>