var $ = require('jQuery');

$(document).ready(function(){
    $(".trick-card").slice(0, 4).show();
    $("#loadMore").on("click", function(e){
        e.preventDefault();
        $(".trick-card:hidden").slice(0, 4).slideDown();
        if($(".trick-card:hidden").length == 0) {
            $("#loadMore").text("No Content").addClass("hidden");
        }
    });
})