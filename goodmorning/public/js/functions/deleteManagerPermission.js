function deleteManagerPermission(id1,id2)
{
   var res=id1.split("-");
   $("#"+id2).show();
   $("#managerToDelete").val(res[1]);
}