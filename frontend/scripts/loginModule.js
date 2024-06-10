const btnLogin = document.getElementById('btnLogin');

btnLogin.addEventListener('click', loginApi);

//envia as credenciais e recebe um token caso elas existam no banco
function loginApi() {
    const username = $("#inputUsername").val();
    const passcode = $("#inputPassword").val();

    $.ajax({
        url: "http://localhost/TrabApi/backend/login",
        method: 'POST',
        data: {'username' : username, 'passcode': passcode},
        })
        .done(function( data ) {
            localStorage.setItem('user_token_jwt', data);
            window.open('./home', '_self');
        }
    );
}

const btnVoltar = document.getElementById('btnVoltar');

btnVoltar.addEventListener('click', () => {
    window.open('./home', '_self');
});

const btnCriar = document.getElementById('btnCriar');

btnCriar.addEventListener('click', () => {
    window.open('./signup', '_self');
});