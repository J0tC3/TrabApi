<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="styles/home.css">
        
        <title>BuscArtigo</title>
    </head>
    <body>
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Parte Esquerda -->
        <div>
            <a class="navbar-brand">BuscArtigo</a>
        </div>
        <!-- Parte Central -->
        <div class="text-center">
            <form class="d-flex" role="search" id="form-pesquisa">
                <input class="form-control me-2" type="search" placeholder="Pesquisar" aria-label="Pesquisar" id="titulo" name="titulo">
                <button class="btn btn-outline-success" type="submit">Pesquisar</button>
            </form>
        </div>
        <!-- Parte Direita -->
        <div>
            <button class="btn btn-outline-light me-2">Cadastrar</button>
            <button class="btn btn-outline-light">Login</button>
        </div>
    </div>
</nav>

        
        <main class="container mt-4">
            <div id="container-artigos">
                <!-- Artigos serão inseridos dinamicamente aqui -->
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
            $(document).ready(function() {
                $.ajax({
                    url: 'http://localhost/TrabApi/backend/listarTudo',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        const containerArtigos = $('#container-artigos');
                        response.forEach(artigo => {
                            const elementoArtigo = `
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="card-title">${artigo.titulo}</h2>
                                        <h6 class="card-subtitle mb-2 text-muted">por ${artigo.autor}</h6>
                                        <p class="card-text">${artigo.descricao}</p>
                                        <a href="${artigo.link}" class="btn btn-primary" target="_blank">Download</a>
                                    </div>
                                </div>
                            `;
                            containerArtigos.append(elementoArtigo);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao buscar artigos:', error);
                    }
                });
            });

            $('#form-pesquisa').submit(function(event) {
                event.preventDefault();

                const titulo = $('#titulo').val();

                $.ajax({
                    url: 'http://localhost/TrabApi/backend/listarTitulo',
                    method: 'POST',
                    data: {'titulo': titulo},
                    dataType: 'json',
                    success: function(response) {
                        const containerArtigos = $('#container-artigos');
                        containerArtigos.empty(); // Limpa os artigos anteriores
                        response.forEach(artigo => {
                            const elementoArtigo = `
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="card-title">${artigo.titulo}</h2>
                                        <h6 class="card-subtitle mb-2 text-muted">por ${artigo.autor}</h6>
                                        <p class="card-text">${artigo.descricao}</p>
                                        <a href="${artigo.link}" class="btn btn-primary" target="_blank">Download</a>
                                    </div>
                                </div>
                            `;
                            containerArtigos.append(elementoArtigo);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao buscar artigos:', error);
                    }
                });
            });
        </script>
    </body>
</html>
