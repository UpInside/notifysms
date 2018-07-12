$(function () {

    $('html').on('submit', 'form[name="add_user"]', function (e) {
        e.preventDefault();

        var user_name = $(this).find('input[name="user_name"]').val();
        var user_email = $(this).find('input[name="user_email"]').val();
        var user_password = $(this).find('input[name="user_password"]').val();
        var user_phone = $(this).find('input[name="user_phone"]').val();

        $.post('controller.php', {
            action: 'add_user',
            user_name: user_name,
            user_email: user_email,
            user_password: user_password,
            user_phone: user_phone
        }, function (data) {

            if (data.add_user === true){

                $('.validate_code').html("" +
                    "<p class='validate_code_subject'>Seu cadastro está quase pronto!</p>" +
                    "    <p class='validate_code_subject'>Primeiro confirme o código que você recebeu pelo SMS:</p>" +
                    "    <form method='post' name='validate_code'>" +
                    "        <input type='hidden' name='user_email' value='" + user_email + "'>" +
                    "        <input type='text' name='user_code' placeholder='Insira o Código'>" +
                    "        <button type='submit'>Validar!</button>" +
                    "    </form>" +
                    "    <div class='validate_return'></div>").css('display', 'block');

            } else {
                console.log('Falhou!');
            }
        }, 'json');
    });


    $('html').on('submit', 'form[name="validate_code"]', function (e) {
        e.preventDefault();

        var user_email = $(this).find('input[name="user_email"]').val();
        var user_code = $(this).find('input[name="user_code"]').val();

        $.post('controller.php', {
            action: 'validate_code',
            user_email: user_email,
            user_code: user_code
        }, function (data) {

            if(data.validate === true){
                $('.validate_return').html("<p>Conta ativada com sucesso!</p>");
            } else {
                $('.validate_return').html("<p>Não foi possível validar o código!</p>");
            }

        }, 'json');
    });

});