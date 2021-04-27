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
            <h1> Gestion des clients CIS </h1>
        </header>
        <br>
            <form action="" method="post">
                <!-- <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="clientCreation" value="Création" disabled>
                    </div> 
  
                </div>

                <br> <br> -->

                <div class="row">

                    <div class="col-sm-3">
                        <label for="client">Nom Client</label> 
                        <input type="text" class="form-control input-lg" value=""  id="client" name="client"/>
                    </div>

                    <div class="col-sm-3 ">
                        <label for="marketUnit">Market Unit</label>
                        <select id="marketUnit" placeholder="Market Unit" name="marketUnit"  class="form-control input-lg">
                            <option value=""></option>
                            <?php
                                while ($data=$marketUnits->fetch()) {
                                    ?>
                                    <option value=<?php echo $data['Nom'];?> > <?php echo $data['Nom'];?> </option>
                                <?php
                                }
                            ?>
                        </select>
                    </div>

                </div>

                <br><br><br><br>
                <div class="row">

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="clientCreationRegistration" value="Enregistrer">
                    </div>

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="clientCancel" value="Retour">
                    </div>   
                </div>
            </form>

    </div>


<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>