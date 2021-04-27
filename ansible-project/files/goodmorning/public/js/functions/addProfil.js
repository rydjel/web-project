function addProfil()
{

    $.ajax( {
        url: "model/ajax/addProfilCreation.php",
        method: "post",
        //dataType:'JSON',
        //data: {idExtend:id2},
        success: function(data) {
            //$("#"+id1).val(data);
            /* $("#newProfilAdd").append(data); */
            $("#bodyProfil").html("");
            $("#bodyProfil").append(data);
            $("#newProfil").prop('disabled', true);
        }
    });
    
    /* var newProfilArea=  '<div class="row">'+
                            '<select id="PTChoice" class="form-control" name="PTChoice">'+
                                '<option value=""></option>'+
                                '<?php if ($PTList) {while ($data=$PTList->fetch()) { ?> <option value=<?php echo $data[\'ID\']; ?> > <?php echo "\'".$data[\'intitule\']."\'"; ?> </option> <?php } }?>'+
                            '</select>'+
                            '</div>'+                       
                            '<div class="row">'+
                            '<div>'+ '<br>'+
                                '<textarea class="form-control" rows="2" class="col-sm-7" title="Profil" id="profilToADD" name="profilDetails"></textarea>'+
                            '</div>'+ '<br>'+
                            '<div class="col-sm-3">'+
                                //'<button type="submit" class="btn btn-primary btn-block" name="collabProfilAdd">Valider</button>'+
                                '<button type="button" class="btn btn-primary btn-block" id="buttonCollabProfilAdd" onclick="collabProfilAdd(\'profilToADD\',\'ID\',this.id);">Valider</button>'+
                            '</div>'+
                        '</div>';  */
    //$("#newProfilAdd").append(newProfilArea);
    /* $("#newProfilAdd").html(newProfilArea);
    $("#newProfil").prop('disabled', true);  */  
}

                   
                            