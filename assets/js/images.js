let $ = require('jQuery');

function addFormToCollection($collectionHolderClass) {
    let $collectionHolder = $('.' + $collectionHolderClass);
    let prototype = $collectionHolder.data('prototype');
    let index = $collectionHolder.data('index');
    let newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);

    $collectionHolder.data('index', index + 1);

    let $newFormLi = $('<li></li>').append(newForm);

    $collectionHolder.append($newFormLi);
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    let $removeFormButton = $('<button type="button" class="text-red-400 text-sm">Retirer</button>');
    $tagFormLi.append($removeFormButton);

    $removeFormButton.on('click', function (e) {
        $tagFormLi.remove();
    });
}

$(document).ready(function () {
    let $collectionHolder = $('ul.thumbs');

    $collectionHolder.find('li').each(function () {
        addTagFormDeleteLink($(this));
    });

    $collectionHolder.data('index', $collectionHolder.find('input').length);

    $('body').on('click', '.add_image', function (e) {
        console.log("ca clique , bro")
        let $collectionHolderClass = $(e.currentTarget).data('collectionHolderClass');

        addFormToCollection($collectionHolderClass);
    })
});