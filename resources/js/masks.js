// Espera que todo o conteúdo da página seja carregado antes de executar o script
document.addEventListener('DOMContentLoaded', function() {

    // --- MÁSCARA PARA O CAMPO CPF ---
    const cpfInput = document.getElementById('cpf');
    if (cpfInput) {
        cpfInput.addEventListener('input', function(e) {
            // Remove tudo o que não for dígito
            let value = e.target.value.replace(/\D/g, '');

            // Limita o tamanho para 11 dígitos (tamanho de um CPF)
            value = value.substring(0, 11);

            // Aplica a formatação 000.000.000-00
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

            e.target.value = value;
        });
    }

    // --- MÁSCARA PARA O CAMPO DE CONTATO (CELULAR) ---
    const contatoInput = document.getElementById('contato');
    if (contatoInput) {
        contatoInput.addEventListener('input', function(e) {
            // Remove tudo o que não for dígito
            let value = e.target.value.replace(/\D/g, '');

            // Limita o tamanho para 11 dígitos (tamanho de um celular com DDD)
            value = value.substring(0, 11);

            // Aplica a formatação (00) 00000-0000
            value = value.replace(/^(\d{2})(\d)/g, '($1) $2');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');

            e.target.value = value;
        });
    }

    // --- MÁSCARA PARA TELEFONE FIXO (OPCIONAL) ---
    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.substring(0, 10); // Limita para 10 dígitos (DDD + 8 ou 9 dígitos)

            value = value.replace(/^(\d{2})(\d)/g, '($1) $2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');

            e.target.value = value;
        });
    }

    // --- MÁSCARA PARA CEP ---
    const cepInput = document.getElementById('cep');
    if (cepInput) {
        cepInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.substring(0, 8); // Limita para 8 dígitos

            value = value.replace(/^(\d{5})(\d)/, '$1-$2');

            e.target.value = value;
        });
    }

});
