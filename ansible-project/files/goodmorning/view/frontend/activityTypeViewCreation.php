<?php $title = 'types Activités'; ?>
<?php ob_start(); ?>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" onclick="window.location.href='index.php';">Menu Principal</button>
            </div>
        </div>
        <header class="page-header">
            <h1> Gestion des Types d'activités CIS </h1>
        </header>
        <br>
            <form action="" method="post">
                <!-- <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="ATCreation" value="Création" disabled>
                    </div>    
                </div>

                <br> <br> -->

                <div class="row">

                    <section class="table responsive ">
                    <table class="table  table-striped table-condensed">
                        <thead>
                            <tr>
                                <th class="col-xs-1">Type d'Activité</th>
                                <th class="col-xs-1">Impact TACE</th>
                                <th class="col-xs-1">Facturable</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" name="AT">
                                </td>
                                <td>
                                    <select class="form-control" name="impactTACE">
                                        <option value=""></option>
                                        <option value="positif">positif</option>
                                        <option value="aucun">aucun</option>
                                        <option value="négatif">négatif</option>
                                    </select>
                                </td>
                                <td>
                                <input type="checkbox"  name="facturable">
                                </td>
<!--                                 <td>
                                <input type="checkbox"  name="initialisation">
                                </td> -->
                            </tr>
                        </tbody>

                </div>

                <br><br><br><br>
                <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="ATRegistrationCreation" value="Enregistrer">
                    </div>

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="ATCancel" value="Retour">
                    </div> 
                </div>



            </form>

    </div>

<!--script auto fetching the client to find the corresponding Market Unit -->
<script src="public/js/functions/pufetch.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>