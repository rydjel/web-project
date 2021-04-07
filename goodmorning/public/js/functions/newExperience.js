function newExperience()
{
    var newRow= '<tr>'+
                    '<td><input type="date" id="collabExpDebut" name="collabExpDebut" class="form-control"></td>'+
                    '<td><input type="date" id="collabExpEnd" name="collabExpEnd" class="form-control"></td>'+
                    '<td><textarea class="form-control" rows="3" id="collabExpDetails" name="collabExpDetails"></textarea></td>'+
                    '<td>'+
                        //'<button type="submit" id="ExpValid" name="ExpValid">'+
                        //'<span class="glyphicon glyphicon-ok" ></span> Valider</button>'+
                        '<button type="button" id="ExpValid"'+
                        'onclick=collabExpValidation("GGID","collabExpDebut","collabExpEnd","collabExpDetails");>'+
                        '<span class="glyphicon glyphicon-ok" ></span> Valider</button>'+
                    '</td>'+
                '</tr>';
    $("#bodyExp").append(newRow);
    $("#newExp").prop('disabled', true);   
}


                        
                            