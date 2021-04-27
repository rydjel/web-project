function openCreationManagerModal(id)
{
   // Réinitialiser les menus déroulants
   $("#puChoice").val("Sélectionner une PU ...");
   $("#collabChoice").html("");

   $("#"+id).show();
}