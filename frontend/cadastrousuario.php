<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/addartigo.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Cadastro de Usuário</h1>
        <form id="CriarUsuario">
            <div class="form-group">
                <label for="nome">Username:</label>
                <input class="form-control" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="passcode" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Criar Usuário</button>
        </form>
        <div id="mensagem" class="mt-3"></div>
    </div>

    <script>
        $(document).ready(function() {
            $('#CriarUsuario').on('submit', function(event) {
                event.preventDefault();

                // Obtém os valores dos campos do formulário
                const nome = $('#nome').val().toUpperCase();
                const senha = $('#senha').val();
                const email = $('#email').val();

                $.ajax({
                    url: 'http://localhost/TrabApi/backend/createUsuario',
                    method: 'POST',
                    data: {username: nome, passcode: senha, email: email},
                    dataType: 'json',
                    success: function(data) {
                        $('#mensagem').text(data.msg).addClass('alert alert-info');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Erro:', textStatus, errorThrown);
                        $('#mensagem').text(data.msg).addClass('alert alert-danger');
                    }
                });
            });
        });
    </script>
</body>
</html>

