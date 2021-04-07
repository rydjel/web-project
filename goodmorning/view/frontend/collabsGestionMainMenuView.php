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
        <div id="message"><?php echo $message;?></div>

        <form action="" method="post">
            <div class="col-sm-7 col-xs-offset-2">
                <input type="submit" class="btn btn-primary btn-block" name="collabCreation" value=" Créer Nouveau Collaborateur">
                <br>
                <select id="puChoice" class="form-control" name="pu" onchange="getCollabList(this.value,'collabChoice');">
                    <option value="Sélectionner une PU ..." selected readonly>Sélectionner une PU ...</option> 
                    <?php
                    if ($puList) {
                        while ($data=$puList->fetch()) { ?>
                            <option value=<?php echo $data['ID']; ?> > <?php echo $data['Nom']; ?> </option>
                            <?php
                        }
                    }    
                    ?>
                </select>
                <br>
                <select id="collabChoice" class="form-control" name="collab">
                    <option value=""></option>
                    <!-- <option value="Sélectionner un Collaborateur ... " selected readonly>Sélectionner un Collaborateur ...</option>  -->
                    <?php
                        if ($collabs) {
                            while ($data=$collabs->fetch()) { ?>
                                <option value=<?php echo $data['ID']; ?> > <?php echo $data['Nom']." ".$data['Prénom']; ?> </option> 
                                <?php
                            }
                        }   
                    ?>
                </select>
                <br>
                <input id="collabConsultation" type="submit" class="btn btn-primary btn-block" name="collabConsultation" value="Consulter">
                <br>
                <input id="collabModification" type="submit" class="btn btn-primary btn-block" name="collabModification" value="Modifier">
            </div>
        </form>

    </div>
    
    <script src="public/js/functions/getCollabList.js"></script>
    <script src="public/js/functions/allowClientModif.js"></script>
    <script src="public/js/functions/clientUpdateValidation.js"></script>
<!--script auto fetching the client to find the corresponding Market Unit -->
<script src="public/js/functions/clientsFetch.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>