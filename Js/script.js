(function () {
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

  // atualiza preview do pedido atual (valorTotal)
  function atualizarValor() {
    let total = 0;
    const tamanhoElem = document.querySelector('input[name="tamanho"]:checked');
    if (tamanhoElem) {
      total += parseFloat(tamanhoElem.dataset.price || extrairPreco(tamanhoElem.value));
    }

    document.querySelectorAll('input[name="adicionais"]:checked').forEach((adElem) => {
      total += parseFloat(adElem.dataset.price || extrairPreco(adElem.value));
    });

    const span = document.getElementById("valorTotal");
    if (span) span.innerText = total.toFixed(2);
  }

  // limita complementos grátis (4 copo / 5 marmita)
  function limitarComplementos(e) {
    const tipoSelect = document.getElementById("tipoPedido").value;
    const tipo = tipoSelect || (document.getElementById("copoSection").style.display === "block" ? "copo" : "marmita");
    const limite = tipo === "marmita" ? 5 : 4;
    const selector = tipo === "marmita" ? "#marmitaSection input[name='complementos']:checked" : "#copoSection input[name='complementos']:checked";
    const selecionados = document.querySelectorAll(selector);

    if (selecionados.length > limite) {
      if (e && e.target) e.target.checked = false;
      else this.checked = false;
      alert(`Você pode escolher no máximo ${limite} complementos grátis para ${tipo}.`);
    }
  }

  // mostra/esconde seções e limpa seleções visíveis (não zera o total acumulado)
  function toggleTipo() {
    const tipo = document.getElementById("tipoPedido").value;
    document.getElementById("copoSection").style.display = tipo === "copo" ? "block" : "none";
    document.getElementById("marmitaSection").style.display = tipo === "marmita" ? "block" : "none";

    // limpar seleções (tamanhos, complementos, adicionais) ao trocar tipo
    document.querySelectorAll('#copoSection input[name="complementos"], #marmitaSection input[name="complementos"], input[name="tamanho"], input[name="adicionais"]').forEach(i => i.checked = false);
    document.querySelector('textarea[name="observacao"]').value = "";
    const spanPreview = document.getElementById("valorTotal");
    if (spanPreview) spanPreview.innerText = "0.00";
  }

  // carrinho e funções relacionadas
  let carrinho = [];

  function adicionarPedido() {
    const tipo = document.getElementById("tipoPedido").value;
    const tamanhoElem = document.querySelector('input[name="tamanho"]:checked');
    if (!tipo || !tamanhoElem) {
      alert("Selecione o tipo e o tamanho antes de adicionar ao carrinho!");
      return;
    }

    const complementos = Array.from(document.querySelectorAll(`#${tipo}Section input[name="complementos"]:checked`)).map(c => c.value);
    const adicionaisElems = Array.from(document.querySelectorAll('input[name="adicionais"]:checked'));
    const entrega = document.querySelector('select[name="entrega"]').value;
    const observacao = document.querySelector('textarea[name="observacao"]').value;

    let valorPedido = parseFloat(tamanhoElem.dataset.price || extrairPreco(tamanhoElem.value));
    adicionaisElems.forEach(a => {
      valorPedido += parseFloat(a.dataset.price || extrairPreco(a.value));
    });

    const pedido = {
      tipo,
      tamanho: tamanhoElem.value,
      complementos,
      adicionais: adicionaisElems.map(a => a.value),
      entrega,
      observacao,
      valor: Number(valorPedido.toFixed(2))
    };

    carrinho.push(pedido);
    atualizarCarrinhoUI();
    limparFormulario(); // limpa o preview e inputs para novo pedido (não zera valorTotalPagar)
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
        1x ${pedido.tipo} (${pedido.tamanho}) - R$ ${pedido.valor.toFixed(2)}<br>
        Complementos: ${pedido.complementos.length ? pedido.complementos.join(", ") : "Nenhum"}<br>
        Adicionais: ${pedido.adicionais.length ? pedido.adicionais.join(", ") : "Nenhum"}<br>
        Entrega: ${pedido.entrega} | Observações: ${pedido.observacao || "Nenhuma"}
        <hr>
      `;
      carrinhoDiv.appendChild(div);
    });

    const spanTotalPagar = document.getElementById("valorTotalPagar");
    if (spanTotalPagar) spanTotalPagar.innerText = total.toFixed(2);
  }

  function limparFormulario() {
    document.getElementById("tipoPedido").value = "";
    document.getElementById("copoSection").style.display = "none";
    document.getElementById("marmitaSection").style.display = "none";
    document.querySelectorAll('#copoSection input, #marmitaSection input, input[name="adicionais"]').forEach(i => i.checked = false);
    document.querySelector('textarea[name="observacao"]').value = "";
    const spanPreview = document.getElementById("valorTotal");
    if (spanPreview) spanPreview.innerText = "0.00";
  }

  function finalizarPedidos() {
    if (carrinho.length === 0) {
      alert("Adicione pelo menos um pedido antes de finalizar!");
      return;
    }

    if (!isLoggedIn) {
      alert("É necessário fazer login para finalizar o seu pedido.");
      // Redireciona para o login, passando a página atual para voltar depois
      window.location.href = 'login_form.php?redirect_url=' + window.location.pathname.split('/').pop();
      return;
    }

    // 1. TENTA SALVAR O PEDIDO NO BANCO DE DADOS
    fetch('salvar_pedido.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(carrinho) // Envia o carrinho como JSON
    })
    .then(response => {
        // A resposta.json() também retorna uma promessa, então encadeamos outro .then
        return response.json().then(data => {
            if (!response.ok) {
                // Se o servidor retornou um erro (ex: 401, 500), lança um erro com a mensagem do PHP
                throw new Error(data.mensagem || 'Erro desconhecido do servidor.');
            }
            return data; // Retorna os dados de sucesso para o próximo .then
        });
    })
    .then(data => {
        // 2. SE O PEDIDO FOI SALVO COM SUCESSO, MONTA A MENSAGEM E ABRE O WHATSAPP
        console.log(data.mensagem); // "Pedido salvo com sucesso!"
        
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
            mensagem += `- Entrega: ${pedido.entrega}\n`;
            if (pedido.observacao) {
                mensagem += `- Observações: ${pedido.observacao}\n`;
            }
            mensagem += `*Subtotal: R$ ${pedido.valor.toFixed(2)}*\n\n`;
        });
        
        const totalPagar = carrinho.reduce((acc, pedido) => acc + pedido.valor, 0);
        mensagem += `*TOTAL GERAL: R$ ${totalPagar.toFixed(2)}*`;

        const numeroWhatsApp = "5519999510173"; // Use seu número
        const link = `https://wa.me/${numeroWhatsApp}?text=${encodeURIComponent(mensagem)}`;
        
        // Abre o WhatsApp e limpa o carrinho no site
        window.open(link, "_blank");
        carrinho = []; // Limpa o carrinho
        atualizarCarrinhoUI(); // Atualiza a interface
    })
    .catch(error => {
        // 3. SE FALHOU EM SALVAR, MOSTRA UM ALERTA PARA O USUÁRIO
        console.error('Erro ao finalizar o pedido:', error);
        alert('Falha ao salvar o pedido no nosso sistema. Por favor, tente novamente.\n\nDetalhe: ' + error.message);
    });
  }


  // eventos iniciais
  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('input[name="tamanho"], input[name="adicionais"]').forEach(elem => {
      elem.addEventListener("change", atualizarValor);
    });

    document.querySelectorAll('input[name="complementos"]').forEach(input => {
      input.addEventListener("change", limitarComplementos);
    });

    if (document.getElementById("valorTotal")) document.getElementById("valorTotal").innerText = "0.00";
    if (document.getElementById("valorTotalPagar")) document.getElementById("valorTotalPagar").innerText = "0.00";

    // expõe funções usadas por onclick inline
    window.toggleTipo = toggleTipo;
    window.adicionarPedido = adicionarPedido;
    window.finalizarPedidos = finalizarPedidos;
  });
})();