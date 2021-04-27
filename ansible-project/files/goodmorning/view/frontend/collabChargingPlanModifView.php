<?php $title = 'Collaborateurs'; ?>
<link href="public/css/screens/collabChargeView.css" rel="stylesheet"/>
<?php ob_start(); ?>
    <div class="container-fluid">
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
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                    <input type="text" class="form-control" title="Nom" value=<?php echo "'".$collab['Nom']."'"?>  readonly >
                    </div>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" title="Prénom" value=<?php echo "'".$collab['Prénom']."'"?> readonly >
                    </div>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" title="GGID" value=<?php echo "'".$collab['GGID']."'"?> readonly >
                    </div>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" title="PU" value=<?php echo "'".$puname['Nom']."'"?> readonly >
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                    <input type="text" class="form-control" title="Site" value=<?php echo "'".$collab['Site']."'"?> readonly >
                    </div>
                    <div class="col-sm-3">
                    <input type="date" class="form-control" title="Date Entrée" value=<?php echo "'".$collab['Date_Entree']."'"?> readonly >
                    </div>
                    <div class="col-sm-3">
                    <input type="date" class="form-control" title="Date Sortie" value=<?php echo "'".$collab['Date_Sortie']."'"?> readonly >
                    </div>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" title="Statut" 
                    value=<?php if(date("Y-m-d")> $collab['Date_Entree'] and date("Y-m-d") <$collab['Date_Sortie']){echo "Actif";}
                    if(date("Y-m-d")> $collab['Date_Sortie']){echo "Inactif";}?> readonly >
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                    <input type="text" class="form-control" title="Role" value=<?php echo "'".$role['Role']."'"?> readonly >
                    </div>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" title="Grade" value=<?php echo "'".$grade['Grade']."'"?> readonly >
                    </div>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" title="Rate Card" value=<?php echo "'".$rateCard['RateCard']."'"?> readonly >
                    </div>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" title="Pourcentage Activité" value=<?php echo "'".$collab['Pourcentage_Activity']."'"?> readonly >
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <textarea class="form-control" rows="3" title="commentaire" readonly><?php echo $collab['Commentaire'] ?></textarea>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-3">
                        <select id="select" class="form-control" name="yearChargesCollabModif">
                            <option value=<?php  echo date("Y")-1;?> <?php if($year==date("Y")-1){echo "selected";}?> ><?php  echo date("Y")-1;?></option>
                            <option value=<?php  echo date("Y");?> <?php if($year==date("Y")){echo "selected";}?> ><?php  echo date("Y");?></option>
                            <option value=<?php  echo date("Y")+1;?> <?php if($year==date("Y")+1){echo "selected";}?> ><?php  echo date("Y")+1;?></option>
                        </select>
                    </div>
                    <div class="col-xs-1">
                        <input type="submit" class="btn btn-primary btn-block"name="yearChargesCollabModifFilter" value="Filter">
                        <input type="hidden" name="collab" value=<?php echo $collab['ID']; ?> >
                    </div> 
                </div>


                <div class="row">
                     <section class="col-xs-12 table-responsive"> 
                        <table>
                            <thead>
                                <tr>
                                    <th rowspan="2" scope="col">Activité</th>
                                    <th colspan="2" scope="col">Janvier</th>
                                    <th colspan="2" scope="col">Fevrier</th>
                                    <th colspan="2" scope="col">Mars</th>
                                    <th colspan="2" scope="col">Avril</th>
                                    <th colspan="2" scope="col">Mai</th>
                                    <th colspan="2" scope="col">Juin</th>
                                    <th colspan="2" scope="col">Juillet</th>
                                    <th colspan="2" scope="col">Aout</th>
                                    <th colspan="2" scope="col">Septembre</th>
                                    <th colspan="2" scope="col">Octobre</th>
                                    <th colspan="2" scope="col">Novembre</th>
                                    <th colspan="2" scope="col">Decembre</th>
                                </tr>
                                <tr>
                                    <th scope="col">F</th>
                                    <th scope="col">R</th>
                                    <th scope="col">F</th>
                                    <th scope="col">R</th>
                                    <th scope="col">F</th>
                                    <th scope="col">R</th>
                                    <th scope="col">F</th>
                                    <th scope="col">R</th>
                                    <th scope="col">F</th>
                                    <th scope="col">R</th>
                                    <th scope="col">F</th>
                                    <th scope="col">R</th>
                                    <th scope="col">F</th>
                                    <th scope="col">R</th>
                                    <th scope="col">F</th>
                                    <th scope="col">R</th>
                                    <th scope="col">F</th>
                                    <th scope="col">R</th>
                                    <th scope="col">F</th>
                                    <th scope="col">R</th>
                                    <th scope="col">F</th>
                                    <th scope="col">R</th>
                                    <th scope="col">F</th>
                                    <th scope="col">R</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if (!empty($wdCollab)) {
                                    ?>
                                    <tr>
                                        <th scope="row">Jours Ouvrables Collaborateur</th>
                                        <?php
                                        $i=1;
                                        while ($i<=12) {
                                            ?>
                                            <td><input type="text" class="form-control"  value=<?php echo $wdCollab[$i]?> readonly></td>
                                            <td><input type="text" class="form-control" value=<?php echo $wdCollab[$i]?> readonly></td>
                                        <?php
                                        $i++;
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                    <th scope="row"> Ecarts</th>
                                    <?php
                                        $i=1;
                                        while ($i<=12) {
                                            $ecartPlan=$wdCollab[$i]-$totalPlannedCharges[$i];
                                            $ecartReal=$wdCollab[$i]-$totalRealCharges[$i];
                                            $i++;
                                            ?>
                                            <td class="text-nowrap"><input type="text" class="form-control" value=<?php echo "'".$ecartPlan."'"?> readonly></td>
                                            <td class="text-nowrap"><input type="text" class="form-control" value=<?php echo "'".$ecartReal."'"?> readonly></td>
                                        <?php
                                        } 
                                    ?>
                                    </tr>   
                                    <?php    
                                    }
                                    foreach ($yearCollabTasks as $key => $value) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $value ?></th>
                                        <?php
                                            $i=1;
                                            while ($data=${"taskCharges".$key}->fetch()) { 
                                                if ($data['mois']==$i) {
                                                ?>
                                                <td><input type="text" class="form-control" value=<?php echo $data['NbJoursPlan']?> name=<?php echo "chargePlan".$data['ID']; ?>></td>
                                                <td><input type="text" class="form-control" value=<?php echo $data['NbJoursReal']?> name=<?php echo "chargeReal".$data['ID']; ?>></td>
                                                <?php
                                                }
                                                else {
                                                    for ($j=$i; $j<$data['mois'] ; $j++) {
                                                        ?>
                                                        <td><input type="text" class="form-control" value=<?php echo 0 ?> readonly title="Aucune imputation initiale"></td>
                                                        <td><input type="text" class="form-control" value=<?php echo 0 ?> readonly title="Aucune imputation initiale"></td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <td><input type="text" class="form-control" value=<?php echo $data['NbJoursPlan']?> name=<?php echo "chargePlan".$data['ID']; ?>></td>
                                                    <td><input type="text" class="form-control" value=<?php echo $data['NbJoursReal']?> name=<?php echo "chargeReal".$data['ID']; ?>></td>
                                                    <?php
                                                    $i=$data['mois']; 
                                                }
                                                $i++;
                                            }
                                            if ($i<12) {
                                                for ($j=i; $j <=12 ; $j++) { 
                                                    ?>
                                                        <td><input type="text" class="form-control" value=<?php echo 0 ?> readonly title="Aucune imputation initiale"></td>
                                                        <td><input type="text" class="form-control" value=<?php echo 0 ?> readonly title="Aucune imputation initiale"></td>
                                                    <?php
                                                }
                                            }
                                        ?>
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
                        <input type="submit" class="btn btn-primary btn-block" name="collabChargePlanModifRegistration" value="Enregistrer"> 
                    </div>
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="collabChargePlanCancel" value="Annuler"> 
                    </div>
                </div>

            </form>
    </div>

<!--     <script src="public/js/functions/allowJOModif.js"></script>
    <script src="public/js/functions/JOUpdateValidation.js"></script> -->

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>