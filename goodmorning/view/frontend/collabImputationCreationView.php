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
                        <textarea class="form-control" rows="1" title="commentaire" readonly><?php echo $collab['Commentaire'] ?></textarea>
                    </div>
                </div>
                
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
                        <input type="submit" id="filter" class="btn btn-primary btn-block" name="yearMonthToImputeCollabFilter" value="Filter">
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
                                    for ($i=$initMonth; $i<=$lastMonth ; $i++) { 
                                        ?>
                                        <td><input type="text" value=<?php echo $wdCollab[$i];?> readonly></td>
                                        <td><input type="text" value=<?php echo $wdCollab[$i];?> readonly></td>
                                    <?php
                                    }
                                    ?>
                                </tr>
                                <!-- <tr>
                                <th scope="row"> Ecarts</th>
                                <?php
                                    /* for ($i=$initMonth; $i <=$lastMonth ; $i++) { 
                                        $ecartPlan=$wdCollab[$i]-$totalPlannedCharges[$i];
                                        $ecartReal=$wdCollab[$i]-$totalRealCharges[$i]; */
                                        ?>
                                        <td><input type="text" value=<?php //echo $ecartPlan;?> readonly></td>
                                        <td><input type="text" value=<?php //echo $ecartReal;?> readonly></td>
                                    <?php
                                    //}
                                ?>
                                </tr> -->
                                <tr>
                                    <th scope="row">Activité Client</th> 
                                </tr>
                                <?php
                                    if (!empty($noneInternTaskToImputList)) {
                                        while ($data=$noneInternTaskToImputList->fetch()) {
                                            ?>
                                            <tr>
                                                <th scope="row"><?php echo $data['Titre']."-".$data['Nom_Tache'];?></th>
                                                <?php
                                                for ($i=$initMonth; $i<=$lastMonth ; $i++) { 
                                                    ?>
                                                    <td><input type="text"></td>
                                                    <td><input type="text"></td>
                                                <?php
                                                }
                                                ?>
                                            </tr>
                                        <?php
                                        }
                                    }

                                ?>
 
                                <tr>
                                    <th scope="row">Activité Interne</th> 
                                </tr>
                                <?php
                                if (!empty($internTaskToImputList)) {
                                    while ($data=$internTaskToImputList->fetch()) {
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $data['Titre']."-".$data['Nom_Tache'];?></th>
                                            <?php
                                            for ($i=$initMonth; $i<=$lastMonth ; $i++) { 
                                                ?>
                                                <td><input type="text"></td>
                                                <td><input type="text"></td>
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                    <?php
                                    }
                                }
                                    
                                ?> 
                                
                        </tbody>
                    </table>
                </section>                   
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="collabChargePlanCancel" value="Annuler"> 
                    </div>
                </div>

            </form>
    </div>

<script src="public/js/functions/getProjectTaskList.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>