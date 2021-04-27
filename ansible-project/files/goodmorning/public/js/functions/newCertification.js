function newCertification()
{
    var newRow= '<tr>'+
                '<td><input type="text" id="collabCertifTitle" name="certifTitle" class="form-control"></td>'+
                '<td>'+
                    // '<button type="submit" id="collabCertifValid" name="collabCertifValid">'+
                    // '<span class="glyphicon glyphicon-ok" ></span> Valider</button>'+
                     '<button type="button" id="collabCertifValid"'+
                     'onclick="collabCertifValidation(\'GGID\',\'collabCertifTitle\');">'+
                     '<span class="glyphicon glyphicon-ok" ></span> Valider</button>'+
                '</td>'+
                '</tr>';
    $("#bodyCertif").append(newRow);
    $("#newCertif").prop('disabled',true);   
}


                        
                            