<?php $title = 'Rate Cards'; ?>
<?php ob_start(); ?>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" onclick="window.location.href='index.php';">Menu Principal</button>
            </div>
        </div>
        <header class="page-header">
            <h1> Gestion des Rate Cards des Consultants CIS </h1>
        </header>
        <br>
            <form action="" method="post">
                <!-- <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" value="Création" disabled>
                    </div>    
                </div> -->

                <br> <br>

                <div class="row">

                    <section class="table responsive ">
                    <table class="table  table-striped table-condensed">
                        <thead>
                            <tr>
                                <th class="col-xs-1">Région</th>
                                <th class="col-xs-3">Role</th>
                                <th class="col-xs-1">Code</th>
                                <th class="col-xs-1">Grade</th>
                                <th class="col-xs-1">ADRC</th>
                                <th class="col-xs-1">Année</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select class="form-control" name="RegionRC">
                                        <option value="Région">Région</option>
                                        <option value="IDF">IDF</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="RoleRC"></td>
                                <td><input type="text" class="form-control" name="CodeRC"></td>
                                <td>
                                    <select class="form-control" name="GradeRC">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="F">F</option>
                                    </select>
                                </td>
                                <td><input type="number" min="0" step="any" class="form-control" name="rateCardRC" ></td>
                                <td><input type="number" min="1900" class="form-control" name="AnneeRC" value=<?php echo date("Y"); ?>></td>
                            </tr>
                        </tbody>
                    </table>
                    </section>

                </div>

                <br><br><br><br>
                <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="rateCardRegistrationCreation" value="Enregistrer">
                    </div>

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="rateCardCancel" value="Retour">
                    </div> 
                </div>

            </form>

    </div>

<!--script auto fetching the client to find the corresponding Market Unit -->
<script src="public/js/functions/pufetch.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>