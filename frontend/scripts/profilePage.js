const token = localStorage.getItem('user_token_jwt');

if(token == '' || token == null) {
    window.open('./login2', '_self');
}

const btnLogout = document.getElementById('btnLogout');

btnLogout.addEventListener('click', () => {
    localStorage.removeItem('user_token_jwt');
    window.open('home', '_self');
});

const btnVoltar = document.getElementById('btnVoltar');

btnVoltar.addEventListener('click', () => {
    window.open('home', '_self');
});

function createArticleItem(id, titulo, autor, descricao, linkBaixar) {
    // Cria o elemento principal div
    const artigoItem = document.createElement('div');
    artigoItem.classList.add('artigoItem');

    // Cria a div artigoDetalhes
    const artigoDetalhes = document.createElement('div');
    artigoDetalhes.classList.add('artigoDetalhes');

    // Cria o título
    const tituloItem = document.createElement('h2');
    tituloItem.classList.add('tituloItem');
    tituloItem.textContent = titulo;

    // Cria o autor
    const autorItem = document.createElement('span');
    autorItem.classList.add('autorItem');
    autorItem.textContent = `${autor} - `;

    // Cria a descrição
    const descricaoItem = document.createElement('p');
    descricaoItem.classList.add('descricaoItem');
    descricaoItem.textContent = descricao;

    // Adiciona o título, autor e descrição à div artigoDetalhes
    artigoDetalhes.appendChild(tituloItem);
    artigoDetalhes.appendChild(autorItem);
    artigoDetalhes.appendChild(descricaoItem);

    // Cria o link para baixar
    const btnBaixar = document.createElement('a');
    btnBaixar.href = linkBaixar;
    btnBaixar.target = '_blank';
    btnBaixar.classList.add('btnBaixar');
    btnBaixar.textContent = 'Baixar';

    // Cria o botão para editar
    const btnEditar = document.createElement('button');
    btnEditar.classList.add('btnEditar');
    btnEditar.textContent = 'Editar';

    // Cria o botão para excluir
    const btnExcluir = document.createElement('button');
    btnExcluir.classList.add('btnExcluir');
    btnExcluir.textContent = 'Excluir';

    btnExcluir.addEventListener('click', () => {
        deletarArtigo(id);

        const userArtigos = document.getElementById('userArtigos');

        userArtigos.textContent = '';

        fetchArtigoAutor()
            .then(function(dados) {
                dados.forEach(function(artigo) {
                    createArticleItem(artigo.id, artigo.titulo, artigo.autor, artigo.descricao, artigo.link);
                });
            })
            .catch(function(error) {
                console.error('Erro ao buscar artigos:', error);
            });
    });

    // Adiciona a div artigoDetalhes, o link e os botões ao elemento principal
    artigoItem.appendChild(artigoDetalhes);
    artigoItem.appendChild(btnBaixar);
    artigoItem.appendChild(btnEditar);
    artigoItem.appendChild(btnExcluir);

    // Adiciona o artigo à div com a classe 'artigosBody'
    const userArtigos = document.querySelector('#userArtigos');
    userArtigos.appendChild(artigoItem);
}

function getNameAutor() {
    const token = localStorage.getItem('user_token_jwt');

    return new Promise((resolve, reject) => {
        $.ajax({
            url: "http://localhost/TrabApi/backend/checkauth",
            method: 'GET',
            headers: { 'Authorization': 'Bearer ' + token },
            success: function(response) {
                if (response && response.nome) {
                    resolve(response.nome);
                } else {
                    reject(new Error('Nome não encontrado na resposta.'));
                }
            },
            error: function(xhr, status, error) {
                reject(new Error('Erro: ' + status + ' ' + error));
            }
        });
    });
}

function fetchArtigoAutor() {
    return getNameAutor().then(username => {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: 'http://localhost/TrabApi/backend/listarAutor',
                method: 'GET',
                dataType: 'json',
                data: { 'autor': username },
                success: function(response) {
                    resolve(response);
                },
                error: function(xhr, status, error) {
                    reject(new Error('Erro ao buscar artigos: ' + status + ' ' + error));
                }
            });
        });
    });
}

function deletarArtigo(id) {
    const token = localStorage.getItem('user_token_jwt');

    $.ajax({
        url: 'http://localhost/TrabApi/backend/excluirArtigo',
        method: 'POST',
        dataType: 'json',
        headers: { 'Authorization': 'Bearer ' + token },
        data: { 'id': id },
        success: function(response) {
            console.log(response);
        },
        error: function(xhr, status, error) {
            console.error('Erro ao excluir artigo:', status, error);
        }
    });
}

// Uso da função fetchArtigoAutor()
fetchArtigoAutor()
    .then(function(dados) {
        dados.forEach(function(artigo) {
            createArticleItem(artigo.id, artigo.titulo, artigo.autor, artigo.descricao, artigo.link);
        });
    })
    .catch(function(error) {
        console.error('Erro ao buscar artigos:', error);
    });