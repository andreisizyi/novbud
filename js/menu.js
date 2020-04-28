jQuery(function($){
    //Настраиваем меню
    var menu = $("nav.menu-header");
    $(".toggler").click(function() {
        menu.toggleClass('active-menu');
    });
    $(document).mouseup(function (e){
        var div = $("nav.menu-header");
        if (!div.is(e.target)  && div.has(e.target).length === 0  && menu.hasClass('active-menu') ) { // и не по его дочерним элементам
            $("nav.menu-header").toggleClass('active-menu');
        }
    });
});