document.addEventListener('DOMContentLoaded', function() {

    const containerPedidos = document.getElementById('container-pedidos');

    fetch('buscar_pedidos.php')
        .then(response => response.json())
        .then(pedidos => {
            containerPedidos.innerHTML = ''; // Limpa a mensagem "Carregando..."

            if (!pedidos || pedidos.length === 0) {
                containerPedidos.innerHTML = '<p>Você ainda não fez nenhum pedido. Que tal um açaí agora? 😉</p>';
                return;
            }

            // Loop principal: Itera sobre cada PEDIDO
            pedidos.forEach(pedido => {
                const data = new Date(pedido.data_pedido);
                const dataFormatada = data.toLocaleDateString('pt-BR', {
                    day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'
                });

                const valorFormatado = parseFloat(pedido.valor_total).toLocaleString('pt-BR', {
                    style: 'currency', currency: 'BRL'
                });

                // Cria o HTML para os itens DENTRO do pedido
                let itensHTML = '';
                if (pedido.itens && pedido.itens.length > 0) {
                    // Loop secundário: Itera sobre os ITENS de cada pedido
                    pedido.itens.forEach(item => {
                        const valorItemFormatado = parseFloat(item.valor_item).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL'});
                        itensHTML += `
                            <div class="item-do-pedido">
                                <p><strong>Item:</strong> ${item.tipo} - ${item.tamanho}</p>
                                ${item.complementos ? `<p><strong><small>Complementos: </strong>${item.complementos}</small></p>` : ''}
                                ${item.adicionais ? `<p><strong><small>Adicionais: </strong>${item.adicionais}</small></p>` : ''}
                                <p><strong>Subtotal do item:</strong> ${valorItemFormatado}</p>
                            </div>
                        `;
                    });
                } else {
                    itensHTML = '<p>Não foi possível carregar os itens deste pedido.</p>';
                }

                // Cria o card principal do PEDIDO e injeta o HTML dos itens dentro dele
                const pedidoHTML = `
                <hr>
                    <div class="card-pedido">
                        <div class="card-pedido-header">
                            <h4>Pedido ${pedido.id}</h4>
                            <span>${dataFormatada}</span>
                        </div>
                        <div class="card-pedido-body">
                            ${itensHTML}
                        </div>
                        <div class="card-pedido-footer">
                            <strong>VALOR TOTAL DO PEDIDO: ${valorFormatado}</strong>
                        </div>
                        
                    </div>
                `;

                containerPedidos.innerHTML += pedidoHTML;
            });
        })
        .catch(error => {
            console.error('Erro ao buscar os pedidos:', error);
            containerPedidos.innerHTML = '<p class="erro">Ops! Não conseguimos carregar seu histórico. Tente novamente mais tarde.</p>';
        });
});