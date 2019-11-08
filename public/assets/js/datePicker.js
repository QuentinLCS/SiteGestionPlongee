$(document).ready(function(){

    $('.datepicker').datepicker({
        setDefaultDate: true,
        firstDay: 1,
        format: 'yyyy-mm-dd',
        minDate: new Date(2000,1,1),
        i18n: {
            done: 'Valider',
            cancel: 'Annuler',
            months:
                [
                    'Janvier',
                    'Février',
                    'Mars',
                    'Avril',
                    'Mai',
                    'Juin',
                    'Juillet',
                    'Août',
                    'Septembre',
                    'Octobre',
                    'Novembre',
                    'Décembre'
                ],
            monthsShort:
                [
                    'Jan',
                    'Fev',
                    'Mar',
                    'Avr',
                    'Mai',
                    'Jun',
                    'Jul',
                    'Aoû',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
            weekdays:
                [
                    'Dimanche',
                    'Lundi',
                    'Mardi',
                    'Mercredi',
                    'Jeudi',
                    'Vendredi',
                    'Samedi'
                ],
            weekdaysShort:
                [
                    'Dim',
                    'Lun',
                    'Mar',
                    'Mer',
                    'Jeu',
                    'Ven',
                    'Sam'
                ],
            weekdaysAbbrev:
                ['D', 'L', 'M', 'M', 'J', 'V', 'S']
        }
    });
});