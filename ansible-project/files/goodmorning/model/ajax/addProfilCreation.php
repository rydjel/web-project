<?php
require("../frontend.php");
$PTList=getProfilTitles(); // get the list of Profile Titles
/* $liste='<div class="col-sm-7">
            <label for="PTChoice">Titre:</label>
            <select id="PTChoice" class="form-control" name="PTChoice">
            <option value=""></option>';
if ($PTList) {
    while ($data=$PTList->fetch()) {
        $liste.='<option value="'.$data['ID'].'">'.$data['intitule'].'</option>';
    }
}
$liste.='</select></div>';
$textarea='<div class="col-sm-7">
    <textarea class="form-control" rows="3" title="Profil" id="profilToADD" name="profilDetails"></textarea>
</div>
<div class=" col-sm-3">
    <button type="button" class="btn btn-primary btn-block form-control" id="buttonCollabProfilAdd" onclick="collabProfilAdd(\'profilToADD\',\'ID\',this.id);">Valider</button>
</div>'; */

$profileBody='<div class="row">
                    <div class="col-sm-3">
                        <button type="button"  id="newProfil" class="btn btn-primary btn-block" onclick="addProfil();" disabled>Rajout Profil</button>
                    </div>
              </div>
              <div class="row">
                <div class="col-sm-7">
                    <label for="PTChoice">Titre</label>
                    <select id="PTChoice" class="form-control col-sm-7" name="PTChoice">
                        <option value=""></option>';
if ($PTList) {
    while ($data=$PTList->fetch()) {
        $profileBody.='<option value="'.$data['ID'].'">'.$data['intitule'].'</option>';
    }
}

$profileBody.='</select></div></div>
                <div class="row">
                    <div>
                        <textarea class="form-control" rows="3" title="Profil" id="profilToADD" name="profilDetails"></textarea>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-primary btn-block form-control" id="buttonCollabProfilAdd" onclick="collabProfilAdd(\'profilToADD\',\'ID\',\'PTChoice\');">Valider</button>
                    </div>
                </div>';

echo $profileBody;
