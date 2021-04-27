<?php $title = 'Clients'; ?>
<?php ob_start(); ?>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" onclick="window.location.href='index.php';">Menu Principal</button>
            </div>
        </div>
        
        <header class="page-header">
            <h1> Gestion des KPI CIS </h1>
        </header>
        <br>

            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-primary btn-block form-control" onclick="openCreationPnlKpiModal('creationPnlKpiModal');">Création</button>
                    </div> 

                </div>

                <br> <br>

                <div id="message"><?php echo $message; ?></div>

                <div class="row">

                    <section class="table responsive ">
                        <table class="table  table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th class="col-xs-2">Type de KPI</th>
                                    <th class="col-xs-1">Mois</th>
                                    <th class="col-xs-1">Budget</th>
                                    <th class="col-xs-1">Forecast</th>
                                    <th class="col-xs-3"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_id">
                                <?php
                                if ($kpiList) {
                                    while ($data=$kpiList->fetch()) {
                                        $kpiTypeID="kpi-".$data['id_pnlkpi'];
                                        $monthID="month-".$data['id_pnlkpi'];
                                        $budgetID="budget-".$data['id_pnlkpi'];
                                        $forecastID="forecast-".$data['id_pnlkpi'];
                                        ?>
                                        <tr>
                                            <td>
                                                <select id=<?php echo $kpiTypeID;?> class="form-control" disabled>
                                                <?php
                                                    foreach($kpiTypes as $key => $value)
                                                    {
                                                    ?>
                                                        <option value=<?php echo $key;?> <?php if($key==$data['id_pnlkpitype']){echo "selected";}?> > <?php echo $value;?> </option>
                                                    <?php
                                                    }
                                                    ?> 

                                                </select>
                                            </td>
                                            <td>
                                                <select id=<?php echo $monthID;?> class="form-control" disabled>
                                                    <?php
                                                    foreach($months as $key => $value)
                                                    {
                                                    ?>
                                                        <option value=<?php echo $key;?> <?php if($key==$data['id_mois']){echo "selected";}?> > <?php echo $value;?> </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" min="0" step="any" class="form-control" value=<?php echo $data['budget'];?> id=<?php echo $budgetID;?> disabled>
                                            </td>
                                            <td>
                                                <input type="number" min="0" step="any" class="form-control" value=<?php echo $data['forecast'];?> id=<?php echo $forecastID;?> disabled>
                                            </td>
                                            <td>
                                                <button type="button" id=<?php echo 'edit-'.$data['id_pnlkpi'];?> onclick="allowPnlKpiModif(this.id);">
                                                <span class='glyphicon glyphicon-edit' ></span> Editer</button>
                                                <button type="button" id=<?php echo "validation-".$data['id_pnlkpi'];?> disabled
                                                onclick="pnlKpiUpdateValidation('<?php echo $kpiTypeID;?>','<?php echo $monthID;?>','<?php echo $budgetID;?>','<?php echo $forecastID;?>',this.id);">
                                                <span class='glyphicon glyphicon-ok' ></span> Valider</button>
                                                <button type="button" id=<?php echo 'annuler-'.$data['id_pnlkpi'];?> 
                                                onclick="cancelPnlKpiModif('<?php echo $kpiTypeID;?>','<?php echo $monthID;?>','<?php echo $budgetID;?>','<?php echo $forecastID;?>',this.id,
                                                '<?php echo 'validation-'.$data['id_pnlkpi'];?>');">
                                                <span class='glyphicon glyphicon-refresh' ></span> Rafraichir/Annuler</button>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                }     
                                ?>
                            </tbody>
                        </table>
                    </section>
                </div>
            </form>

    </div>

    <script src="public/js/functions/allowClientModif.js"></script>
    <script src="public/js/functions/clientUpdateValidation.js"></script>
    <script src="public/js/functions/cancelClientModif.js"></script>
    <script src="public/js/functions/openCreationClientModal.js"></script>
    <script src="public/js/functions/closeCreationCLientModal.js"></script>
    <script src="public/js/functions/createClient.js"></script>


    <script src="public/js/functions/allowPnlKpiModif.js"></script>
    <script src="public/js/functions/pnlKpiUpdateValidation.js"></script>
    <script src="public/js/functions/cancelPnlKpiModif.js"></script>
    <script src="public/js/functions/openCreationPnlKpiModal.js"></script>
    <script src="public/js/functions/closeCreationPnlKpiModal.js"></script>
    <script src="public/js/functions/createPnlKpi.js"></script>

    



<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

<!-- Fenêtre Modal de création d'un nouveau KPI -->
<div class="modal" id="creationPnlKpiModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title"><strong>Création d'un nouveau KPI</strong></h3>
      </div>
      <div class="modal-body">
        <div class="row">

            <div class="col-sm-4">
                <label for="typeKPI">Type de KPI</label>
                <select id="typeKPI" name="typeKPI"  class="form-control input-lg" required>
                    <option value=""></option>
                    <?php
                    if ($kpiTypesListFC) {
                        while ($data=$kpiTypesListFC->fetch()) {
                            ?>
                            <option value=<?php echo "'".$data['id_pnlkpitype']."'";?> > <?php echo $data['type'];?> </option>
                        <?php
                        }
                    }     
                    ?>
                </select>
            </div>

            <div class="col-sm-4">
                <label for="month">Mois</label>
                <select id="month" name="month"  class="form-control input-lg" required>
                    <option value=""></option>
                    <?php
                    if ($monthListFC) {
                        while ($data=$monthListFC->fetch()) {
                            ?>
                            <option value=<?php echo "'".$data['ID']."'";?> > <?php echo $data['nom_mois'];?> </option>
                        <?php
                        }
                    }     
                    ?>
                </select>
            </div>

            <div class="col-sm-3">
                <label for="budget">Budget</label> 
                <input type="number" min="0" step="any" class="form-control input-lg"  id="budget" name="budget" required/>
            </div>

            <div class="col-sm-3">
                <label for="forecast">Forecast</label> 
                <input type="number" min="0" step="any" class="form-control input-lg"  id="forecast" name="forecast" required/>
            </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="createPnlKpi('typeKPI','month','budget','forecast','creationPnlKpiModal');">Valider</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeCreationPnlKpiModal('creationPnlKpiModal');" >Annuler</button>
      </div>
    </div>
  </div>
</div>