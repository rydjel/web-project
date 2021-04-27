function allowTaskAndProjectModifByCodeProj(id)
{
    var projCode=$("#"+id).val();

    $.ajax( {
        url: "model/ajax/checkProjExist.php",
        method: "post",
        data: {projCode:projCode},
        success: function(data) {
            if (data==1) {
                $("#clientChoice").prop('disabled', true);
                $("#projetModif").prop('disabled', false);
                $("#affectationModif").prop('disabled', false);
            }
            else if(data==0){
                $("#clientChoice").prop('disabled', false);
                $("#projetModif").prop('disabled', true);
                $("#affectationModif").prop('disabled', true);
            }
        }
    });
    window.scrollTo(0, 0);

}