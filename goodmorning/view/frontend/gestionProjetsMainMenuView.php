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

        <form action="" method="post">
            <div class="col-sm-7 col-xs-offset-2">
                <input type="submit" class="btn btn-primary btn-block" name="projectCreation" value="Créer un nouveau projet">
                <br>
                <select id="clientChoice" class="form-control" name="client" onchange="getProjectList(this.value,'projectList');allowTaskAndProjectModif()">
                    <option value="Sélectionner un client ..." selected readonly>Sélectionner un client ...</option> 
                    <?php
                    if ($clients) {
                        while ($data=$clients->fetch()) { ?>
                            <option value=<?php echo $data['ID']; ?> > <?php echo $data['NomClient']; ?> </option>
                            <?php
                        }
                    }
                        
                    ?>
                </select>
                <br>
                <select id="projectList" class="form-control" name="projet" title="projet" onchange="allowTaskAndProjectModif();">
                    <option value=""></option>
                </select>
                <br>
                <input type="text" class="form-control typeahead" name="projectCode" id="projectCode" placeholder="Saisir un code projet"
                onchange="allowTaskAndProjectModifByCodeProj(this.id);">
                <br>
                <input type="submit" class="btn btn-primary btn-block" name="projectModification" value="Modifier le Projet" id="projetModif" disabled>
                <br>
                <input type="submit" class="btn btn-primary btn-block" name="affectationModif" value="Modification(s) / création affectation(s)" id="affectationModif" disabled>
            </div>
        </form>

    </div>

    <script src="public/js/functions/getProjectList.js"></script>
    <script src="public/js/functions/allowTaskAndProjectModif.js"></script>
    <script src="public/js/functions/projectsFetch.js"></script>
    <script src="public/js/functions/allowTaskAndProjectModifByCodeProj.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>