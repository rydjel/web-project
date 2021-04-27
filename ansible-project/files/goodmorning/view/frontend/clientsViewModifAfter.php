<?php $title = 'Clients'; ?>
<?php ob_start(); ?>
    <div class="container">
        <header class="page-header">
            <h1> Gestion des clients CIS </h1>
        </header>
        <br>
            <?php echo $message; ?> <br>
            <?php echo $message1; ?> <br>
            <?php echo $message2; ?> <br>
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="clientCreation" value="Création">
                    </div> 

                    <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary btn-block" name="clientModification" id="clientModification" value="Modification">
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
                        <input type="text" class="form-control input-lg" value=""  id="client" name="client" placeholder="Nom Client" 
                        onchange="getElement(this.value,'marketUnit','model/getClientMarketUnit.php');"/>
                    </div>

                    <div class="col-sm-3 ">
                        <input type="text" class="form-control input-lg"  id="marketUnit" name="marketUnit" placeholder="Market Unit"/>
                    </div>

                </div>
            </form>

    </div>

    <script src="public/js/functions/allowClientModif.js"></script>
<!--script auto fetching the client to find the corresponding Market Unit -->
<script src="public/js/functions/clientsFetch.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>