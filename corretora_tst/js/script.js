document.addEventListener('DOMContentLoaded', function() {
    let editId = null;

    // Função para validar e enviar o formulário usando JavaScript
    document.getElementById('corretorForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const cpf = document.getElementById('cpf').value;
        const creci = document.getElementById('creci').value;
        const nome = document.getElementById('nome').value;

        if (cpf.length !== 11) {
            alert('O CPF deve ter 11 caracteres.');
            return;
        }
        if (creci.length < 2 || !/^\d+$/.test(creci)) {
            alert('O Creci deve ter pelo menos 2 caracteres e conter apenas números.');
            return;
        }
        if (nome.length < 2) {
            alert('O Nome deve ter pelo menos 2 caracteres.');
            return;
        }

        const url = editId ? `atualizar_corretor.php?id=${editId}` : 'processa_formulario.php';
        const method = editId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ cpf, creci, nome })
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  alert('Operação realizada com sucesso!');
                  document.getElementById('corretorForm').reset();
                  editId = null;
                  document.getElementById('formTitle').textContent = 'Cadastro de Corretores';
                  document.getElementById('submitButton').textContent = 'Enviar';
                  atualizarTabela();
              } else {
                  alert('Erro ao processar a operação.');
              }
          });
    });

    // Função para atualizar a tabela com os dados dos corretores
    function atualizarTabela() {
        fetch('listar_corretores.php')
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#corretoresTable tbody');
                tbody.innerHTML = '';

                data.forEach(corretor => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${corretor.id}</td>
                        <td>${corretor.nome}</td>
                        <td>${corretor.cpf}</td>
                        <td>${corretor.creci}</td>
                        <td>
                            <button onclick="editarCorretor(${corretor.id}, '${corretor.nome}', '${corretor.cpf}', '${corretor.creci}')">Editar</button>
                            <button onclick="excluirCorretor(${corretor.id})">Excluir</button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            });
    }

    // Função para editar um corretor
    window.editarCorretor = function(id, nome, cpf, creci) {
        document.getElementById('nome').value = nome;
        document.getElementById('cpf').value = cpf;
        document.getElementById('creci').value = creci;
        editId = id;
        document.getElementById('formTitle').textContent = 'Editar Corretor';
        document.getElementById('submitButton').textContent = 'Alterar';
    }

    // Função para excluir um corretor
    window.excluirCorretor = function(id) {
        if (confirm('Tem certeza que deseja excluir este corretor?')) {
            fetch(`excluir_corretor.php?id=${id}`, { method: 'GET' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Corretor excluído com sucesso!');
                        atualizarTabela();
                    } else {
                        alert('Erro ao excluir corretor.');
                    }
                });
        }
    }

    // Chama a função para atualizar a tabela quando a página carrega
    atualizarTabela();
     
});