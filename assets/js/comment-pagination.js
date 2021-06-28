import './simple-pagination';
let $ = require('jQuery');

let items = $(".wrapper-comment .comment-item");
let numItems = items.length;
let perPage = 4;

items.slice(perPage).hide();

$('#pagination-container').pagination({
    items: numItems,
    itemsOnPage: perPage,
    prevText: "&laquo;",
    nextText: "&raquo;",
    onPageClick: function (pageNumber) {
        let showFrom = perPage * (pageNumber - 1);
        let showTo = showFrom + perPage;
        items.hide().slice(showFrom, showTo).show();
    }
});