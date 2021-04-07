<?php $title = 'Clients'; ?>
<?php ob_start(); ?>
    <div class="container">
        <header class="page-header">
            <h1> Gestion des clients CIS </h1>
        </header>
        <br>
            <?php echo $messagefield1; ?> <br>
            <?php echo $messagefield2; ?> <br>
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="clientCreation" value="Création" disabled>
                    </div> 

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="clientModification" value="Modification" disabled>
                    </div>

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="clientModifRegistration" value="Enregistrer" >
                    </div>

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="clientCancel" value="Annuler" >
                    </div>   
                </div>

                <br> <br>

                <div class="row">

                    <div class="col-sm-3">
                        <input type="text" class="form-control input-lg" value=<?php echo "'".$_POST['client']."'";  ?>  id="client" placeholder="Nom Client" name="NomClient" 
                        <?php if(empty($_POST['client']) or empty($_POST['marketUnit']) ){echo "disabled";} ?>/>
                    </div>

                    <div class="col-sm-3 ">
                        <select id="marketUnit" placeholder="Market Unit" name="marketUnit" required class="form-control input-lg"
                        <?php if(empty($_POST['client']) or empty($_POST['marketUnit'])){echo "disabled";} ?> >
                            <option value=" "> </option>
                            <?php
                                while ($data=$marketUnits->fetch()) {
                                    ?>
                                    <option value=<?php echo $data['Nom'];?> <?php if($_POST['marketUnit']==$data['Nom']){echo "selected";} ?> 
                                    > <?php echo $data['Nom'];?> </option>
                                <?php
                                }
                            ?>
                        </select>
                    </div>


                    <div class="col-sm-3 ">
                        <input type="hidden" class="form-control input-lg"  id="clientID" value=<?php echo "'".$idClient['ID']."'"; ?> name="ID" placeholder="ID CLient">
                    </div>

                    

                </div>
            </form>

    </div>


    <!--script auto fetching the client to find the corresponding Market Unit -->
    <script src="public/js/functions/clientsFetch.js"></script>


<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>