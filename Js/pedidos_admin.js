document.addEventListener('DOMContentLoaded', function() {
    const containerPedidos = document.getElementById('container-pedidos-admin');

    function carregarPedidosAdmin() {
        fetch('buscar_todos_pedidos.php')
            .then(response => response.json())
            .then(pedidos => {
                containerPedidos.innerHTML = '';

                if (!pedidos || pedidos.length === 0) {
                    containerPedidos.innerHTML = '<p class="text-center">Nenhum pedido encontrado.</p>';
                    return;
                }

                pedidos.forEach(pedido => {
                    const data = new Date(pedido.data_pedido);
                    const dataFormatada = data.toLocaleDateString('pt-BR', { day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' });
                    const valorFormatado = parseFloat(pedido.valor_total).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

                    const itensHTML = pedido.itens.map(item => `
                        <div class="item-do-pedido">
                            <p class="item-titulo">${item.tipo} - ${item.tamanho.split(' - ')[0]}</p>
                            ${item.complementos ? `<p><small><strong>Complementos:</strong> ${item.complementos}</small></p>` : ''}
                            ${item.adicionais ? `<p><small><strong>Adicionais:</strong> ${item.adicionais}</small></p>` : ''}
                        </div>
                    `).join('');

                    // Opções para o select de status
                    const statusOptions = ['Em preparação', 'A caminho', 'Entregue', 'Cancelado']
                        .map(s => `<option value="${s}" ${s === pedido.status ? 'selected' : ''}>${s}</option>`)
                        .join('');

                    const isDisabled = pedido.status.toLowerCase() === 'cancelado' ? 'disabled' : '';

                    // --- MUDANÇA AQUI ---
                    // Trocamos a linha do endereço para usar a nova variável 'pedido.endereco_entrega'
                    const pedidoHTML = `
                        <div class="card-pedido-admin">
                            <div class="card-pedido-header">
                                <h4>Pedido #${pedido.id}</h4>
                                <span>${dataFormatada}</span>
                            </div>
                            <div class="card-pedido-body">
                                <div class="info-cliente">
                                    <p><strong>Cliente:</strong> ${pedido.nome_cliente}</p>
                                    <p><strong>Local:</strong> ${pedido.endereco_entrega}</p>
                                </div>
                                ${itensHTML}
                            </div>
                            <div class="card-pedido-footer">
                                <strong>${valorFormatado}</strong>
                                <div class="status-select-wrapper">
                                    <label for="status-${pedido.id}">Status:</label>
                                    <select id="status-${pedido.id}" class="status-select" data-pedido-id="${pedido.id}" ${isDisabled}>
                                        ${statusOptions}
                                    </select>
                                </div>
                            </div>
                        </div>
                    `;
                    // --- FIM DA MUDANÇA ---
                    containerPedidos.innerHTML += pedidoHTML;
                });
                
                adicionarListenersStatus();
            })
            .catch(error => {
                console.error('Erro ao buscar pedidos:', error);
                containerPedidos.innerHTML = '<p class="erro text-center">Ops! Falha ao carregar os pedidos.</p>';
            });
    }

    function adicionarListenersStatus() {
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                // O evento não será disparado em selects desabilitados
                const pedidoId = this.dataset.pedidoId;
                const novoStatus = this.value;
                atualizarStatus(pedidoId, novoStatus);
            });
        });
    }

    function atualizarStatus(pedidoId, novoStatus) {
        fetch('atualizar_status_pedido.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ pedido_id: pedidoId, novo_status: novoStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.sucesso) {
                console.log(data.mensagem); // Mensagem de sucesso no console
            } else {
                alert('Erro: ' + data.mensagem);
            }
        })
        .catch(error => {
            console.error('Erro ao atualizar status:', error);
            alert('Falha na comunicação com o servidor.');
        });
    }

    carregarPedidosAdmin();
});