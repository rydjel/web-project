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
                        <input type="text" class="form-control" placeholder="Nom" id="Nom">
                    </div>
                    <div class="col-sm-3">
                        <label for="Prénom">Prénom</label>
                        <input type="text" class="form-control" placeholder="Prénom" id="Prénom">
                    </div>
                    <div class="col-sm-3">
                        <label for="GGID">GGID</label>
                        <input type="text" class="form-control" placeholder="GGID" id="GGID" name="GGID">
                    </div>
                    <div class="col-sm-3">
                        <label for="PU">PU</label>
                        <select id="PU" class="form-control" title="PU">
                           <?php 
                           if ($puList) {
                             while ($data=$puList->fetch()) { ?>
                                <option value=<?php  echo $data['Nom'];?> ><?php  echo $data['Nom'];?></option>
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
                           <option value="">Site...</option>
                           <?php
                           if ($sites) {
                                while ($data=$sites->fetch()) { ?>
                                    <option value=<?php  echo $data['ID'];?> ><?php  echo $data['Nom'];?></option>
                                <?php
                                } 
                           } 
                           ?> 
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="dateEntree">Date Entrée</label>
                        <input type="date" class="form-control" title="Date Entrée" id="dateEntree">
                    </div>
                    <div class="col-sm-3">
                        <label for="dateSortie">Date Sortie</label>
                        <input type="date" class="form-control" title="Date Sortie" id="dateSortie" >
                    </div>
                    <!-- <div class="col-sm-3">
                        <label for="Statut">Statut</label>
                        <input type="text" class="form-control" title="Statut" value="Actif" id="statut"  readonly >
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <label for="role">role</label>
                        <select id="role" class="form-control" onchange="getGradeAndRateCard(this.value,'Site','dateEntree','Grade','RateCard');">
                                <option value=""></option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="Grade">Grade</label>
                        <input type="text" class="form-control" placeholder="Grade" id="Grade" disabled>
                    </div>
                    <div class="col-sm-3">
                        <label for="RateCard">ADRC</label>
                        <input type="text" class="form-control" placeholder="ADRC" id="RateCard" disabled>
                    </div>
                    <div class="col-sm-3">
                        <label for="tjmCible">TJM Cible</label>
                        <input type="number" step="any" class="form-control" placeholder="TJM Cible" id="tjmCible">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <label for="pourcentageActivite">Pourcentage Activité</label>    
                        <input type="text" class="form-control" placeholder="Pourcentage Activité" id="pourcentageActivite" >
                    </div>
               
                    <div class="col-sm-3">
                        <label for="support">Support</label>
                        <select id="support" class="form-control">
                            <option></option>
                            <?php 
                            if ($supportList) {
                                while ($data=$supportList->fetch()) {
                                    ?>
                                    <option value=<?php echo $data['ID'];?>><?php echo $data['nom'].' '.$data['prenom'];?></option>
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
                                    <option value=<?php echo $data['idCollab'];?>><?php echo $data['Nom'].' '.$data['Prénom'];?></option>
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
                                    <option value=<?php echo $data['idCollab'];?>><?php echo $data['Nom'].' '.$data['Prénom'];?></option>
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
                        <input type="checkbox" name="cvBook" id="cvBook"> <strong>CV-Book</strong>
                        </label>
                    </div>
                    <!-- <div class="col-sm-3 form-check"> 
                        <label class="form-check-label" for="cvBook">CV-Book</label>
                        <input type="checkbox" class="form-check-input form-control" name="cvBook" id="cvBook" disabled>   
                    </div> -->
                    <div class="col-sm-9">
                        <label for="commentaire">commentaire</label> 
                        <textarea class="form-control" rows="2" title="commentaire" id="commentaire"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-primary btn-block" id="registerCollab" 
                        onclick="collabCreation('Nom','Prénom','GGID','PU','Site','dateEntree','dateSortie','role','Grade','RateCard','pourcentageActivite','support','manager','commentaire',this.id,'CM','cvBook','tjmCible');">Enregistrer</button>
                    </div>
                    <div class="col-sm-3">
                        <input type="submit" id="collabCancel" class="btn btn-primary btn-block" name="collabCancel" value="Annuler / Retour"> 
                    </div>
                    <p id="messageRecordCollab">Merci d'enregistrer le collaborateur avant d'ajouter un profil, un(e)/des compétence(s), expérience(s) et/ou certification(s).</p>
                </div>
                
                <!-- <div class="row">
                    <div class="col-sm-3">
                        <select id="select" class="form-control" name="yearJOCollabCreation">
                            <option value=<?php  //echo date("Y")-1;?> <?php //if($year==date("Y")-1){echo "selected";}?> ><?php  //echo date("Y")-1;?></option>
                            <option value=<?php  //echo date("Y");?> <?php //if($year==date("Y")){echo "selected";}?> ><?php // echo date("Y");?></option>
                            <option value=<?php // echo date("Y")+1;?> <?php //if($year==date("Y")+1){echo "selected";}?> ><?php // echo date("Y")+1;?></option>
                        </select>
                    </div>
                    <div class="col-xs-1">
                        <input type="submit" class="btn btn-primary btn-block"name="yearJOCollabCreationFilter" value="Filter">
                    </div> 
                </div> -->
                <br><br><br>

                
                <!-- <div class="row">
                    <div class="col-sm-7">
                        <label for="profil">Profil</label>
                        <textarea class="form-control" rows="2" title="Profil" id="profil"></textarea>
                    </div>
                </div> -->
                <div class="row">
                    <input type="hidden" name="collab" id="ID" >
                </div>
                <div id="bodyProfil">
                    <div class="row">
                        <div class="col-sm-3">
                            <button type="button"  id="newProfil" class="btn btn-primary btn-block" onclick="addProfil();" disabled>Rajout Profil</button>
                        </div>
                    </div>
                    <div id="newProfilAdd"></div>
                </div>
                <br><br>

                <div class="row">
                    <div class="col-sm-3">
                        <button type="button"  id="newComp" class="btn btn-primary btn-block" onclick="newCompetence();" disabled>Nouvelle Compétence</button>
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
                            </tbody>
                        </table>
                    </section>
                </div>

                <br><br>
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button"  id="newCertif" class="btn btn-primary btn-block" onclick="newCertification();" disabled>Nouvelle Certification</button>
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
                            </tbody>
                        </table>
                    </section>
                </div>

                <br><br>
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button"  id="newExp" class="btn btn-primary btn-block" onclick="newExperience();" disabled>Nouvelle Experience</button>
                    </div>
                </div>
                <div class="row">
                    <section class="table responsive">
                        <table class="table table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th class="col-xs-1">Date Debut</th>
                                <th class="col-xs-1">Date Fin</th>
                                <th class="col-xs-7">Détails</th>
                                <th class="col-xs-3"></th>
                            <tr>
                        </thead>
                        <tbody id="bodyExp">
                        </tbody>
                        </table>
                    </section>
                </div>
                
                <br><br><br>
                <!-- <div class="row">
                    <div class="col-sm-3">
                        <select id="select" class="form-control" name="yearJOCollabCreation">
                            <option value=<?php  //echo date("Y")-1;?> <?php //if($year==date("Y")-1){echo "selected";}?> ><?php // echo date("Y")-1;?></option>
                            <option value=<?php // echo date("Y");?> <?php //if($year==date("Y")){echo "selected";}?> ><?php // echo date("Y");?></option>
                            <option value=<?php // echo date("Y")+1;?> <?php //if($year==date("Y")+1){echo "selected";}?> ><?php // echo date("Y")+1;?></option>
                        </select>
                    </div>
                    <div class="col-xs-1">
                        <input type="submit" class="btn btn-primary btn-block"name="yearJOCollabCreationFilter" value="Filter">
                    </div> 
                </div>

                <div class="row ">
                    <section class="table responsive">
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
                                    //$Mois = array('1' => 'Janvier' ,'2' => 'Février','3' => 'Mars','4' => 'Avril','5' => 'Mai','6' => 'Juin',
                                    //'7' => 'Juillet','8' => 'Août','9' => 'Septembre','10' => 'Octobre','11' => 'Novembre','12' => 'Décembre' );
                                    //while ($data=$workingDays->fetch()) {
                                        ?>
                                            <tr>
                                                <td><?php // echo $Mois[$data['Mois']]; ?></td>
                                                <td><input type="text" class="form-control" value=<?php //echo "'".$data['NbJours']."'"?> readonly ></td>
                                                <td><input type="text" class="form-control" value=<?php //echo "'".$data['NbJours']."'"?> readonly ></td>
                                            </tr>
                                    <?php
                                    //}
                                ?>
                                
                            </tbody>
                        </table>
                    </section>
                </div>
                <br> -->
                <!-- <div class="row">
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-primary btn-block" 
                        onclick="collabCreation('Nom','Prénom','GGID','PU','Site','dateEntree','dateSortie','statut','role','Grade','RateCard','pourcentageActivite','commentaire','profil');">Enregistrer</button>
                    </div> -->
                    <!-- <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="collabCancel" value="Annuler / Retour"> 
                    </div> -->
                <!-- </div> -->

            </form>
    </div>
    
    <script src="public/js/functions/getGradeAndRateCard.js"></script>
    <script src="public/js/functions/getSiteRoleList.js"></script>
    <script src="public/js/functions/collabCreation.js"></script>
    <script src="public/js/functions/addProfil.js"></script>
    <script src="public/js/functions/collabProfilAdd.js"></script>
    <script src="public/js/functions/newCompetence.js"></script>
    <script src="public/js/functions/collabCompValidation.js"></script>
    <script src="public/js/functions/newCertification.js"></script>
    <script src="public/js/functions/collabCertifValidation.js"></script>
    <script src="public/js/functions/newExperience.js"></script>
    <script src="public/js/functions/collabExpValidation.js"></script>
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