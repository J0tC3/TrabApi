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
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <button type="button" class="btn btn-secondary" id="voltar">Voltar</button>
        </form>
        <div id="mensagem" class="mt-3"></div>
    </div>

    <script>
        $(document).ready(function() {
            // Function to load user data
            function loadUserData() {
                $.ajax({
                    url: 'http://localhost/TrabApi/backend/InfoUser',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('user_token_jwt')
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Assuming response contains the user data in JSON format
                        $('#nome').val(response.nome);
                        $('#senha').val(response.senha);
                        $('#email').val(response.email);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Erro:', textStatus, errorThrown);
                        $('#mensagem').text('Erro ao carregar dados do usuário.').addClass('alert alert-danger');
                    }
                });
            }

            // Load user data on page load
            loadUserData();

            // Handle form submission
            $('#CriarUsuario').submit(function(event) {
                event.preventDefault(); // Prevent default form submission
                var formData = {
                    nome: $('#nome').val(),
                    senha: $('#senha').val(),
                    email: $('#email').val()
                };
                
                $.ajax({
                    url: 'http://localhost/TrabApi/backend/AlterUsuario',
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('user_token_jwt')
                    },
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    success: function(response) {
                        $('#mensagem').text('Usuário atualizado com sucesso!').removeClass('alert-danger').addClass('alert alert-success');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Erro:', textStatus, errorThrown);
                        $('#mensagem').text('Erro ao atualizar usuário.').removeClass('alert-success').addClass('alert alert-danger');
                    }
                });
            });

            // Handle back button click
            $('#voltar').click(function() {
                window.history.back();
            });
        });
    </script>
</body>
</html>
