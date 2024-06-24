(() => {
    let currentPage = 1;
    const articlesPerPage = 5;

    const token = localStorage.getItem('user_token_jwt');
    const btnLoginSearchBox = document.getElementById('btnLoginSearchBox');

    let btnProfile = null;
    let btnLogin = null;

    if(token == null) {
        btnLogin = document.createElement('button');

        btnLogin.id = 'btnLogin';
        btnLogin.type = 'button';
        btnLogin.textContent = 'Login';

        btnLogin.addEventListener('click', () => {
            window.open('./login', '_self');
        });

        btnLoginSearchBox.appendChild(btnLogin);
    } else {
        btnProfile = document.createElement('button');
        btnProfile.id = 'btnPerfil';
        btnProfile.type = 'button';
        btnProfile.textContent = 'Perfil';

        btnProfile.addEventListener('click', () => {
            window.open('./profilePage', '_self');
        });

        btnLoginSearchBox.appendChild(btnProfile);
    }   


    function limparArtigosBody() {
        const artigosBody = document.getElementById('artigosBody');

        artigosBody.innerHTML = '';
    }

    function criarArtigoHTML(titulo, autores, descricao, link) {

        // Cria o elemento div principal com a classe 'artigoItem'
        const artigoItem = document.createElement('div');
        artigoItem.className = 'artigoItem';

        // Cria o elemento div para os detalhes do artigo com a classe 'artigoDetalhes'
        const artigoDetalhes = document.createElement('div');
        artigoDetalhes.className = 'artigoDetalhes';

        // Cria o elemento h2 para o título do artigo com a classe 'tituloItem'
        const tituloItem = document.createElement('h2');
        tituloItem.className = 'tituloItem';
        tituloItem.textContent = titulo;

        // Cria o elemento span para os autores do artigo com a classe 'autorItem'
        const autorItem = document.createElement('span');
        autorItem.className = 'autorItem';
        autorItem.textContent = autores + ' - ';

        // Cria o elemento p para a descrição do artigo com a classe 'descricaoItem'
        const descricaoItem = document.createElement('p');
        descricaoItem.className = 'descricaoItem';
        descricaoItem.textContent = descricao;

        // Adiciona o título, autores e descrição aos detalhes do artigo
        artigoDetalhes.appendChild(tituloItem);
        artigoDetalhes.appendChild(autorItem);
        artigoDetalhes.appendChild(descricaoItem);

        // Cria o botão para baixar o artigo com a classe 'btnBaixar'
        const btnBaixar = document.createElement('a');
        btnBaixar.href = link;
        btnBaixar.target = '_blank';
        btnBaixar.className = 'btnBaixar';
        btnBaixar.textContent = 'Baixar';

        // Adiciona os detalhes do artigo e o botão ao elemento principal
        artigoItem.appendChild(artigoDetalhes);
        artigoItem.appendChild(btnBaixar);

        // Adiciona o artigo à div com a classe 'artigosBody'
        const artigosBody = document.querySelector('#artigosBody');
        artigosBody.appendChild(artigoItem);
    }

    const btnPesquisar = document.getElementById('btnPesquisar');

    function fetchArtigoAutor() {
        const titulo = $('#inputTitulo').val();
        const autor = $('#inputAutor').val();

        return new Promise(function(resolve, reject) {
            $.ajax({
                url: 'http://localhost/TrabApi/backend/listarArtigoAutor',
                method: 'GET',
                dataType: 'json',
                data: {'titulo': titulo , 'autor': autor, 'limite' : articlesPerPage, 'page' : currentPage },
                success: function(response) {
                    resolve(response);
                },
                error: function(error) {
                    reject(error);
                }
            });
        });
    }

    function fetchAndRenderArtigos() {
        fetchArtigoAutor().then(function(dados) {  
            console.log(dados)
            if(dados.status != false) {
                if(dados.length > 0) {
                    limparArtigosBody();
                    dados.forEach(artigo => {
                        criarArtigoHTML(artigo.titulo, artigo.autor, artigo.descricao, artigo.link);
                    });
                    window.scrollTo(0,0); 
                }else{
                    return true;
                }
            }
        }).catch(function(error) {
            console.log('Erro ao buscar artigos:', error);
        });
    }

    btnPesquisar.addEventListener('click', () => {
        fetchAndRenderArtigos();
    });

    document.getElementById('inputTitulo').addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            fetchAndRenderArtigos();
        }
    });

    document.getElementById('inputAutor').addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            fetchAndRenderArtigos();
        }
    });

    // Evento de clique no botão de página anterior
    document.getElementById('prevPageButton').addEventListener('click', function() {
        if(currentPage == 1) return;

        const vazio = fetchAndRenderArtigos();

        if(vazio) currentPage--;
        
    });

    // Evento de clique no botão de próxima página
    document.getElementById('nextPageButton').addEventListener('click', function() {
        currentPage++;
    });
})();