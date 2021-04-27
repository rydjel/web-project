function newCompetence()
{
    var newRow= '<tr>'+
                '<td><input type="text" id="collabCompetenceTitle" name="title" class="form-control"></td>'+
                '<td>'+
                    '<select id="collabNivComp" name="level" class="form-control">'+
                        '<option value="Académique">Académique</option>'+
                        '<option value="Confirmé">Confirmé</option>'+
                        '<option value="Expert">Expert</option>'+
                        '<option value="Guru">Guru</option>'+
                    '</select>'+
                '</td>'+
                '<td>'+
                    // '<button type="submit" id="collabCompValid" name="collabCompValidation">'+
                    // '<span class="glyphicon glyphicon-ok" ></span>Valider</button>'+
                     '<button type="button" id="collabCompValid"'+
                     'onclick="collabCompValidation(\'GGID\',\'collabCompetenceTitle\',\'collabNivComp\');">'+
                     '<span class="glyphicon glyphicon-ok" ></span>Valider</button>'+
                '</td>'+
                '</tr>';
    $("#bodyComp").append(newRow);
    $("#newComp").prop('disabled', true);   
}

                        
                            