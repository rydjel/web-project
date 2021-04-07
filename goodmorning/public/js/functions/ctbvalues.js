function ctbvalues(val,id1,id2,id3) {
    var cb1=val/((100-50)/100);
    var cb2=val/((100-45)/100);
    var cb3=val/((100-40)/100);
    /* document.getElementById(id1).value=val/((100-50)/100);
    document.getElementById(id2).value=val/((100-45)/100);
    document.getElementById(id3).value=val/((100-40)/100); */
    document.getElementById(id1).value=cb1.toFixed(2);
    document.getElementById(id2).value=cb2.toFixed(2);
    document.getElementById(id3).value=cb3.toFixed(2);
}