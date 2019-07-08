
let searchResult = $(".searchResult");
let button = $(".showMore");
let buttons = $(button);
let button = $(".showMore");
// find elements
if (searchResult.css('height') > '250') {
    $(button).hide()
}

$(buttons).click(function(){
    $(buttons).toggleClass('switcher');
    if($(this).hasClass('switcher')){
        $(searchResult).animate({
            height: '500px',
        }, 300)
    }else{
        $(searchResult).animate({
            height: '180px',
        }, 300)
    }
})