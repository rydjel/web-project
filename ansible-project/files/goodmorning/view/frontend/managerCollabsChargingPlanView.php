<?php $title = 'Collaborateurs-'.$selectedManager; ?>
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
        <form action="" method="post" id="collabChargesForm" target="_blank">
            <br>
            <!-- List of Collabs who belong to the manager's team -->
            
            <div class="row">

                <div class="col-sm-7 col-xs-offset-2">
                    <select id="collab" name="collab" class="form-control" onchange="getCollabCharges(this.value);">
                        <option value="Sélectionner un Collaborateur ..." selected>Sélectionner un Collaborateur ...</option> 
                        <?php
                        if ($collabs) {
                            while ($data=$collabs->fetch()) { ?>
                                <option value=<?php echo $data['ID']; ?> > <?php echo $data['Nom'].' '.$data['Prénom']; ?> </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-xs-1">
                    <label>
                    <input type="checkbox" title="Inclure les collaborateurs sortis des effectifs durant l'année en cours j'usqu'au mois M-1"
                    placeholder="Inclure les collaborateurs sortis des effectifs durant l'année en cours j'usqu'au mois M-1" class="form-control"
                    id="inoutCollab" value=<?php echo $idManager; ?> onchange="getManagerCollabList(this.value,this.id);"> Sorti(e)s</label>
                </div>
                
                <div class="col-sm-2">
                    <input type="submit" class="btn btn-primary btn-block" name="accessCollabProfil" id="accessCollabProfil" value="Voir Profil" disabled>
                </div> 

            </div>
           
            <br>
            <div class="row">
                <div id="collabCharges">

                </div>      
            </div>    
        </form>

        <br>
        <form action="" method="post">
            <div class="row">
                <div class="col-sm-2 col-xs-offset-3">
                    <input type="submit" class="btn btn-primary btn-block" name="collabChargePlanCancel" id="Retour" value="Retour">
                    <!-- <button type="submit"  id="Retour" class="btn btn-primary btn-block" name="collabChargePlanCancel">Retour</button>  -->
                </div>

                <div class="col-sm-2">
                    <!-- <button type="submit"  id="Enregistrer" class="btn btn-primary btn-block" onclick="updateCollabCharges();" disabled>Enregistrer</button> -->
                    <input type="submit" class="btn btn-primary btn-block" name="CollabImputationUpdateValidation" id="Enregistrer" value="Enregistrer" onclick="updateCollabCharges();" disabled> 
                </div>
            </div>
        </form>
    </div>

<script src="public/js/functions/getNoneInternTaskChargesList.js"></script>
<script src="public/js/functions/getInternTaskChargesList.js"></script>
<script src="public/js/functions/getNIProjectTaskList.js"></script>
<script src="public/js/functions/getProjectTaskList.js"></script>
<script src="public/js/functions/getTaskInputComment.js"></script>
<script src="public/js/functions/getCollabCharges.js"></script>
<script src="public/js/functions/collabChargesFilter.js"></script>
<script src="public/js/functions/updateCollabCharges.js"></script>
<script src="public/js/functions/closeCollabChargeErrorCommentModal.js"></script>
<script src="public/js/functions/getManagerCollabList.js"></script>


<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>


<!-- Fenêtre Modal pour message d'erreur à la saisie d'un caractère interdit dans le champ commentaire -->
<div class="modal" id="commentErrorInputModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title"><strong>Suppression d'un Manager</strong></h3>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger alert-dismissible" role="alert">
            <strong>Erreur!</strong> Un/plusieur Champ(s) contien(nen)t les caractères double-quote et/ou deux-points
        </div>
      </div>
      <input type="hidden" id="managerToDelete">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeCollabChargeErrorCommentModal('commentErrorInputModal');" >Fermer</button>
      </div>
    </div>
  </div>
</div>