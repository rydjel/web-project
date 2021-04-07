<?php $title = 'Accueil CIS'; ?>

<?php ob_start(); ?>
    <div class="container">
        <header class="page-header">
            <div class="row">
                <div>
                    <h1> Gestion des Consultants CIS </h1>
                </div>
                <div>
                    <button type='button' class='btn btn-primary pull-right' onclick="window.open('http://10.24.209.88/goodmorning/report.html','_blank')">Reporting</button>
                </div>
            </div>
            
        </header>

        <section class="row">
            <div class="col-lg-12">
                <p>
                <h3> <strong> Merci de sélectionner une option parmi les éléments ci-dessous </strong> </h3>
                <p>
            </div>
        </section>

        <form action="index.php" method="post">

            <div class="row">
                <div class="form-group">
                    <label for="refData" class="col-lg-2 control-label">Données Référentielles : </label>
                    <div class="col-lg-6">
                        <select id="DR" name="DR" class="form-control" onchange="newselection('DR');">
                            <option value="Sélectionner ...">Sélectionner ...</option>
                            <option value ="Rate Card">ADRC</option>
                            <option value="Clients">Clients</option>
                            <option value="Production Unit">Production Unit</option>
                            <option value="Sites">Sites</option>
                            <option value="Market Unit">Market Unit</option>
                            <option value="Jours Ouvrables">Jours Ouvrables</option>
                            <option value="Types Activités">Types Activités</option>
                            <option value="Manager">Equipe Managériale</option>
                            <option value="Carrier Manager">Equipe Carrier Managers</option>
                            <option value="Support">Equipe Support</option>
                            <option value="profilTitle">Titre Profil</option>
                            <option value="defaultTask">Tâches par Défaut</option>
                            <option value="PNL-KPI-TYPE">PNL-KPI-TYPE</option>
                            <option value="PNL-KPI">PNL-KPI</option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <input type="submit" class="btn btn-primary btn-block" value="Valider" name="ValidationWelcomeView">
                    </div>
                </div>   
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="collab" class="col-lg-2 control-label">Collaborateurs : </label>
                    <div class="col-lg-3">
                        <input type="submit" class="btn btn-primary btn-block" name="gestionCollab" id="collab" value="Gestion">
                    </div>
                    <div class="col-lg-3">
                        <input type="submit" class="btn btn-primary btn-block" name="planDeChargeCollab" id="Retour" value="Plan de Charge">
                    </div>
                </div>   
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="projet" class="col-lg-2 control-label">Projets : </label>
                    <div class="col-lg-3">
                        <input type="submit" class="btn btn-primary btn-block" name="gestionProjet" id="projet" value="Gestion">
                    </div>
                </div>   
            </div>

        </form>

    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script src="public/js/functions/newselection.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>