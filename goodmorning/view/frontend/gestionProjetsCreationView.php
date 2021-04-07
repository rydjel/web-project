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
            <div id="message"></div>
            <br>
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="codeProjet">Code Projet</label>
                        <input type="text" class="form-control" id="codeProjet" name="codeProjet">
                    </div>
                    <div class="col-sm-3">
                        <label for="titreProjet">Titre Projet</label>
                        <input type="text" class="form-control" id="titreProjet" name="titreProjet">
                    </div>
                    <div class="col-sm-3">
                        <label for="PU">Production Unit Mandataire</label>
                        <select id="PU" class="form-control" title="Production Unit Mandataire" name="PU">
                           <?php 
                           if ($puList) {
                                while ($data=$puList->fetch()) { ?>
                                    <option value=<?php  echo $data['ID'];?>><?php  echo $data['Nom'];?></option>
                                <?php
                                } 
                           } 
                           ?> 
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="client">Client</label>
                        <select id="client" class="form-control" title="Client" name="client">
                            <?php
                            if ($clientList) {
                                while ($data=$clientList->fetch()) { ?>
                                    <option value=<?php echo $data['ID']; ?> > <?php echo $data['NomClient']; ?> </option>
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
                        <!-- <select id="typeProjet" class="form-control" name="typeProjet" onchange="getGeneriqueCode(this.value,'codeGen');"> -->
                        <select id="typeProjet" class="form-control" name="typeProjet">
                            <!-- <option value="Type de Projet" disabled>Type de Projet </option> -->
                            <option value="Assistance Technique Simple">Assistance Technique Simple</option>
                            <option value="Engagement de Moyen">Engagement de Moyen</option>
                            <option value="Engagement de Résultat">Engagement de Résultat</option>
                            <option value="Activité Interne">Activité Interne</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="VolJourVendu">Volume Jour Vendu</label>
                        <input type="text" class="form-control" id="VolJourVendu" name="VolJourVendu">
                        <br>
                        <label for="BudgetVendu">Budget Vendu</label>
                        <input type="text" class="form-control" id="BudgetVendu" name="BudgetVendu">
                        <br>
                        <label for="RFA">Remise de Fin d'Année</label>
                        <input type="text" class="form-control" id="RFA" name="RFA">
                        <br>
                        <label for="anneeProjTypeGen">Année (Projet avec Code générique)</label>
                        <select name="anneeProjTypeGen" class="form-control" id="anneeProjTypeGen" disabled>
                            <option value=<?php echo date("Y")-1; ?> ><?php echo date("Y")-1; ?></option>
                            <option value=<?php echo date("Y"); ?> selected><?php echo date("Y"); ?></option>
                            <option value=<?php echo date("Y")+1; ?> ><?php echo date("Y")+1; ?></option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="Commercial">Commercial</label>
                        <input type="text" class="form-control" id="Commercial", name="Commercial">   
                    </div>
                    <div class="col-sm-3 form-check"> 
                        <label class="form-check-label" for="codeGen">Code Générique</label>
                        <input type="checkbox" class="form-check-input" name="codeGenerique" id="codeGen" onchange="enableDisableYear(this.id,'anneeProjTypeGen');" >   
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button"  id="newTask" class="btn btn-primary btn-block" onclick="taskCreation();" disabled>Nouvelle Tâche</button>
                    </div>
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block"  name="taskAffectation" id="taskAffectation" value="Affecter Une Tâche" disabled> 
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
                            </tbody>
                        </table>
                    </section>
                </div>
                <br>
                <div class="row" id="projAction">
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-primary btn-block" id="registerNewProj"
                        onclick="projectRecord('PU','codeProjet','titreProjet','Commercial','RFA','client','typeProjet','VolJourVendu','BudgetVendu','codeGen');">Enregistrer</button>
                    </div>
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block"  name="projCancel" value="Annuler / Retour"> 
                    </div>
                    <!-- <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block"  name="taskAffectation" value="Affecter Une Tâche" disabled> 
                    </div> -->
                </div>
            </form>

    </div>
    
    <script src="public/js/functions/taskCreation.js"></script>
    <script src="public/js/functions/projectRecord.js"></script>
    <script src="public/js/functions/allowTaskModif.js"></script>
    <script src="public/js/functions/taskUpdateValidation.js"></script>
    <script src="public/js/functions/taskCreateValidation.js"></script>
    <script src="public/js/functions/getTACEandFact.js"></script>
    <script src="public/js/functions/getGeneriqueCode.js"></script>
    <script src="public/js/functions/enableDisableYear.js"></script>
    <script src="public/js/functions/cancelTaskModif.js"></script>




    <script src="public/js/functions/allowJOCollabModif.js"></script>
    <script src="public/js/functions/JOCollabUpdateValidation.js"></script>
    <script src="public/js/functions/getGradeAndRateCard.js"></script>
    <script src="public/js/functions/getSiteRoleList.js"></script>
    <script src="public/js/functions/collabModification.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>