(() => {
    const token = localStorage.getItem('user_token_jwt');

    if(token == '' || token == null) {
        window.open('./login2', '_self');
    }

    function salvarArtigo(id) {
        const inputTitulo = document.getElementById('inputTitulo');
        const inputLink = document.getElementById('inputLink');
        const inputDescricao = document.getElementById('inputDescricao');

        const titulo = inputTitulo.value;
        const link = inputLink.value;
        const descricao = inputDescricao.value;
        
        $.ajax({
            url: 'http://localhost/TrabApi/backend/editarArtigo',
            method: 'POST',
            dataType: 'json',
            headers: { 'Authorization': 'Bearer ' + token },
            data: { 'id': id, 'titulo' : titulo, 'descricao' : descricao, 'link' : link },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error('Erro ao excluir artigo:', status, error);
            }
        });
    }

    function loadModalArtigo(id, titulo, link, descricao, newArtigo = false) {
        // Cria o fundo do modal
        const modalBackground = document.createElement('div');
        modalBackground.id = 'modalBackground';

        // Cria o modal
        const modalEditarAdicionarArtigo = document.createElement('div');
        modalEditarAdicionarArtigo.id = 'modalEditarAdicionarArtigo';

        // Cria a caixa de entrada do título
        const tituloBox = document.createElement('div');
        tituloBox.className = 'inputBox';
        tituloBox.setAttribute('name', 'Titulo');
        
        const tituloLabel = document.createElement('label');
        tituloLabel.setAttribute('for', 'inputTitulo');
        tituloLabel.textContent = 'Titulo';

        const tituloInput = document.createElement('input');
        tituloInput.type = 'text';
        tituloInput.id = 'inputTitulo';

        tituloBox.appendChild(tituloLabel);
        tituloBox.appendChild(tituloInput);

        // Cria a caixa de entrada do link de download
        const linkBox = document.createElement('div');
        linkBox.className = 'inputBox';
        linkBox.setAttribute('name', 'DownloadLinkBox');
        
        const linkLabel = document.createElement('label');
        linkLabel.setAttribute('for', 'inputLink');
        linkLabel.textContent = 'Link de Download';

        const linkInput = document.createElement('input');
        linkInput.type = 'text';
        linkInput.id = 'inputLink';
        linkInput.placeholder = 'Ex: www.artigo.com/download';

        linkBox.appendChild(linkLabel);
        linkBox.appendChild(linkInput);

        // Cria a caixa de entrada da descrição
        const descricaoBox = document.createElement('div');
        descricaoBox.className = 'inputBox';
        descricaoBox.setAttribute('name', 'DownloadLinkBox');
        
        const descricaoLabel = document.createElement('label');
        descricaoLabel.setAttribute('for', 'inputDescricao');
        descricaoLabel.textContent = 'Descricao';

        const descricaoTextarea = document.createElement('textarea');
        descricaoTextarea.id = 'inputDescricao';
        descricaoTextarea.setAttribute('name', 'Descricao');
        descricaoTextarea.setAttribute('cols', '50');
        descricaoTextarea.setAttribute('maxlength', '255');

        descricaoBox.appendChild(descricaoLabel);
        descricaoBox.appendChild(descricaoTextarea);

        // Cria a caixa de botões
        const btnBox = document.createElement('div');
        btnBox.id = 'btnBox';

        const btnCancelar = document.createElement('button');
        btnCancelar.id = 'btnCancelar';
        btnCancelar.textContent = 'Cancelar';

        const btnSalvar = document.createElement('button');
        btnSalvar.id = 'btnSalvar';
        btnSalvar.textContent = 'Salvar';

        btnBox.appendChild(btnCancelar);
        btnBox.appendChild(btnSalvar);

        // Adiciona todas as partes ao modal
        modalEditarAdicionarArtigo.appendChild(tituloBox);
        modalEditarAdicionarArtigo.appendChild(linkBox);
        modalEditarAdicionarArtigo.appendChild(descricaoBox);
        modalEditarAdicionarArtigo.appendChild(btnBox);

        if(newArtigo) {
            btnSalvar.addEventListener('click', () => {
                const titulo = tituloInput.value;
                const link = linkInput.value;
                const descricao = descricaoTextarea.value;

                adicionarArtigo(titulo, descricao, link);
                renderArtigosAutor();
                modalBackground.remove();
            });
        }else {
            tituloInput.value = titulo;
            linkInput.value = link;
            descricaoTextarea.value = descricao;
            btnSalvar.addEventListener('click', () => {
                salvarArtigo(id);
                modalBackground.remove();
                renderArtigosAutor();
            })
        }

        btnCancelar.addEventListener('click', () => {
            modalBackground.remove();
        });

        // Adiciona o modal ao fundo
        modalBackground.appendChild(modalEditarAdicionarArtigo);

        // Adiciona o fundo do modal ao corpo do documento
        document.body.insertBefore(modalBackground, document.body.firstChild);
    }

    function adicionarArtigo(titulo, descricao, link) {
        const token = localStorage.getItem('user_token_jwt');

        $.ajax({
            url: 'http://localhost/TrabApi/backend/criarArtigo',
            method: 'POST',
            dataType: 'json',
            headers: { 'Authorization': 'Bearer ' + token },
            data: { 'titulo': titulo, 'descricao' : descricao, 'link' : link },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error('Erro ao adicionar artigo:', status, error);
            }
        });
    }

    function renderArtigosAutor() {
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
    }

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

        btnEditar.addEventListener('click', () => {
            loadModalArtigo(id, titulo, linkBaixar, descricao); 
        });

        // Cria o botão para excluir
        const btnExcluir = document.createElement('button');
        btnExcluir.classList.add('btnExcluir');
        btnExcluir.textContent = 'Excluir';

        btnExcluir.addEventListener('click', () => {
            deletarArtigo(id);

            renderArtigosAutor();
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

    function editarUsuario(username, passcode, email) {
        const token = localStorage.getItem('user_token_jwt');

        $.ajax({
            url: 'http://localhost/TrabApi/backend/alterUsuario',
            method: 'POST',
            dataType: 'json',
            headers: { 'Authorization': 'Bearer ' + token },
            data: { 'username': username, 'passcode': passcode, 'email': email },
            success: function(response) {
                console.log('Usuário atualizado com sucesso:', response);
            },
            error: function(xhr, status, error) {
                console.error('Erro ao atualizar usuário:', status, error);
            }
        });
    }

    function getUserData() {
        const token = localStorage.getItem('user_token_jwt');

        return new Promise((resolve, reject) => {
            $.ajax({
                url: 'http://localhost/TrabApi/backend/getUserData',
                method: 'GET',
                dataType: 'json',
                headers: { 'Authorization': 'Bearer ' + token },
                success: function(response) {
                    resolve(response);
                },
                error: function(xhr, status, error) {
                    reject(new Error('Erro ao obter dados do usuário: ' + status + ' ' + error));
                }
            });
        });
    }

    function loadModalPerfil(nome, email, senha) {
        // Criação do modal e seus elementos
        const modalBackground = document.createElement('div');
        modalBackground.id = 'modalBackground';

        const modalEditarPerfil = document.createElement('div');
        modalEditarPerfil.id = 'modalEditarPerfil';

        const inputBoxUsername = document.createElement('div');
        inputBoxUsername.className = 'inputBox';
        const labelUsername = document.createElement('label');
        labelUsername.htmlFor = 'inputUsername';
        labelUsername.textContent = 'Username';
        const inputUsername = document.createElement('input');
        inputUsername.type = 'text';
        inputUsername.id = 'inputUsername';
        inputUsername.className = 'inputsForm';
        inputBoxUsername.appendChild(labelUsername);
        inputBoxUsername.appendChild(inputUsername);

        const inputBoxEmail = document.createElement('div');
        inputBoxEmail.className = 'inputBox';
        const labelEmail = document.createElement('label');
        labelEmail.htmlFor = 'inputEmail';
        labelEmail.textContent = 'Email';
        const inputEmail = document.createElement('input');
        inputEmail.type = 'email';
        inputEmail.id = 'inputEmail';
        inputEmail.className = 'inputsForm';
        inputBoxEmail.appendChild(labelEmail);
        inputBoxEmail.appendChild(inputEmail);

        const inputBoxPassword = document.createElement('div');
        inputBoxPassword.className = 'inputBox';
        const labelPassword = document.createElement('label');
        labelPassword.htmlFor = 'inputPassword';
        labelPassword.textContent = 'Senha';
        const inputPassword = document.createElement('input');
        inputPassword.id = 'inputPassword';
        inputPassword.className = 'inputsForm';
        inputBoxPassword.appendChild(labelPassword);
        inputBoxPassword.appendChild(inputPassword);

        const btnBox = document.createElement('div');
        btnBox.id = 'btnBox';
        const btnCancelar = document.createElement('button');
        btnCancelar.id = 'btnCancelar';
        btnCancelar.textContent = 'Cancelar';
        const btnSalvar = document.createElement('button');
        btnSalvar.id = 'btnSalvar';
        btnSalvar.textContent = 'Salvar';
        btnBox.appendChild(btnCancelar);
        btnBox.appendChild(btnSalvar);

        inputUsername.value = nome;
        inputEmail.value = email;
        inputPassword.value = senha;

        btnSalvar.addEventListener('click', () => {
            const username = inputUsername.value;
            const email = inputEmail.value;
            const passcode = inputPassword.value;

            editarUsuario(username, email, passcode);
            localStorage.removeItem('user_token_jwt');
            window.open('./login2', '_self');
        });

        btnCancelar.addEventListener('click', () => {
            modalBackground.remove();
        });

        modalEditarPerfil.appendChild(inputBoxUsername);
        modalEditarPerfil.appendChild(inputBoxEmail);
        modalEditarPerfil.appendChild(inputBoxPassword);
        modalEditarPerfil.appendChild(btnBox);

        modalBackground.appendChild(modalEditarPerfil);
        document.body.insertBefore(modalBackground, document.body.firstChild);
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

    const btnAdicionar = document.getElementById('btnAdicionar');

    btnAdicionar.addEventListener('click', () => {
        loadModalArtigo(null, null, null, null, true);
    });

    const btnEditarPerfil = document.getElementById('btnEditarPerfil');

    btnEditarPerfil.addEventListener('click', () => {
        getUserData().then(userData => {
            loadModalPerfil(userData.username, userData.email, userData.passcode);
        }).catch(error => {
            console.error(error);
        });
    });

    renderArtigosAutor();
})();