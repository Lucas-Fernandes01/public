(function () {
  // =================================================================================
  // FUNÇÕES DE UTILIDADE
  // =================================================================================

  // fallback para casos sem data-price (mantive por segurança)
  function extrairPreco(text) {
    if (!text) return 0;
    const match = String(text).match(/R\$ *([\d.,]+)/);
    if (!match) return 0;
    let num = match[1];
    if (num.indexOf('.') > -1 && num.indexOf(',') > -1) {
      num = num.replace(/\./g, '').replace(',', '.');
    } else {
      num = num.replace(',', '.');
    }
    return parseFloat(num) || 0;
  }

  // =================================================================================
  // LÓGICA DO PEDIDO ATUAL (NOVA E INTEGRADA)
  // =================================================================================

  // Variável para armazenar o tipo de pedido selecionado (copo ou marmita)
  let tipoPedidoSelecionado = ''; 

  // Array para armazenar os itens do pedido atual (tamanho + complementos/adicionais)
  let pedidoAtual = []; 

  // Objeto para rastrear a contagem de complementos grátis por tipo (copo/marmita)
  let contagemComplementosGratis = {
      copo: 0,
      marmita: 0
  };

  // Função para atualizar o valor total do pedido atual (preview)
  function atualizarValor() {
    let total = 0;
    
    // 1. Adiciona o preço do tamanho selecionado
    const tamanhoElem = document.querySelector('input[name="tamanho"]:checked');
    if (tamanhoElem) {
      total += parseFloat(tamanhoElem.dataset.price || extrairPreco(tamanhoElem.value));
    }

    // 2. Adiciona o preço dos adicionais/complementos pagos no pedidoAtual
    pedidoAtual.forEach(item => {
        total += item.preco;
    });

    const span = document.getElementById("valorTotal");
    if (span) span.innerText = total.toFixed(2).replace('.', ',');
  }

  // Função principal chamada pelo botão '+'
  function adicionarComplemento(nome, preco, tipo) {
      // Encontra o card HTML que contém o botão clicado
      const card = event.target.closest('.complemento-card');
      
      // Cria um identificador único para o item (nome + tipo)
      const itemId = nome + '_' + tipo;
      
      // Verifica se o item já está no pedidoAtual
      const index = pedidoAtual.findIndex(item => item.id === itemId);

      if (index !== -1) {
          // SE JÁ ESTIVER NO PEDIDO (REMOVER)
          pedidoAtual.splice(index, 1);
          card.classList.remove('selecionado');
          
          if (tipo === 'complemento_gratis') {
              contagemComplementosGratis[tipoPedidoSelecionado]--;
          }
          
      } else {
          // SE NÃO ESTIVER NO PEDIDO (ADICIONAR)
          
          // 1. Regra de limite para complementos grátis
          if (tipo === 'complemento_gratis') {
              const limite = (tipoPedidoSelecionado === 'copo') ? 4 : 5;
              
              if (contagemComplementosGratis[tipoPedidoSelecionado] >= limite) {
                  alert(`Você atingiu o limite de ${limite} complementos grátis para o seu ${tipoPedidoSelecionado}.`);
                  return; // Impede a adição
              }
              contagemComplementosGratis[tipoPedidoSelecionado]++;
          }
          
          // 2. Adiciona o item
          pedidoAtual.push({
              id: itemId,
              nome: nome,
              preco: parseFloat(preco),
              tipo: tipo
          });
          
          // 3. Altera o estilo do card
          card.classList.add('selecionado');
      }
      
      // Atualiza o valor total do preview
      atualizarValor();
  }

  // =================================================================================
  // FUNÇÕES DE CONTROLE DE SEÇÃO (REVISADAS)
  // =================================================================================

  // mostra/esconde seções e limpa seleções visíveis
  function toggleTipo() {
    const tipo = document.getElementById("tipoPedido").value;
    document.getElementById("copoSection").style.display = tipo === "copo" ? "block" : "none";
    document.getElementById("marmitaSection").style.display = tipo === "marmita" ? "block" : "none";
    
    tipoPedidoSelecionado = tipo; // Atualiza a variável global

    // Limpa o pedido atual e a contagem de complementos grátis
    pedidoAtual = [];
    contagemComplementosGratis = { copo: 0, marmita: 0 };

    // Limpa a seleção visual dos cards
    document.querySelectorAll('.complemento-card').forEach(card => card.classList.remove('selecionado'));

    // Limpa a seleção de tamanho e observação
    document.querySelectorAll('input[name="tamanho"]').forEach(i => i.checked = false);
    document.querySelector('textarea[name="observacao"]').value = "";
    
    // Atualiza o preview do valor
    atualizarValor();
  }

  // =================================================================================
  // CARRINHO E FUNÇÕES RELACIONADAS (REVISADAS)
  // =================================================================================

  let carrinho = []; // Carrinho de pedidos finalizados

  function adicionarPedido() {
    const tipo = document.getElementById("tipoPedido").value;
    const tamanhoElem = document.querySelector('input[name="tamanho"]:checked');
    
    if (!tipo || !tamanhoElem) {
      alert("Selecione o tipo e o tamanho antes de adicionar ao carrinho!");
      return;
    }

    // Os complementos e adicionais agora vêm do array pedidoAtual
    const complementos = pedidoAtual.filter(item => item.tipo === 'complemento_gratis').map(item => item.nome);
    const adicionais = pedidoAtual.filter(item => item.tipo === 'adicional_pago').map(item => item.nome);
    
    const entrega = document.querySelector('select[name="entrega"]').value;
    const observacao = document.querySelector('textarea[name="observacao"]').value;

    let enderecoCompleto = null;
    let cep = null; 
    if (entrega === 'Delivery') {
        const enderecoElem = document.querySelector('input[name="endereco_id"]:checked');
        if (enderecoElem) {
            enderecoCompleto = enderecoElem.parentElement.innerText.trim();
            cep = enderecoElem.dataset.cep; 
        } else {
            alert("Por favor, selecione um endereço para a entrega!");
            return;
        }
    }

    // Calcula o valor total do pedido atual
    let valorPedido = parseFloat(document.getElementById("valorTotal").innerText.replace(',', '.'));

    const pedido = {
      tipo,
      tamanho: tamanhoElem.value,
      complementos,
      adicionais: adicionais.map(a => a), // Mapeia apenas os nomes
      entrega,
      enderecoCompleto: enderecoCompleto,
      cep: cep, 
      observacao,
      valor: Number(valorPedido.toFixed(2))
    };

    carrinho.push(pedido);
    atualizarCarrinhoUI();
    limparFormulario();
  }

  function atualizarCarrinhoUI() {
    const carrinhoDiv = document.getElementById("carrinho");
    if (!carrinhoDiv) return;
    carrinhoDiv.innerHTML = "";

    let total = 0;
    carrinho.forEach((pedido, index) => {
      total += pedido.valor;
      const div = document.createElement("div");
      div.innerHTML = `
        <b>Pedido ${index + 1}</b>:<br>
        1x ${pedido.tipo} (${pedido.tamanho}) - R$ ${pedido.valor.toFixed(2).replace('.', ',')}<br>
        Complementos: ${pedido.complementos.length ? pedido.complementos.join(", ") : "Nenhum"}<br>
        Adicionais: ${pedido.adicionais.length ? pedido.adicionais.join(", ") : "Nenhum"}<br>
        Entrega: ${pedido.entrega} | Observações: ${pedido.observacao || "Nenhuma"}
        <hr>
      `;
      carrinhoDiv.appendChild(div);
    });

    const spanTotalPagar = document.getElementById("valorTotalPagar");
    if (spanTotalPagar) spanTotalPagar.innerText = total.toFixed(2).replace('.', ',');
  }

  function limparFormulario() {
    document.getElementById("tipoPedido").value = "";
    document.getElementById("copoSection").style.display = "none";
    document.getElementById("marmitaSection").style.display = "none";
    
    // Limpa o pedido atual e a contagem de complementos grátis
    pedidoAtual = [];
    contagemComplementosGratis = { copo: 0, marmita: 0 };
    document.querySelectorAll('.complemento-card').forEach(card => card.classList.remove('selecionado'));

    // Limpa a seleção de tamanho e observação
    document.querySelectorAll('input[name="tamanho"]').forEach(i => i.checked = false);
    document.querySelector('textarea[name="observacao"]').value = "";
    
    // Limpa o preview do valor
    atualizarValor();
  }

  function finalizarPedidos() {
    if (carrinho.length === 0) {
      alert("Adicione pelo menos um pedido antes de finalizar!");
      return;
    }

    if (!isLoggedIn) {
      alert("É necessário fazer login para finalizar o seu pedido.");
      window.location.href = 'login_form.php?redirect_url=' + window.location.pathname.split('/').pop();
      return;
    }

    fetch('salvar_pedido.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(carrinho)
    })
    .then(response => {
        return response.json().then(data => {
            if (!response.ok) {
                throw new Error(data.mensagem || 'Erro desconhecido do servidor.');
            }
            return data;
        });
    })
    .then(data => {
        console.log(data.mensagem);
        
        let mensagem = `🍨 *Meu pedido Açaí da Suíça*\n\n`;

        carrinho.forEach((pedido, index) => {
            mensagem += `*Item ${index + 1}*\n`;
            mensagem += `- Tipo: ${pedido.tipo}\n`;
            mensagem += `- Tamanho: ${pedido.tamanho}\n`;
            if (pedido.complementos.length > 0) {
                mensagem += `- Complementos: ${pedido.complementos.join(", ")}\n`;
            }
            if (pedido.adicionais.length > 0) {
                mensagem += `- Adicionais: ${pedido.adicionais.join(", ")}\n`;
            }
            
            if (pedido.entrega === 'Delivery' && pedido.enderecoCompleto) {
                mensagem += `- Entrega: *Endereço de Entrega:*\n${pedido.enderecoCompleto} - ${pedido.cep || ''}\n`;
            } else {
                mensagem += `- Entrega: Retirar na loja\n`;
            }

            if (pedido.observacao) {
                mensagem += `- Observações: ${pedido.observacao}\n`;
            }
            mensagem += `*Subtotal: R$ ${pedido.valor.toFixed(2)}*\n\n`;
        });
        
        const totalPagar = carrinho.reduce((acc, pedido) => acc + pedido.valor, 0);
        mensagem += `*TOTAL GERAL: R$ ${totalPagar.toFixed(2)}*`;

        const numeroWhatsApp = "5519999510173";
        const link = `https://wa.me/${numeroWhatsApp}?text=${encodeURIComponent(mensagem)}`;
        
        window.open(link, "_blank");
        carrinho = [];
        atualizarCarrinhoUI();
    })
    .catch(error => {
        console.error('Erro ao finalizar o pedido:', error);
        alert('Falha ao salvar o pedido no nosso sistema. Por favor, tente novamente.\n\nDetalhe: ' + error.message);
    });
  }

  // eventos iniciais
  document.addEventListener("DOMContentLoaded", () => {
    // Eventos para Tamanho (Radio) - Apenas para atualizar o valor
    document.querySelectorAll('input[name="tamanho"]').forEach(elem => {
      elem.addEventListener("change", atualizarValor);
    });

    // REMOVIDO: Eventos para Adicionais e Complementos (Checkbox)
    // Eles agora são gerenciados pela função adicionarComplemento() e pelo botão '+'

    if (document.getElementById("valorTotal")) document.getElementById("valorTotal").innerText = "0,00";
    if (document.getElementById("valorTotalPagar")) document.getElementById("valorTotalPagar").innerText = "0,00";

    // expõe funções usadas por onclick inline
    window.toggleTipo = toggleTipo;
    window.adicionarPedido = adicionarPedido;
    window.finalizarPedidos = finalizarPedidos;
    window.adicionarComplemento = adicionarComplemento; // Nova função exposta
  });
})();
