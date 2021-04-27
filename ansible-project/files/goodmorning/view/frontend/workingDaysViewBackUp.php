<?php $title = 'Jours Ouvrables'; ?>
<?php ob_start(); ?>
    <div class="container">
        <header class="page-header">
            <h1> Jours Ouvrables CIS </h1>
        </header>
        <br>
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="JOModification" value="Modification">
                    </div> 

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="JODuplication"  value="Duplication N-1" disabled>
                    </div>

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="clientRegistration" value="Enregistrer" disabled>
                    </div>

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="clientCancel" value="Annuler" disabled>
                    </div>   
                </div>

                <br> <br>

                <div class="row">
                    <div class="col-sm-3">
                        <select id="select" class="form-control" >
                            <option value=<?php  echo date("Y")-1;?> ><?php  echo date("Y")-1;?></option>
                            <option value=<?php  echo date("Y");?> selected ><?php  echo date("Y");?></option>
                            <option value=<?php  echo date("Y")+1;?> ><?php  echo date("Y")+1;?></option>
                        </select>
                    </div>
                    <!-- </div> -->
                    <div class="col-xs-1">
                        <input type="submit" class="btn btn-primary btn-block"name="anneeValidation" value="Filter">
                    </div>
                   
                </div>


                <div class="row ">
                    <section class="table responsive ">
                        <table class="table table-bordered table-striped table-condensed ">
                            <thead>
                                <tr>
                                    <th class="col-xs-5">Mois</th>
                                    <th class="col-xs-5">Jours Ouvrables</th>
                                <tr>
                            <thead>
                            <tbody>
                                <tr>
                                    <td>Janvier</td>
                                    <td><input type="text" class="form-control" value=<?php echo "'".$workingDays[0]['NbJours']."'"?> disabled ></td>
                                </tr>
                                <tr>
                                    <td>Février</td>
                                    <td><input type="text" class="form-control" value=<?php echo "'".$workingDays[1]['NbJours']."'";?> disabled ></td>
                                </tr>
                                <tr>
                                    <td>Mars</td>
                                    <td><input type="text" class="form-control" value=<?php echo "'".$workingDays[2]['NbJours']."'";?> disabled ></td>
                                </tr>
                                <tr>
                                    <td>Avril</td>
                                    <td><input type="text" class="form-control" value=<?php echo "'".$workingDays[3]['NbJours']."'";?> disabled></td>
                                </tr>
                                <tr>
                                    <td>Mai</td>
                                    <td><input type="text" class="form-control" value=<?php echo "'".$workingDays[4]['NbJours']."'";?> disabled></td>
                                </tr>
                                <tr>
                                    <td>Juin</td>
                                    <td><input type="text" class="form-control" value=<?php echo "'".$workingDays[5]['NbJours']."'";?> disabled></td>
                                </tr>
                                <tr>
                                    <td>Juillet</td>
                                    <td><input type="text" class="form-control" value=<?php echo "'".$workingDays[6]['NbJours']."'";?> disabled></td>
                                </tr>
                                <tr>
                                    <td>Août</td>
                                    <td><input type="text" class="form-control" value=<?php echo "'".$workingDays[7]['NbJours']."'";?> disabled></td>
                                </tr>
                                <tr>
                                    <td>Septembre</td>
                                    <td><input type="text" class="form-control" value=<?php echo "'".$workingDays[8]['NbJours']."'";?> disabled></td>
                                </tr>
                                <tr>
                                    <td>Octobre</td>
                                    <td><input type="text" class="form-control" value=<?php echo "'".$workingDays[9]['NbJours']."'";?> disabled></td>
                                </tr>
                                <tr>
                                    <td>Novembre</td>
                                    <td><input type="text" class="form-control" value=<?php echo "'".$workingDays[10]['NbJours']."'";?> disabled></td>
                                </tr>
                                <tr>
                                    <td>Décembre</td>
                                    <td><input type="text" class="form-control" value=<?php echo "'".$workingDays[11]['NbJours']."'";?> disabled></td>
                                </tr>
                </div>
            </form>

    </div>


<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>