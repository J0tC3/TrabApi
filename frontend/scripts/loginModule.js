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
            if(isJsonString(data)) {
                console.error('Erro: ' + JSON.parse(data).titulo);
            }else if (data !== '') {
                localStorage.setItem('user_token_jwt', data);
                window.open('./home', '_self');
            }
        })
    }

    function isJsonString(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
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