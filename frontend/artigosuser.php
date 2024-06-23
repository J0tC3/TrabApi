<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/home.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
    <title>Pagina IniCial</title>
</head>
<body>
<nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div>
                <a class="navbar-brand text-white">Artigos do Usuário</a>
            </div>
            <div class="text-center flex-grow-1">
                <form class="d-flex align-items-center justify-content-center" role="search" id="form-pesquisa">
                    <input class="form-control me-2" type="search" placeholder="Pesquisar por Título" id="titulo" name="titulo">
                    <button class="btn btn-outline-success me-2" type="submit">Pesquisar</button>
                </form>
            </div>
            <div>
                <a href="addartigo.php" class="btn btn-outline-light me-2">Novo Artigo</a>
                <button class="btn btn-danger" id="backBtn">Voltar</button>
            </div>
        </div>
    </nav>
    <main class="container mt-4">
        <div id="container-artigos">
            <!-- Artigos serão inseridos dinamicamente aqui -->
        </div>
    </main>

    <script>
  document.getElementById("backBtn").addEventListener("click", function(){
    history.back();
  });
</script>

    <script>        
    $(document).ready(function() {
            $.ajax({
                url: 'http://localhost/TrabApi/backend/AutorLog',
                method: 'GET',
                headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('user_token_jwt')
                    },
                dataType: 'json',
                success: function(response) {
                    const containerArtigos = $('#container-artigos');
                    containerArtigos.empty();
                    if (response.length === 0) {
                        containerArtigos.append('<p>Nenhum artigo encontrado.</p>');
                    } else {
                        response.forEach(artigo => {
                            const elementoArtigo = `
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="card-title">Título: ${artigo.titulo}</h2>
                                        <h6 class="card-subtitle mb-2 text-muted">por ${artigo.autor}</h6>
                                        <p class="card-text">Descrição: ${artigo.descricao}</p>
                                        <a href="${artigo.link}" class="btn btn-primary" target="_blank">Download</a>
                                    </div>
                                </div>
                            `;
                            containerArtigos.append(elementoArtigo);
                        });
                    }
                }
            });
        });

        $('#form-pesquisa').submit(function(event) {
            event.preventDefault();

                const titulo = $('#titulo').val();
                let url;
                let data = {};

                if (titulo) {
                    url = 'http://localhost/TrabApi/backend/AutorLogTitulo';
                    data = {'titulo': titulo};
                } else {
                    alert("Informe ao menos um Título para pesquisa");
                    return;
                }

            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('user_token_jwt')
                    },
                data: data,
                dataType: 'json',
                success: function(response) {
                    const containerArtigos = $('#container-artigos');
                    containerArtigos.empty();
                    response.forEach(artigo => {
                        const elementoArtigo = `
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="card-title">Título: ${artigo.titulo}</h2>
                                    <h6 class="card-subtitle mb-2 text-muted">por ${artigo.autor}</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">Email: ${artigo.email}</h6>
                                    <p class="card-text">Descrição: ${artigo.descricao}</p>
                                    <a href="${artigo.link}" class="btn btn-primary" target="_blank">Download</a>
                                </div>
                            </div>
                        `;
                        containerArtigos.append(elementoArtigo);
                    });
                }
            });
        });
    </script>
</body>
</html>
