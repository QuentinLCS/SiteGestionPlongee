search1 = document.getElementById('search2');
search2 = document.getElementById('search1');

search1.addEventListener('keyup', function (event) {sendForm(event);}, false);
search2.addEventListener('keyup',function (event) {sendForm(event);}, false);


function sendForm (event) {
   //if (event.keyCode >= 65 && event.keyCode <= 90) { // si une lettre est pressée uniquement
      clickFormButton();
   //}
}

function clickFormButton() {
   document.getElementById('search').click()
}