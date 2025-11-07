// Aguarda o carregamento completo do DOM
document.addEventListener('DOMContentLoaded', () => {

  /*=============== SHOW HIDE PASSWORD LOGIN ===============*/
  const passwordAccess = (loginPass, loginEye) =>{
    const input = document.getElementById(loginPass),
          iconEye = document.getElementById(loginEye)

    if (input && iconEye) { // Verifica se os elementos existem
      iconEye.addEventListener('click', () =>{
          // Change password to text
          input.type === 'password' ? input.type = 'text'
                          : input.type = 'password'

          // Icon change
          iconEye.classList.toggle('ri-eye-fill')
          iconEye.classList.toggle('ri-eye-off-fill')
      })
    }
  }
  passwordAccess('login_senha','loginPassword')

  /*=============== SHOW HIDE PASSWORD CREATE ACCOUNT ===============*/
  const passwordRegister = (loginPass, loginEye) =>{
    const input = document.getElementById(loginPass),
          iconEye = document.getElementById(loginEye)

    if (input && iconEye) { // Verifica se os elementos existem
      iconEye.addEventListener('click', () =>{
          // Change password to text
          input.type === 'password' ? input.type = 'text'
                          : input.type = 'password'

          // Icon change
          iconEye.classList.toggle('ri-eye-fill')
          iconEye.classList.toggle('ri-eye-off-fill')
      })
    }
  }
  passwordRegister('cadastro_senha','loginPasswordCreate')

  /*=============== SHOW HIDE LOGIN & CREATE ACCOUNT ===============*/
  const loginAcessRegister = document.getElementById('loginAccessRegister'),
        buttonRegister = document.getElementById('loginButtonRegister'),
        buttonAccess = document.getElementById('loginButtonAccess')

  if (loginAcessRegister && buttonRegister && buttonAccess) { // Verifica se existem
    buttonRegister.addEventListener('click', () => {
      loginAcessRegister.classList.add('active')
    })

    buttonAccess.addEventListener('click', () => {
      loginAcessRegister.classList.remove('active')
    })
  }
  
  // --- FUNÇÃO VIACEP ATUALIZADA ---
  function iniciarViaCEPCadastro() {
    const cepInput = document.getElementById('cadastro_cep');
    const enderecoInput = document.getElementById('cadastro_endereco');
    const bairroInput = document.getElementById('cadastro_bairro');
    const numeroInput = document.getElementById('cadastro_numero');
    // const cepFeedback = document.getElementById('cep_feedback'); // REMOVIDO

    // Se não estamos na página de cadastro, não faz nada
    if (!cepInput) return;

    const limparEndereco = () => {
        enderecoInput.value = '';
        bairroInput.value = '';
        // cepFeedback.textContent = ''; // REMOVIDO
        // cepFeedback.style.color = 'inherit'; // REMOVIDO
        enderecoInput.readOnly = false;
        bairroInput.readOnly = false;
    };

    const buscarCep = async () => {
        let cep = cepInput.value.replace(/\D/g, ''); // Remove não-números

        if (cep.length === 8) {
            cepInput.value = cep.substring(0, 5) + '-' + cep.substring(5);
        }

        if (cep.length !== 8) {
            limparEndereco();
            return; 
        }

        // cepFeedback.textContent = 'Buscando...'; // REMOVIDO
        // cepFeedback.style.color = '#6c757d'; // REMOVIDO
        
        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const data = await response.json();

            if (data.erro) {
                // cepFeedback.textContent = 'CEP não encontrado. Digite o endereço.'; // REMOVIDO
                // cepFeedback.style.color = '#dc3545'; // REMOVIDO
                alert('CEP não encontrado. Por favor, digite o endereço manualmente.'); // ADICIONADO
                enderecoInput.readOnly = false;
                bairroInput.readOnly = false;
                enderecoInput.value = '';
                bairroInput.value = '';
            } else {
                // cepFeedback.textContent = 'Endereço encontrado!'; // REMOVIDO
                // cepFeedback.style.color = '#198754'; // REMOVIDO
                enderecoInput.value = data.logradouro;
                bairroInput.value = data.bairro;
                enderecoInput.readOnly = true;
                bairroInput.readOnly = true;
                numeroInput.focus(); // Pula para o campo "número"
            }
        } catch (error) {
            // cepFeedback.textContent = 'Erro ao buscar o CEP. Digite o endereço.'; // REMOVIDO
            // cepFeedback.style.color = '#dc3545'; // REMOVIDO
            alert('Erro ao buscar o CEP. Por favor, digite o endereço manualmente.'); // ADICIONADO
            enderecoInput.readOnly = false;
            bairroInput.readOnly = false;
        }
    };

    cepInput.addEventListener('blur', buscarCep); // 'blur' é quando o usuário sai do campo
  }
  
  // Inicia a lógica do ViaCEP
  iniciarViaCEPCadastro();

});