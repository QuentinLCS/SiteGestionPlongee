let inputPnom = document.getElementById('prenom');
let inputNom = document.getElementById('nom');

let accent = [
    /[\300-\306]/g, /[\340-\345]/g, // A, a
    /[\310-\313]/g, /[\350-\353]/g, // E, e
    /[\314-\317]/g, /[\354-\357]/g, // I, i
    /[\322-\330]/g, /[\362-\370]/g, // O, o
    /[\331-\334]/g, /[\371-\374]/g, // U, u
    /[\321]/g, /[\361]/g, // N, n
    /[\307]/g, /[\347]/g, // C, c
    /œ/g, /æ/g, /"/g
];
let noaccent = ['A','a','E','e','I','i','O','o','U','u','N','n','C','c','oe','ae', '', '-'];

inputNom.addEventListener('keyup', () => {
    for(let i = 0; i < accent.length; i++) {
        if (inputNom.value.match(accent[i]))
            document.getElementById('form-error').innerHTML = 'Caractères invalides détectés dans le <strong>NOM</strong>. <br> Ces derniers ont été remplacés automatiquement.';
        inputNom.value = inputNom.value.replace(accent[i], noaccent[i]);
    }

    inputNom.value = inputNom.value.toUpperCase();
}, false);

inputPnom.addEventListener('keyup', () => {
    for(let i = 0; i < accent.length; i++){
        if (inputPnom.value.match(accent[i]))
            document.getElementById('form-error').innerHTML = 'Caractères invalides détectés dans le <strong>PRENOM</strong>. <br> Ces derniers ont été remplacés automatiquement.';
        inputPnom.value = inputPnom.value.replace(accent[i], noaccent[i]);
    }

    inputPnom.value = inputPnom.value.substr(0,1).toUpperCase() + inputPnom.value.substr(1);
}, false);
