function newselection(val) {
    var ids=["DR","Collab","Project"];
    for (k=0; k < ids.length; k++) {
        if (ids[k]!=val) {
            document.getElementById(ids[k]).value="Sélectionner ...";
        }    
    }
}