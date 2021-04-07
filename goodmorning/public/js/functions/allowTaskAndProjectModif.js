function allowTaskAndProjectModif()
{
    var projectTitle=document.getElementById("projectList").value;
    if (projectTitle !="") {
        document.getElementById("projectCode").disabled=true;
        document.getElementById("projetModif").disabled=false;
        document.getElementById("affectationModif").disabled=false;
    }
    else{
        document.getElementById("projectCode").disabled=false;
        document.getElementById("projetModif").disabled=true;
        document.getElementById("affectationModif").disabled=true;
    }
}