<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Artigo</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="styles/addartigo.css">
</head>
<body>
    <div class="container">
        <h1>Criar Artigo</h1>
        <form id="criarArtigoForm">
        <div class="form-group">
                <label for="titulo">Titulo:</label>
                <textarea class="form-control" id="titulo" name="titulo" required></textarea>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="link">Link:</label>
                <input type="text" class="form-control" id="link" name="link" required>
            </div>
            <button type="submit" class="btn btn-primary">Criar Artigo</button>
        </form>
        <div id="mensagem"></div>
    </div>
    <script>
        document.getElementById('criarArtigoForm').addEventListener('submit', function(event) {
                event.preventDefault();

                // Obtém os valores dos campos do formulário
                const titulo = document.getElementById('titulo').value;
                const descricao = document.getElementById('descricao').value;
                let link = document.getElementById('link').value;

                if (link.indexOf("https://") !== 0) {
                   link = 'https://' + link;    
                }

				$.ajax({
					url: 'http://localhost/TrabApi/backend/criarArtigo',
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('user_token_jwt')
                    },
                        data: {'titulo' : titulo, 'descricao': descricao, 'link' : link}		
				});
                document.getElementById('criarArtigoForm').reset();
                document.getElementById('mensagem').innerText = 'Artigo criado com sucesso!';
            });
    </script>
</body>
</html>