<?php $title = 'Collaborateurs'; ?>
<link href="public/css/screens/collabChargeView.css" rel="stylesheet"/>
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
                <div class="col-sm-3">
                    <input type="checkbox" <?php if($collab['cvBook']==1){echo "checked";}?> disabled> 
                    <strong>CV-Book</strong>  
                </div>
                <div class="col-sm-9">
                    <label for="commentaire">commentaire</label>
                    <textarea class="form-control" rows="2" title="commentaire" id="commentaire" readonly><?php echo $collab['Commentaire'] ?></textarea>
                </div>
            </div>
            <br><br><br>
                
                <div class="row">
                    <div class="col-sm-3">
                        <label for="select">Année</label>
                        <select id="select" class="form-control" name="yearChargesCollab">
                            <option value=<?php  echo date("Y")-1;?> <?php if($year==date("Y")-1){echo "selected";}?> ><?php  echo date("Y")-1;?></option>
                            <option value=<?php  echo date("Y");?> <?php if($year==date("Y")){echo "selected";}?> ><?php  echo date("Y");?></option>
                            <option value=<?php  echo date("Y")+1;?> <?php if($year==date("Y")+1){echo "selected";}?> ><?php  echo date("Y")+1;?></option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="selectInitMonth">Mois Initial</label>
                        <select id="selectInitMonth" class="form-control" name="InitMonthChargesCollab">
                            <?php
                                foreach ($listMois as $key => $value) {
                                    ?>
                                    <option value=<?php echo $key;?> <?php if($key==$initMonth){echo "selected";}?> ><?php  echo $value;?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="selectLastMonth">Mois Final</label>
                        <select id="selectLastMonth" class="form-control" name="LastMonthChargesCollab">
                            <?php
                                foreach ($listMois as $key => $value) {
                                    ?>
                                    <option value=<?php echo $key;?> <?php if($key==$lastMonth){echo "selected";}?> ><?php  echo $value;?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <br>
                    <div class="col-xs-1">
                        <input type="submit" id="filter" class="btn btn-primary btn-block" name="yearMonthChargesCollabFilter" value="Filtrer">
                    </div>
                    <div class="col-xs-1">
                        <input type="hidden" name="collab" value=<?php echo $collab['ID']; ?> >
                    </div> 
                </div>


                <section class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">Mois</th>
                                <th scope="col">Commentaires</th>
                                <?php
                                    for ($i=$initMonth; $i<=$lastMonth ; $i++) { 
                                        ?>
                                        <th colspan="2" scope="col"><?php echo $listMois[$i];?></th>
                                    <?php
                                    }
                                ?>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <tr>
                                <th scope="row">Forecast(F) - Réalisé(R)</th>
                                <th rowspan="3"></th>
                                <?php
                                    for ($i=$initMonth; $i<=$lastMonth ; $i++) { 
                                        ?>
                                        <td>F</td>
                                        <td>R</td>
                                    <?php
                                    }
                                ?>
                            </tr>
                        
                                <tr>
                                    <th scope="row">Jours Ouvrables Collaborateur</td>
                                    <?php
                                    if (!empty($wdCollab)) {
                                        for ($i=$initMonth; $i<=$lastMonth ; $i++) { 
                                            ?>
                                            <td><?php echo $wdCollab[$i];?></td>
                                            <td><?php echo $wdCollab[$i];?></td>
                                        <?php
                                        } 
                                    }
                                    ?>
                                </tr>
                                <tr>
                                <th scope="row"> Ecarts</th>
                                <?php
                                    if (!empty($wdCollab) and !empty($totalPlannedCharges) and !empty($totalRealCharges)) {
                                        for ($i=$initMonth; $i <=$lastMonth ; $i++) { 
                                            $ecartPlan=$wdCollab[$i]-$totalPlannedCharges[$i];
                                            $ecartReal=$wdCollab[$i]-$totalRealCharges[$i];
                                            ?>
                                            <td><?php echo $ecartPlan;?></td>
                                            <td><?php echo $ecartReal;?></td>
                                        <?php
                                        }
                                    } 
                                ?>
                                </tr>
                                <tr>
                                    <th scope="row" class="withInput">Activités Client</th> 
                                </tr>   
                                <?php
                                if (!empty($yearCollabNoneInternTasks)) {
                                    foreach ($yearCollabNoneInternTasks as $key => $value) {
                                        $values=explode(":",$value);
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $values[0]; ?></td>
                                            <td><input type="text" class="comment" pattern='[^:"]+' oninvalid="this.setCustomValidity('Les doubles quotes et deux-points sont interdits')"
                                            name=<?php echo "comment-".$values[1]."-".$collab['ID'];?> value=<?php echo "'".$values[2]."'";?>></td>
                                            <?php
                                                for ($j=$initMonth; $j <=$lastMonth ; $j++) { 
                                                    if (${"noneInternTaskArrayCharges".$key}[$j]=="disabled") {
                                                        ?>
                                                        <td></td><td></td>   
                                                    <?php
                                                    }
                                                    else {
                                                        $data=explode("-",${"noneInternTaskArrayCharges".$key}[$j]);
                                                        ?>
                                                        <td><input type="number" step="any" min="0" name=<?php echo "Plan-ID-".$data[0]; ?> value=<?php echo $data[1];?>
                                                        <?php if($year<date("Y") or ($year==date("Y") and $j<=date("n"))){echo "disabled class='inputDisabled' ";} ?> ></td>
                                                        <td><input type="number" step="any" min="0" name=<?php echo "Real-ID-".$data[0]; ?> value=<?php echo $data[2];?> 
                                                        <?php if($year>date("Y") or ($year==date("Y") and $j> date("n"))){echo "disabled class='inputDisabled' ";} ?>></td>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                        </tr>
                                    <?php
                                    }
                                }    
                                ?>
                                <tr>
                                    <th scope="row">
                                        <select id="listProjNoneInternNullCharges" name="listProjNoneInternNullCharges"
                                        onchange="getProjectTaskList(this.value,'listTaskProjNoneInternNullCharges','<?php echo $collab['ID']; ?>',
                                        'select','selectInitMonth','selectLastMonth');">
                                            <option value=""></option>
                                            <?php
                                                if ($projListNoneInternNullCharges) {
                                                    while ($data=$projListNoneInternNullCharges->fetch()) {
                                                        ?>
                                                        <option value=<?php echo $data['idProj'];?>><?php echo $data['Titre']; ?></option>
                                                        <?php
                                                    }
                                                }   
                                            ?>
                                        </select>
                                    
                                        <select id="listTaskProjNoneInternNullCharges" name="listTaskProjNoneInternNullCharges"
                                        onchange="getNoneInternTaskChargesList(this.value,'<?php echo $collab['ID']; ?>','select','selectInitMonth','selectLastMonth');
                                        getTaskInputComment(this.value,'<?php echo $collab['ID'];?>','NITaskNullChargesComment')">
                                            <option value=""></option>
                                        </select>
                                    </th>
                                    <td><input type="text" class="comment" pattern='[^:"]+' oninvalid="this.setCustomValidity('Les doubles quotes et deux-points sont interdits')" id="NITaskNullChargesComment"></td>
                                    <?php
                                    $j=0;
                                    $k=1;
                                    for ($i=$initMonth; $i<=$lastMonth ; $i++) { 
                                        ?>
                                        <td id=<?php echo "taskNoneIntAffMonth-".$j;?>></td>
                                        <td id=<?php echo "taskNoneIntAffMonth-".$k;?>></td>
                                    <?php
                                     $j=$j+2;
                                     $k=$k+2;
                                    }
                                    ?>   
                                </tr> 
                                <tr>
                                    <th scope="row" class="withInput">Activités Internes</th> 
                                </tr> 
                                <?php  
                                if (!empty($yearCollabInternTasks)) {
                                    foreach ($yearCollabInternTasks as $key => $value) {
                                        $values=explode(":",$value);
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $values[0]; ?></td>
                                            <td><input type="text" class="comment" pattern='[^:"]+' oninvalid="this.setCustomValidity('Les doubles quotes et deux-points sont interdits')"
                                             name=<?php echo "comment-".$values[1]."-".$collab['ID']; ?> value=<?php echo "'".$values[2]."'"; ?>></td>
                                            <?php
                                                for ($j=$initMonth; $j <=$lastMonth ; $j++) {
                                                    if (${"internTaskArrayCharges".$key}[$j]=="disabled") {
                                                        ?>
                                                        <td></td><td></td>   
                                                    <?php
                                                    }
                                                    else {
                                                        $data=explode("-",${"internTaskArrayCharges".$key}[$j]);
                                                        ?>
                                                        <td><input type="number" step="any" min="0" name=<?php echo "Plan-ID-".$data[0]; ?> value=<?php echo $data[1];?>
                                                        <?php if($year<date("Y") or ($year==date("Y") and $j<=date("n"))){echo "disabled class='inputDisabled' ";} ?> ></td>
                                                        <td><input type="number" step="any" min="0" name=<?php echo "Real-ID-".$data[0]; ?> value=<?php echo $data[2];?> 
                                                        <?php if($year>date("Y") or ($year==date("Y") and $j> date("n"))){echo "disabled class='inputDisabled' ";} ?>></td>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                        </tr>
                                    <?php
                                    }
                                }  
                                ?> 
                                <tr>
                                    <th scope="row">
                                        <select id="listProjInternNullCharges" name="listProjInternNullCharges"
                                        onchange="getProjectTaskList(this.value,'listTaskProjInternNullCharges','<?php echo $collab['ID']; ?>',
                                        'select','selectInitMonth','selectLastMonth');">
                                            <option value=""></option>
                                            <?php
                                            if ($projListInternNullCharges) {
                                                while ($data=$projListInternNullCharges->fetch()) {
                                                    ?>
                                                    <option value=<?php echo $data['idProj'];?>><?php echo $data['Titre']; ?></option>
                                                    <?php
                                                }
                                            }   
                                            ?>
                                        </select>
                                        <select id="listTaskProjInternNullCharges" name="listTaskProjInternNullCharges"
                                        onchange="getInternTaskChargesList(this.value,'<?php echo $collab['ID']; ?>','select','selectInitMonth','selectLastMonth');
                                        getTaskInputComment(this.value,'<?php echo $collab['ID'];?>','ITaskNullChargesComment')">
                                            <option value=""></option>
                                        </select>
                                    </th>
                                    <td><input type="text" class="comment" pattern='[^:"]+' oninvalid="this.setCustomValidity('Les doubles quotes et deux-points sont interdits')" id="ITaskNullChargesComment"></td>
                                    <?php
                                    $j=0;
                                    $k=1;
                                    for ($i=$initMonth; $i<=$lastMonth ; $i++) { 
                                        ?>
                                        <td id=<?php echo "taskIntAffMonth-".$j;?>></td>
                                        <td id=<?php echo "taskIntAffMonth-".$k;?>></td>
                                    <?php
                                     $j=$j+2;
                                     $k=$k+2;
                                    }
                                    ?>  
                                </tr>

                                <!-- <tr>
                                    <th scope="row" class="noInput">Activités Client (Sans Imputation)</th> 
                                </tr>
                                <?php
                                    /* if (!empty($noneInternTaskToImputArrayYM)) {
                                        foreach ($noneInternTaskToImputArrayYM as $key => $value) {
                                            $data=explode(":",$value); */
                                            ?>
                                            <tr>
                                                <th scope="row"><?php //echo $data[1]."-".$data[2];?></th>
                                                <?php
                                                /* for ($j=$initMonth; $j <=$lastMonth ; $j++) { 
                                                    if (${"noneInternTaskMonthsToImputArray".$key}[$j]=="disabled") { */
                                                        ?>
                                                        <td></td><td></td>   
                                                    <?php
                                                    //}
                                                    //else {
                                                        ?>
                                                        <td><input type="text" <?php //if($year<date("Y") or ($year==date("Y") and $j<=date("n"))){echo "disabled class='inputDisabled' ";} ?>
                                                        name=<?php //echo "newImputPlan-".$data['0']."-".$collab['ID']."-".$year."-".$j; ?>></td>
                                                        <td><input type="text" <?php //if($year>date("Y") or ($year==date("Y") and $j> date("n"))){echo "disabled class='inputDisabled' ";} ?>
                                                        name=<?php //echo "newImputReal-".$data['0']."-".$collab['ID']."-".$year."-".$j; ?>></td>
                                                    <?php
                                                   // }
                                                //}
                                                ?>
                                            </tr>
                                            <?php
                                        //}
                                    //}
                                ?>
 
                                <tr>
                                    <th scope="row" class="noInput">Activités Internes (Sans Imputation)</th> 
                                </tr>
                                <?php
                                /* if (!empty($internTaskToImputArrayYM)) {
                                    foreach ($internTaskToImputArrayYM as $key => $value) {
                                        $data=explode("-",$value); */
                                        ?>
                                        <tr>
                                            <th scope="row"><?php //echo $data[1]."-".$data[2];?></th>
                                            <?php
                                            /* for ($j=$initMonth; $j <=$lastMonth ; $j++) { 
                                                if (${"internTaskMonthsToImputArray".$key}[$j]=="disabled") { */
                                                    ?>
                                                    <td></td><td></td>   
                                                <?php
                                                //}
                                                //else {
                                                    ?>
                                                    <td><input type="text" <?php //if($year<date("Y") or ($year==date("Y") and $j<=date("n"))){echo "disabled class='inputDisabled' ";} ?>
                                                    name=<?php //echo "newImputPlan-".$data['0']."-".$collab['ID']."-".$year."-".$j; ?>></td>
                                                    <td><input type="text" <?php //if($year>date("Y") or ($year==date("Y") and $j> date("n"))){echo "disabled class='inputDisabled' ";} ?>
                                                    name=<?php //echo "newImputReal-".$data['0']."-".$collab['ID']."-".$year."-".$j; ?>></td>
                                                <?php
                                                //}
                                           // }
                                            ?>
                                        </tr>
                                        <?php
                                   // }
                                //}
                             ?>    -->
                        </tbody>
                    </table>
                </section>                   
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="collabChargePlanCancel" value="Retour"> 
                    </div>

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="CollabImputationUpdateValidation" value="Enregistrer"> 
                    </div>
                </div>

            </form>
    </div>

<script src="public/js/functions/getNoneInternTaskChargesList.js"></script>
<script src="public/js/functions/getInternTaskChargesList.js"></script>
<script src="public/js/functions/getProjectTaskList.js"></script>
<script src="public/js/functions/getTaskInputComment.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>