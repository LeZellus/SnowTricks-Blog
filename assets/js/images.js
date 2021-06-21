var $ = require('jQuery');

console.log('image ok');

$(document).ready(function () {
    $collectionHolder = $('ul.thumbs');

    $collectionHolder.find('li').each(function () {
        addTagFormDeleteLink($(this));
    });

    $collectionHolder.data('index', $collectionHolder.find('input').length);

    $('body').on('click', '.add_image', function (e) {
        console.log("ca clique , bro")
        var $collectionHolderClass = $(e.currentTarget).data('collectionHolderClass');

        addFormToCollection($collectionHolderClass);
    })
});

function addFormToCollection($collectionHolderClass) {
    // Get the ul that holds the collection of tags
    var $collectionHolder = $('.' + $collectionHolderClass);

    console.log($collectionHolder);

    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
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