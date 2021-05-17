var $ = require('jQuery');

$(document).ready(function () {
    $collectionHolder = $('ul.images');

    $collectionHolder.find('li').each(function () {
        addTagFormDeleteLink($(this));
    });

    $collectionHolder.data('index', $collectionHolder.find('input').length);

    $('body').on('click', '.add_image', function (e) {
        var $collectionHolderClass = $(e.currentTarget).data('collectionHolderClass');

        addFormToCollection($collectionHolderClass);
    })
});

function addFormToCollection($collectionHolderClass) {
    var $collectionHolder = $('.' + $collectionHolderClass);
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);
    $collectionHolder.data('index', index + 1);

    var $newFormLi = $('<li></li>').append(newForm);

    $collectionHolder.append($newFormLi);
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormButton = $('<button type="button" class="text-red-400 text-sm">Retirer</button>');
    $tagFormLi.append($removeFormButton);

    $removeFormButton.on('click', function (e) {
        $tagFormLi.remove();
    });
}