document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('modalEndereco');
    if (!modalElement) return;

    const modalEndereco = new bootstrap.Modal(modalElement);
    const form = modalElement.querySelector('form');
    
    const cepInput = document.getElementById('cep');
    const enderecoInput = document.getElementById('endereco');
    const bairroInput = document.getElementById('bairro');
    const numeroInput = document.getElementById('numero');
    const cepFeedback = document.getElementById('cepFeedback');

    const limparEndereco = () => {
        enderecoInput.value = '';
        bairroInput.value = '';
        cepFeedback.textContent = '';
        cepFeedback.className = 'form-text';
        enderecoInput.readOnly = false;
        bairroInput.readOnly = false;
    };

    const buscarCep = async () => {
        let cep = cepInput.value.replace(/\D/g, '');

        if (cep.length !== 8) {
            limparEndereco();
            return; 
        }

        cepFeedback.textContent = 'Buscando...';
        cepFeedback.className = 'form-text text-muted';
        
        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const data = await response.json();

            if (data.erro) {
                cepFeedback.textContent = 'CEP não encontrado. Por favor, digite o endereço manualmente.';
                cepFeedback.className = 'form-text text-danger';
                enderecoInput.readOnly = false;
                bairroInput.readOnly = false;
                enderecoInput.value = '';
                bairroInput.value = '';
            } else {
                cepFeedback.textContent = 'Endereço encontrado!';
                cepFeedback.className = 'form-text text-success';
                enderecoInput.value = data.logradouro;
                bairroInput.value = data.bairro;
                enderecoInput.readOnly = true;
                bairroInput.readOnly = true;
                numeroInput.focus();
            }
        } catch (error) {
            cepFeedback.textContent = 'Erro ao buscar o CEP. Digite o endereço manualmente.';
            cepFeedback.className = 'form-text text-danger';
            enderecoInput.readOnly = false;
            bairroInput.readOnly = false;
        }
    };

    cepInput.addEventListener('blur', buscarCep);

    window.editarEndereco = function(endereco) {
        form.reset();
        limparEndereco();
        
        document.getElementById('modalEnderecoLabel').textContent = 'Editar Endereço';
        document.getElementById('enderecoAction').value = 'edit_address';
        
        document.getElementById('enderecoId').value = endereco.id;
        cepInput.value = endereco.cep;
        bairroInput.value = endereco.bairro;
        enderecoInput.value = endereco.endereco;
        numeroInput.value = endereco.numero;
        document.getElementById('referencia').value = endereco.referencia;

        enderecoInput.readOnly = true;
        bairroInput.readOnly = true;
        
        modalEndereco.show();
    }

    modalElement.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        if (button && button.textContent.includes('Adicionar')) {
            form.reset();
            limparEndereco();
            document.getElementById('modalEnderecoLabel').textContent = 'Adicionar Novo Endereço';
            document.getElementById('enderecoAction').value = 'add_address';
            document.getElementById('enderecoId').value = '';
        }
    });
});