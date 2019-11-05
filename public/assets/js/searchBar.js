search1 = document.getElementById('search1');
search2 = document.getElementById('search2');

if (search1 != null) {
    let save = search1.value;
    search1.value = '';
    search1.value = save;
    search1.addEventListener('keyup', function (event) {sendForm(event);}, false);
}

if (search2 != null) {
    save = search2.value;
    search2.value = '';
    search2.value = save;
    search2.addEventListener('keyup',function (event) {sendForm(event);}, false);
}



function sendForm (event) {
   //if (event.keyCode >= 65 && event.keyCode <= 90) { // si une lettre est pressée uniquement
      clickFormButton();
   //}
}

function clickFormButton() {
    document.getElementById('search').click();
}