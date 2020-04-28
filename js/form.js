jQuery(function($){
    //Form - select custum
    $(document).ready(function() {
        $('.js-form').select2({
            minimumResultsForSearch: -1
        });
    });
    //Form - input mask
    $('.form-col.number').hover(
        function(){
            if ($(this).children().val() == '') {
                $(this).children().attr('placeholder','+38 (___) ___ __ __');
                $(this).addClass('beforeel');
            }
        },
        function(){
            if ($(this).children().val() == '') {
                $(this).children().attr('placeholder','Ваш номер телефону');
                $(this).removeClass('beforeel');
            }
        }
    );
    $(document).ready(function(){
        $('input[type=tel]').mask('+38 (000) 000 00 00');
    });
    //Проверка формы
    function check(){
        if($('input[type=tel]').val().length == 19) {
            $('input#submit').val('Відправити');
        } else {
            $('input#submit').val('Некоректні данні');
        };
    }
    $('input#submit').hover(
        function(){
            check();
        },
        function(){
            $(this).val('Відправити');
        }
    );
    //Отправка формы
    $('.form').submit(function(){
        if($('input[type=tel]').val().length == 19) {
            $('input#submit').attr('disabled', true);
            $('input#submit').val('Зачекайте ...');
            $.post(
                '/wp-content/themes/macroproject/parts/post.php', // адрес обработчика
                //'https://itempromo.com/post.php',
                $('form').serialize(), // отправляемые данные          
                function(msg) { // получен ответ сервера 
                    $('input#submit').val('Успішно надіслано');
                    setTimeout(function(){
                        $('input#submit').attr('disabled', false);
                        $('input#submit').val('Відправити');
                    }, 10000);
                }
            );
            return false;
        } else {
            event.preventDefault();
            $('input#submit').val('Некоректні данні');
        }
    }); 
});