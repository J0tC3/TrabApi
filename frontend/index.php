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
                <a class="navbar-brand text-white">Buscar Artigos</a>
            </div>
            <!-- Parte Central -->
            <div class="text-center">
                <form class="d-flex align-items-center" role="search" id="form-pesquisa">
                    <input class="form-control me-2" type="search" placeholder="Pesquisar por Título" id="titulo" name="titulo">
                    <input class="form-control me-2" type="search" placeholder="Pesquisar por Autor" id="autor" name="autor">
                    <button class="btn btn-outline-success me-2" type="submit">Pesquisar</button>
                </form>
            </div>
            <div>
                <a href="cadastrousuario.php" class="btn btn-outline-light me-2">Cadastrar</a>
                <a href="login.php" class="btn btn-outline-light">Login</a>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        <div id="container-artigos">
            <!-- Artigos serão inseridos dinamicamente aqui -->
        </div>
    </main>

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

        $('#form-pesquisa').submit(function(event) {
            event.preventDefault();

            const titulo = $('#titulo').val();
            const autor = $('#autor').val();
            let url;
            let data = {};

            if (titulo && autor) {
                url = 'http://localhost/TrabApi/backend/listarArtigoAutor';
                data = {'titulo': titulo, 'autor': autor};
            } else if (titulo) {
                url = 'http://localhost/TrabApi/backend/listarTitulo';
                data = {'titulo': titulo};
            } else if (autor) {
                url = 'http://localhost/TrabApi/backend/listarAutor';
                data = {'autor': autor};
            } else {
                alert("Informe ao menos um Titulo ou Autor para pesquisa");
                return;
            }

            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                dataType: 'json',
                success: function(response) {
                    const containerArtigos = $('#container-artigos');
                    containerArtigos.empty(); // Limpa os artigos anteriores
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
