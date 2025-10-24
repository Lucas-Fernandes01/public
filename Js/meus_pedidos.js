document.addEventListener('DOMContentLoaded', function() {

    const containerPedidos = document.getElementById('container-pedidos');

    // Função para buscar e exibir os pedidos
    function carregarPedidos() {
        fetch('buscar_pedidos.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Falha na rede ou erro do servidor.');
                }
                return response.json();
            })
            .then(pedidos => {
                containerPedidos.innerHTML = ''; // Limpa a mensagem "Carregando..."

                if (pedidos.erro) {
                    containerPedidos.innerHTML = `<p class="erro">${pedidos.erro}</p>`;
                    return;
                }

                if (!pedidos || pedidos.length === 0) {
                    containerPedidos.innerHTML = '<div class="alert alert-info text-center">Você ainda não fez nenhum pedido. Que tal um açaí agora? 😉</div>';
                    return;
                }

                pedidos.forEach(pedido => {
                    const data = new Date(pedido.data_pedido);
                    const dataFormatada = data.toLocaleDateString('pt-BR', {
                        day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
                    });

                    const valorFormatado = parseFloat(pedido.valor_total).toLocaleString('pt-BR', {
                        style: 'currency', currency: 'BRL'
                    });
                    
                    let itensHTML = pedido.itens.map(item => `
                        <div class="item-do-pedido">
                            <p class="item-titulo">${item.tipo} - ${item.tamanho.split(' - ')[0]}</p>
                            ${item.complementos ? `<p><small><strong>Complementos:</strong> ${item.complementos}</small></p>` : ''}
                            ${item.adicionais ? `<p><small><strong>Adicionais:</strong> ${item.adicionais}</small></p>` : ''}
                            <p class="item-subtotal">Subtotal: ${parseFloat(item.valor_item).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL'})}</p>
                        </div>
                    `).join('');

                    // Define a classe CSS para a cor do status
                    let statusClass = '';
                    switch (pedido.status.toLowerCase()) {
                        case 'cancelado': statusClass = 'status-cancelado'; break;
                        case 'entregue': statusClass = 'status-entregue'; break;
                        case 'a caminho': statusClass = 'status-caminho'; break;
                        default: statusClass = 'status-preparacao';
                    }

                    const lixeiraAtivaHTML = `
                        <a href="#" class="btn-cancelar" data-pedido-id="${pedido.id}" title="Cancelar Pedido">
                            <i class="fas fa-trash-alt"></i>
                        </a>`;
                    
                    const lixeiraDesativadaHTML = `
                        <a class="btn-cancelar disabled" title="Este pedido não pode mais ser cancelado">
                            <i class="fas fa-trash-alt"></i>
                        </a>`;

                    const pedidoHTML = `
                        <div class="card-pedido">
                            <div class="card-pedido-header">
                                <div>
                                    <h4>Pedido #${pedido.id}</h4>
                                    <span>${dataFormatada}</span>
                                </div>
                                <div class="status ${statusClass}">${pedido.status}</div>
                            </div>
                            <div class="card-pedido-body">${itensHTML}</div>
                            <div class="card-pedido-footer">
                                <strong>VALOR TOTAL: ${valorFormatado}</strong>
                                ${pedido.status.toLowerCase() === 'em preparação' ? lixeiraAtivaHTML : lixeiraDesativadaHTML}
                            </div>
                        </div>
                    `;

                    containerPedidos.innerHTML += pedidoHTML;
                });
                
                adicionarListenersCancelar();
            })
            .catch(error => {
                console.error('Erro ao buscar os pedidos:', error);
                containerPedidos.innerHTML = '<div class="alert alert-danger text-center">Ops! Não conseguimos carregar seu histórico. Tente recarregar a página.</div>';
            });
    }

    function adicionarListenersCancelar() {
        document.querySelectorAll('.btn-cancelar:not(.disabled)').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const pedidoId = this.dataset.pedidoId;
                
                if (confirm(`Tem certeza que deseja cancelar o pedido #${pedidoId}?`)) {
                    cancelarPedido(pedidoId);
                }
            });
        });
    }

    function cancelarPedido(pedidoId) {
        fetch('cancelar_pedido.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ pedido_id: pedidoId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.sucesso) {
                alert(data.mensagem);
                carregarPedidos();
            } else {
                alert('Erro: ' + data.mensagem);
            }
        })
        .catch(error => {
            console.error('Erro ao cancelar pedido:', error);
            alert('Não foi possível se comunicar com o servidor para cancelar o pedido.');
        });
    }

    carregarPedidos();
});