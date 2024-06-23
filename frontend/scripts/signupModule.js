(() => {
    const token = localStorage.getItem('user_token_jwt');

    if(token != '' || token != null) {
        window.open('./home', '_self');
    }

    const btnCriar = document.getElementById('btnCriar');

    btnCriar.addEventListener('click', criarConta);

    function criarConta() {
        const username = $("#inputUsername").val();
        const passcode = $("#inputPassword").val();
        const email = $("#inputEmail").val();

        $.ajax({
            url: 'http://localhost/TrabApi/backend/createUsuario',
            method: 'POST',
            data: {'username': username, 'passcode': passcode, 'email': email},
            dataType: 'json',
            success: function(data) {
                alert("Conta criada com sucesso!");
                window.open('./login', '_self');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Erro:', textStatus, errorThrown);
                alert("Erro ao criar conta! Tente novamente ou atualize a pagina!");
            }
        });
    }

    const btnVoltar = document.getElementById('btnVoltar');
    btnVoltar.addEventListener('click', () => {
        window.open('./home', '_self');
    });

    const btnLogin = document.getElementById('btnLogin');
    btnLogin.addEventListener('click', () => {
        window.open('./login', '_self');
    });
})();