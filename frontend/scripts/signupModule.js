(() => {
    const token = localStorage.getItem('user_token_jwt');

    if(token !== null) {
        window.open('./home', '_self');
    }

    const btnCriar = document.getElementById('btnCriar');

    btnCriar.addEventListener('click', criarConta);

    function criarConta() {
        const username = $("#inputUsername").val();
        const passcode = $("#inputPassword").val();
        const email = $("#inputEmail").val();
    
        const requestData = {
            'username': username,
            'passcode': passcode,
            'email': email
        };
    
        $.ajax({
            url: 'http://localhost/TrabApi/backend/criarUsuario',
            method: 'POST',
            contentType: 'application/json', // Tipo de conteúdo do request
            data: JSON.stringify(requestData), // Dados convertidos para JSON
            dataType: 'json',
            success: function(data) {
                
                if(data.status) {
                    alert("Conta criada com sucesso!");
                    window.open('./login', '_self'); // Redireciona para a página de login
                }else {
                    alert(data.titulo);
                }
                

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Erro ao criar conta:', textStatus, errorThrown);
                alert("Erro ao criar conta! Tente novamente ou atualize a página.");
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