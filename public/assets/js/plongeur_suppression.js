//Marche pas en faite
function ConfirmerSuppression(form){
    if (confirm("Voulez vous vraiment supprimer ce plongeur ?"))
    {
        form.submit();
    }
}