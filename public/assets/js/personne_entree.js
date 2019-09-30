let prenom = document.getElementById("prenom").value;
let nom = document.getElementById("nom").value;
let regexPrenom = /[:alpha:]/i;
let regexNom = /[:alpha:]/i;
prenom.match(regexPrenom);
prenom.match(regexNom);
