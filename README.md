(penser à faire plein de tests, changement d'url, changement d'html (de type d'input), regex, etc) 
# ProjetPlongee2A

## Première Partie : Les formulaires de mise à jour de la base de données PLO
- Langage utilisé : PHP [+javascript] (aucun code javascript ne peut remplacer un traitement côté serveur)
- Technique de mise à jour : des formulaires HTML
- Résultat attendu : application Web.
- Tables concernées : celles de la base PLO
## Deuxième partie : Les personnes
> L'objectif est de réaliser un ou plusieurs formulaires de mise à jour de la table Client. Le langage utilisé sera le
PHP et la présentation sera faite en HTML.
Les tables doivent posséder des clés primaires [et étrangères le cas échéant]

#### PLO_PERSONNE : 
- [x] On ne peut supprimer un plongeur ayant des plongées, 
- [x] Une modification ne peut concerner per_num,
- [x] Les champs : nom,prenom sont obligatoires et ce duo doit être unique,
- [x] per_num est calculé,
- [x] les noms des personnes sont écrits en majuscule sans accent. Les tirets (dont 1 double tiret), espaces
isolés sont autorisés mais pas au début et à la fin. Les apostrophes sont autorisées à n’importe quel
endroit. Les caractères autorisés sont ceux de l'alphabet français (sans ligature).
- [x] les prénoms des personnes sont écrits en minuscule sauf les premières lettres de chaque mot, codée en
majuscule sans accent. Les tirets et espaces isolés sont autorisés mais ni au début, ni à la fin,
- [ ] les localités suivent les mêmes règles que les noms à 2 exceptions près : les chiffres sont autorisés ; les
doubles tirets sont interdits.
#### PLO_PLONGEUR, PLO_DIRECTEUR, PLO_SECURITE_DE_SURFACE :
- [x] Quand on crée une de ces personnes, on écrit également dans la table Personne
- [x] Pour les plongeurs, il faut pouvoir ajouter ou modifier une aptitude

**Attention aux suppressions et modifications : l'intégrité référentielle doit être préservée.**

## L'application minimale :
- [x] Proposera des formulaires d'ajout d'information dans la base
- [ ] Respectera l'intégrité référentielle
- [ ] Empêchera l'inscription de données absurdes
- [ ] Ne videra pas un formulaire s'il n'a pas été complété correctement
##### Plusieurs options peuvent permettre d'améliorer l'application
- [x] Une page générale proposant tous les ajouts
- [x] Des menus déroulant d'aide à la saisie
- [x] L'affichage des données inscrites avant enregistrement définitif dans la table
- [x] Des scripts de vérification des données saisies
- [x] Le calcul automatique des identifiants
- [x] Amélioration de la présentation par des feuilles de style
- [ ] Journal des transactions et des éventuelles erreurs
- [ ] Possibilité de visualiser voire de corriger la base
- [ ] Identification de l'utilisateur (gestion de la sécurité)
- [x] Consultations variées des données PLO
##### Pour le formulaire personne et par ordre de priorité, il faut être capable
- [x] d'ajouter +++
- [x] d'afficher les infos [avec tris et sélections] ++
- [x] de modifier une donnée ~+
- [x] de supprimer une donnée 

**Développer d'autres formulaires et peaufiner la présentation est une erreur si la page «Personne» est imparfaite !**

##### Conseils :
- [x] Privilégier le développement de nombreuses petites fonctions de traitement
- [x] Ne développer les formulaires que lorsque les traitements fonctionnent
- [x] Faire tester régulièrement l'application
## Troisième partie : Saisies des autres données
> L'objectif est de réaliser un ou plusieurs formulaires de mise à jour des tables du tour de PLO.
#### PLO_PLONGEE
- [x] La saisie d’une nouvelle plongee doit être la plus simple possible (un seul formulaire)
- [x] On peut afficher et corriger une plongée
- [ ] On peut supprimer une plongée mais un message de confirmation est nécessaire pour une plongée de
moins d’un an
- [x] On peut créer directement les palanquées après la création d’une plongée
- [x] Toutes les données sont obligatoires
- [x] [on peut créer un pdf]
#### PLO_PALANQUEE et PLO_CONCERNER
- [x] Pour ajouter une palanquée, il faut sélectionner une plongée
- [x] On peut compléter une palanquée
- [ ] On peut valider une palanquée lorsqu’elle est complète
- [ ] Pour une palanquée, on peut avoir 5 plongeurs au maximum
#### État d’une plongée. Une plongée peut être dans l’état
- [ ] « Créée » : on a créé une plongée
- [ ] « Paramétrée » : on a saisi toutes les palanquées d’avant la plongée
- [ ] « Complète » ou « validée » : on a complété toutes les palanquées d’après la plongée
- [ ] « Dépassée » : La plongée a plus d’un an
 ## Dernière partie : Affichage des données PLO
> L'objectif est de permettre la visualisation de toutes les informations de la base. Grâce à des menus adaptés et
aux jointures entre les tables, il sera possible de montrer des informations très complètes.

##### Par exemple, à partir de la page "personne", on peut accéder...
- [x] à ses plongées
- [ ] à ses aptitudes
- [x] à ses fonctions (plongeurs, directeur, sécurité de surface) …

##### "Plongée" on peut accéder
- [x] aux palanquées
- [x] aux commandes