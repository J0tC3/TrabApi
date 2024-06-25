(() => {
    const token = localStorage.getItem('user_token_jwt');

    if(token !== null) {
        window.open('./home', '_self');
    }

    const btnLogin = document.getElementById('btnLogin');

    btnLogin.addEventListener('click', loginApi);

    //envia as credenciais e recebe um token caso elas existam no banco
    function loginApi() {
        const username = $("#inputUsername").val();
        const passcode = $("#inputPassword").val();
    
        $.ajax({
            url: "http://localhost/TrabApi/backend/login",
            method: 'POST',
            dataType: 'text', // Esperamos um texto, não um JSON
            contentType: 'application/json', // Tipo de conteúdo JSON
            data: JSON.stringify({'username': username, 'passcode': passcode}),
        })
        .done(function(data) {
            if (data !== '') {
                localStorage.setItem('user_token_jwt', data);
            }
            window.open('./home', '_self');
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error('Erro ao realizar login:', textStatus, errorThrown);
            alert('Erro ao realizar login. Verifique suas credenciais e tente novamente.');
        });
    }
    
    const btnVoltar = document.getElementById('btnVoltar');

    btnVoltar.addEventListener('click', () => {
        window.open('./home', '_self');
    });

    const btnCriar = document.getElementById('btnCriar');

    btnCriar.addEventListener('click', () => {
        window.open('./signup', '_self');
    });
})();