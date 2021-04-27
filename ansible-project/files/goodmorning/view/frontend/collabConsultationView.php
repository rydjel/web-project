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
                    <input type="text" class="form-control" title="Nom" value=<?php echo "'".$collab['Nom']."'"?> id="Nom" readonly >
                    </div>
                    <div class="col-sm-3">
                    <label for="Prénom">Prénom</label>
                    <input type="text" class="form-control" title="Prénom" value=<?php echo "'".$collab['Prénom']."'"?> id="Prénom" readonly >
                    </div>
                    <div class="col-sm-3">
                    <label for="GGID">GGID</label>
                    <input type="text" class="form-control" title="GGID" value=<?php echo "'".$collab['GGID']."'"?> id="GGID" readonly >
                    </div>
                    <div class="col-sm-3">
                    <label for="PU">PU</label>
                    <input type="text" class="form-control" title="PU" value=<?php echo "'".$puname['Nom']."'"?> id="PU" readonly >
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                    <label for="Site">Site</label>
                    <input type="text" class="form-control" title="Site" value=<?php echo "'".$siteName['Nom']."'"?> id="Site" readonly >
                    </div>
                    <div class="col-sm-3">
                    <label for="dateEntree">Date Entrée</label>
                    <input type="date" class="form-control" title="Date Entrée" value=<?php echo "'".$collab['Date_Entree']."'"?> id="dateEntree" readonly >
                    </div>
                    <div class="col-sm-3">
                    <label for="dateSortie">Date Sortie</label>
                    <input type="date" class="form-control" title="Date Sortie" value=<?php echo "'".$collab['Date_Sortie']."'"?>  id="dateSortie"  readonly >
                    </div>
                    <div class="col-sm-3">
                    <label for="Statut">Statut</label>
                    <input type="text" class="form-control" title="Statut" id="statut"
                    <?php $currentDate=date("Y-m-d");  ?>
                    value=<?php if((date("Y-m-d")>= $collab['Date_Entree'] and date("Y-m-d") <=$collab['Date_Sortie']) or (date("Y-m-d")>= $collab['Date_Entree'] and $collab['Date_Sortie']=='0000-00-00' )){echo "Actif";}
                    /*if(date("Y-m-d")> $collab['Date_Sortie'])*/else{echo "Inactif";}?> readonly >
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                    <label for="role">role</label>
                    <input type="text" class="form-control" title="Role" value=<?php echo "'".$role['Role']."'"?> id="role" readonly >
                    </div>
                    <div class="col-sm-3">
                    <label for="Grade">Grade</label>
                    <input type="text" class="form-control" title="Grade" value=<?php echo "'".$grade['Grade']."'"?> id="Grade" disabled >
                    </div>
                    <div class="col-sm-3">
                    <label for="RateCard">ADRC</label>
                    <input type="text" class="form-control" title="ADRC" value=<?php echo "'".$rateCard."'"?> id="RateCard" disabled >
                    </div>
                    <div class="col-sm-3">
                        <label for="tjmCible">TJM Cible</label>
                        <input type="number" step="any" class="form-control" placeholder="TJM Cible" id="tjmCible" value=<?php echo $collab['TJMCible']; ?> disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                    <label for="pourcentageActivite">Pourcentage Activité</label>
                    <input type="text" class="form-control" title="Pourcentage Activité" value=<?php echo "'".$collab['Pourcentage_Activity']."'"?> id="pourcentageActivite" readonly >
                    </div>
                    <div class="col-sm-3">
                        <label for="supportTeam">Support</label>
                        <input type="text" id="supportTeam" class="form-control" value="<?php echo $support['nom'].' '.$support['prenom'];?>" readonly>
                    </div>
                    <div class="col-sm-3">
                        <label for="managerTeam">Manager</label>
                        <input type="text" id="managerTeam" class="form-control" value="<?php echo $manager['Nom'].' '.$manager['Prénom'];?>" readonly>
                    </div>
                    <div class="col-sm-3">
                        <label for="CM">Carrier Manager</label>
                        <input type="text" id="CM" class="form-control" value="<?php echo $CM['Nom'].' '.$CM['Prénom'];?>" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="checkbox col-sm-3">
                        <label>
                        <input type="checkbox" name="cvBook" id="cvBook" <?php if($collab['cvBook']==1){echo "checked";} ?> readonly> <strong>CV-Book</strong>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <label for="commentaire">commentaire</label>
                        <textarea class="form-control" rows="2" title="commentaire" id="commentaire" readonly><?php echo $collab['Commentaire'] ?></textarea>
                    </div>
                </div>
                <br><br><br>
                <!-- <div class="row">
                    <div class="col-sm-3">
                        <select id="select" class="form-control" name="yearJOCollab">
                            <option value=<?php  //echo date("Y")-1;?> <?php //if($year==date("Y")-1){echo "selected";}?> ><?php  //echo date("Y")-1;?></option>
                            <option value=<?php  //echo date("Y");?> <?php //if($year==date("Y")){echo "selected";}?> ><?php // echo date("Y");?></option>
                            <option value=<?php // echo date("Y")+1;?> <?php //if($year==date("Y")+1){echo "selected";}?> ><?php  //echo date("Y")+1;?></option>
                        </select>
                    </div>
                    <div class="col-xs-1">
                        <input type="submit" class="btn btn-primary btn-block"name="yearJOCollabFilter" value="Filter">
                        <input type="hidden" name="collab" value=<?php //echo $collab['ID']; ?> >
                    </div> 
                </div> -->
                <!-- Profil -->
                <div class="row">
                    <div class="col-sm-7">
                        <label for="profTitle">Titre</label>
                        <input type="text" class="form-control" id="profTitle" readonly value=<?php echo "'".$profil['intitule']."'";?> >
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <label for="profil">Profil</label>
                        <textarea class="form-control" rows="2" title="Profil" id="profil" readonly><?php
                              
                                    //$data=$profil->fetch();
                                    echo $profil['détails'];
                                
                            ?>
                        </textarea>
                    </div>
                </div>
                <br>
                
                <!-- Affichage compétences -->
                <h3>Compétences</h3>
                <div class="row">
                    <section class="table responsive">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th class="col-xs-1">Titre</th>
                                    <th class="col-xs-1">Niveau</th>
                                <tr>
                            </thead>
                            <tbody id="bodyComp">
                                <?php
                                    if ($collabComp) {
                                        while ($data=$collabComp->fetch()) {
                                            ?>
                                            <tr>
                                                <td><?php echo $data['Titre']; ?></td>
                                                <td>
                                                    <select disabled class="form-control">
                                                        <option <?php if($data['Niveau']=="Académique"){echo "selected";} ?>><?php echo "Académique"; ?></option>
                                                        <option <?php if($data['Niveau']=="Confirmé"){echo "selected";} ?>><?php echo "Confirmé"; ?></option>
                                                        <option <?php if($data['Niveau']=="Expert"){echo "selected";} ?>><?php echo "Expert"; ?></option>
                                                        <option <?php if($data['Niveau']=="Guru"){echo "selected";} ?>><?php echo "Guru"; ?></option>
                                                    </select>
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
                
                <!-- Liste des Certifications -->
                <div class="row">
                    <section class="table-responsive">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th><h3>Certificats</h3></th>
                                <tr>
                            </thead>
                            <tbody id="bodyCertif">
                                <?php
                                    if ($collabCertif) {
                                        while ($data=$collabCertif->fetch()) {
                                            ?>
                                                <tr><td><input type="text" class="form-control" value=<?php echo "'".$data['Titre']."'";?> readonly></td></tr>
                                            <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </section>
                </div>
                <br>

                <!-- Liste des expériences -->
                <h3>Expériences</h3>
                <div class="row">
                    <section class="table responsive">
                        <table class="table table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th class="col-xs-1">Date Debut</th>
                                <th class="col-xs-1">Date Fin</th>
                                <th class="col-xs-7">Détail</th>
                            <tr>
                        </thead>
                        <tbody id="bodyExp">
                            <?php
                                if ($collabExp) {
                                    while ($data=$collabExp->fetch()) {
                                        ?>
                                        <tr>
                                            <td><?php echo $data['Date_Debut'] ;?></td>
                                            <td><?php echo $data['Date_Fin'] ;?></td>
                                            <td><?php echo $data['Details'];?></td>
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
                        <select id="select" class="form-control" name="yearJOCollab">
                            <option value=<?php  echo date("Y")-1;?> <?php if($year==date("Y")-1){echo "selected";}?> ><?php  echo date("Y")-1;?></option>
                            <option value=<?php  echo date("Y");?> <?php if($year==date("Y")){echo "selected";}?> ><?php  echo date("Y");?></option>
                            <option value=<?php  echo date("Y")+1;?> <?php if($year==date("Y")+1){echo "selected";}?> ><?php  echo date("Y")+1;?></option>
                        </select>
                    </div>
                    <div class="col-xs-1">
                        <input type="submit" class="btn btn-primary btn-block"name="yearJOCollabFilter" value="Filter">
                        <input type="hidden" name="collab" value=<?php echo $collab['ID']; ?> >
                    </div> 
                </div>

                <div class="row ">
                    <section class="table responsive ">
                        <table class="table table-bordered table-striped table-condensed ">
                            <thead>
                                <tr>
                                    <th class="col-xs-5">Mois</th>
                                    <th class="col-xs-5">Jours Ouvrables</th>
                                    <th class="col-xs-5">Jours Ouvrables Collaborateurs</th>
                                <tr>
                            </thead>
                            <tbody>
                                <?php
                                    $Mois = array('1' => 'Janvier' ,'2' => 'Février','3' => 'Mars','4' => 'Avril','5' => 'Mai','6' => 'Juin',
                                    '7' => 'Juillet','8' => 'Août','9' => 'Septembre','10' => 'Octobre','11' => 'Novembre','12' => 'Décembre' );
                                    while ($data1=$workingDays->fetch() and $data2=$workingDaysCollab->fetch()) {
                                        ?>
                                            <tr>
                                                <td><?php echo $Mois[$data1['Mois']]; ?></td>
                                                <td><input type="text" class="form-control" value=<?php echo "'".$data1['NbJours']."'"?> readonly ></td>
                                                <td><input type="text" class="form-control" value=<?php if($data2['NbJours']==""){echo 0;} else{echo "'".$data1['NbJours']."'";}?> readonly ></td>
                                            </tr>
                                    <?php
                                    }
                                ?>
                                
                            </tbody>
                        </table>
                    </section>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="collabCancel" value="Retour"> 
                    </div>
                </div>

            </form>
    </div>

    <script src="public/js/functions/allowJOModif.js"></script>
    <script src="public/js/functions/JOUpdateValidation.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>