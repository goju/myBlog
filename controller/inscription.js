$(function () {
    $('form').submit(function () {
        $('#blocErreur').html('');
        $('#blocSuccess').html('');
        $.ajax({
            url: '../controller/inscription.php',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',

            success: function(data){
                var toPrint = 'Bienvenue '+data.user.username +'<meta http-equiv="refresh" content="0.5; URL=../view/login.php">';
                $('#blocSuccess').html(toPrint);
            },

            error: function(data, status, error) {
                var toPrint = '';

                data = JSON.parse(data.responseText);
                for(var d in data.errors){
                    toPrint += d+' :'+data.errors[d]+'<br>';
                }
                $('#blocErreur').html(toPrint);
            }
        });
        return false;
    });
});