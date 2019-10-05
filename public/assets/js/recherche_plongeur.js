function chargerDonnee(val)
{
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '15_8b.php?val='+val, true );

    var Lire = function()
    {
        if (xhr.readyState === 4 && xhr.status === 200)
        {
            document.getElementById('resultat').innerHTML = '<span>' + xhr.responseText + '</span>';
        }
    }
    xhr.addEventListener("readystatechange", Lire, false);
    xhr.send(null);
}

elt1 = document.getElementById('nom');
var mafonction1 = function(){
    chargerDonnee(elt1.value);
};
elt1.addEventListener('keyup',mafonction1, false);