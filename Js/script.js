// Atualiza o valor total do pedido
//
document.addEventListener("DOMContentLoaded", () => {
  // Atualiza o valor quando mudar algo
  document
    .querySelectorAll('input[name="tamanho"], input[name="adicionais"]')
    .forEach((elem) => {
      elem.addEventListener("change", atualizarValor);
    });
});

function atualizarValor() {
  let total = 0;

  // Tamanho (pega o número depois do R$ e transforma em float)
  const tamanho = document.querySelector('input[name="tamanho"]:checked');
  if (tamanho) {
    total += parseFloat(tamanho.value.split("R$")[1].replace(",", "."));
  }

  // Adicionais pagos
  document
    .querySelectorAll('input[name="adicionais"]:checked')
    .forEach((ad) => {
      total += parseFloat(ad.value.split("R$")[1].replace(",", "."));
    });

  document.getElementById("valorTotal").innerText = total.toFixed(2);
}

//
// efeito na header
window.addEventListener("scroll", function () {
  const header = document.querySelector("header");
  header.style.boxShadow =
    window.scrollY > 10
      ? "0 2px 20px rgba(0, 0, 0, 0.15)"
      : "0 2px 10px rgba(0, 0, 0, 0.1)";
});

/* Cardapio */
//
//alternar as seções automaticamente
function toggleTipo() {
  const tipo = document.getElementById("tipoPedido").value;
  document.getElementById("copoSection").style.display =
    tipo === "copo" ? "block" : "none";
  document.getElementById("marmitaSection").style.display =
    tipo === "marmita" ? "block" : "none";

  // Limpa complementos ao trocar tipo
  document
    .querySelectorAll('input[name="complementos"]')
    .forEach((input) => (input.checked = false));
  document
    .querySelectorAll('input[name="tamanho"]')
    .forEach((input) => (input.checked = false));
  document
    .querySelectorAll('input[name="adicionais"]')
    .forEach((input) => (input.checked = false));

  document.querySelector('textarea[name="observacao"]').value = "";
  document.getElementById("valorTotal").innerText = "0.00";
}

//
// Limita a seleção de complementos grátis a 5 para marmitas e 4 para copos
//
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll('input[name="complementos"]').forEach((input) => {
    input.addEventListener("change", limitarComplementos);
  });
});

function limitarComplementos() {
  const tipo = document.getElementById("tipoPedido").value;
  const limite = tipo === "marmita" ? 5 : 4;

  const selecionados = Array.from(
    document.querySelectorAll('input[name="complementos"]:checked')
  );

  if (selecionados.length > limite) {
    this.checked = false;
    alert(
      `Você pode escolher no máximo ${limite} complementos grátis para ${tipo}.`
    );
  }
}

// Carrinho de pedidos

let carrinho = [];

function adicionarPedido() {
  // Monta um pedido atual
  const tipo = document.getElementById("tipoPedido").value;
  const tamanho = document.querySelector('input[name="tamanho"]:checked');
  const complementos = Array.from(
    document.querySelectorAll('input[name="complementos"]:checked')
  ).map((c) => c.value);
  const adicionais = Array.from(
    document.querySelectorAll('input[name="adicionais"]:checked')
  ).map((a) => a.value);
  const entrega = document.querySelector('select[name="entrega"]').value;
  const observacao = document.querySelector(
    'textarea[name="observacao"]'
  ).value;

  if (!tipo || !tamanho) {
    alert("Selecione o tipo e o tamanho antes de adicionar ao carrinho!");
    return;
  }

  const pedido = {
    tipo,
    tamanho: tamanho.value,
    complementos,
    adicionais,
    entrega,
    observacao,
  };

  carrinho.push(pedido);
  atualizarCarrinhoUI();
  limparFormulario(); // limpa as seleções pra adicionar um novo pedido
}

function atualizarCarrinhoUI() {
  const carrinhoDiv = document.getElementById("carrinho");
  carrinhoDiv.innerHTML = "";

  carrinho.forEach((pedido, index) => {
    const div = document.createElement("div");
    div.innerHTML = `
      <b>Pedido ${index + 1}</b>:<br>
      1x ${pedido.tipo} (${pedido.tamanho})<br>
      Complementos: ${
        pedido.complementos.length ? pedido.complementos.join(", ") : "Nenhum"
      }<br>
      Adicionais: ${
        pedido.adicionais.length ? pedido.adicionais.join(", ") : "Nenhum"
      }<br>
      Entrega: ${pedido.entrega} | Observações: ${
      pedido.observacao || "Nenhuma"
    }
      <hr>
    `;
    carrinhoDiv.appendChild(div);
  });
}

function limparFormulario() {
  document.getElementById("tipoPedido").value = "";
  document.getElementById("copoSection").style.display = "none";
  document.getElementById("marmitaSection").style.display = "none";
  document
    .querySelectorAll(
      'input[name="tamanho"], input[name="complementos"], input[name="adicionais"]'
    )
    .forEach((input) => (input.checked = false));
  document.querySelector('textarea[name="observacao"]').value = "";
  document.getElementById("valorTotal").innerText = "0.00";
}

//
//Finalizar pedidos
//
function finalizarPedidos() {
  if (carrinho.length === 0) {
    alert("Adicione pelo menos um pedido antes de finalizar!");
    return;
  }

  if (!isLoggedIn) {
    alert("É necessário fazer login para finalizar o seu pedido.");
    // MUDANÇA AQUI: Adicionamos o "?redirect_url=cardapio.php"
    window.location.href = 'login_form.php?redirect_url=cardapio.php'; 
    return;
  }

  // O código abaixo só será executado se o usuário estiver logado
  let mensagem = `🍨 *Meu pedido Açaí da Suíça*\n\n`;
  carrinho.forEach((pedido, index) => {
    mensagem += `*Pedido ${index + 1}*\n`;
    mensagem += `Tipo: ${pedido.tipo}\n`;
    mensagem += `Tamanho: ${pedido.tamanho}\n`;
    mensagem += `Complementos: ${
      pedido.complementos.length ? pedido.complementos.join(", ") : "Nenhum"
    }\n`;
    mensagem += `Adicionais: ${
      pedido.adicionais.length ? pedido.adicionais.join(", ") : "Nenhum"
    }\n`;
    mensagem += `Entrega: ${pedido.entrega}\n`;
    mensagem += `Observações: ${pedido.observacao || "Nenhuma"}\n\n`;
  });

  const numeroWhatsApp = "5519982370199";
  const link = `https://wa.me/${numeroWhatsApp}?text=${encodeURIComponent(
    mensagem
  )}`;
  window.open(link, "_blank");
}