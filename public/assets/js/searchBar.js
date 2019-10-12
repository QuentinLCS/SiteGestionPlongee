elt1 = document.getElementById('autocomplete-input');



elt1.addEventListener('keyup', function () {
    let xhr = new XMLHttpRequest();
    console.log(elt1.value);
    xhr.open('GET', '?search='+elt1.value, true );

    let Lire = function()
    {
        if (xhr.readyState === 4 && xhr.status === 200)
        {
            options.push(xhr.responseText);
        }
    };

    xhr.addEventListener("readystatechange", Lire, false);
    xhr.send(null);

    $(document).ready(function(){
        $('input.search').autocomplete({
            data: {
                "Apple": null,
                "Microsoft": null,
                "Google": 'https://placehold.it/250x250'
            },
        });
    });

    }, false);

