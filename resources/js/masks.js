// Espera que todo o conteúdo da página seja carregado antes de executar o script
document.addEventListener('DOMContentLoaded', function() {

    // --- MÁSCARA PARA O CAMPO CPF ---
    const cpfInput = document.getElementById('cpf');
    if (cpfInput) {
        cpfInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.substring(0, 11);
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
            let value = e.target.value.replace(/\D/g, '');
            value = value.substring(0, 11);
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
            value = value.substring(0, 10);
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
            value = value.substring(0, 8);
            value = value.replace(/^(\d{5})(\d)/, '$1-$2');
            e.target.value = value;

            // Quando completar 8 dígitos, busca o endereço automaticamente
            if (value.replace(/\D/g, '').length === 8) {
                buscarEnderecoPorCep(value);
            }
        });
        // Também busca ao sair do campo (caso cole o CEP)
        cepInput.addEventListener('blur', function(e) {
            const cep = e.target.value.replace(/\D/g, '');
            if (cep.length === 8) buscarEnderecoPorCep(cep);
        });
    }

    // --- BUSCA AUTOMÁTICA DE ENDEREÇO (ViaCEP) ---
    function buscarEnderecoPorCep(cep) {
        cep = cep.replace(/\D/g, '');
        if (cep.length !== 8) return;

        const setVal = function(id, val) {
            const el = document.getElementById(id);
            if (el && val) el.value = val;
        };

        fetch('https://viacep.com.br/ws/' + cep + '/json/')
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data.erro) return;

                // Rua (+ bairro) no campo Endereço
                const rua = [data.logradouro, data.bairro].filter(Boolean).join(' - ');
                setVal('endereco', rua);
                setVal('cidade', data.localidade);

                // Estado (UF) — funciona com <select> ou <input>
                const estado = document.getElementById('estado');
                if (estado && data.uf) estado.value = data.uf;

                // Foca o campo Número (ou o Endereço) para o usuário completar
                const numero = document.getElementById('numero');
                if (numero) {
                    numero.focus();
                } else {
                    const end = document.getElementById('endereco');
                    if (end) { end.focus(); end.setSelectionRange(end.value.length, end.value.length); }
                }
            })
            .catch(function() { /* silencioso: se o ViaCEP falhar, o usuário digita manualmente */ });
    }

    // --- COMBINA "NÚMERO" COM O ENDEREÇO AO ENVIAR O FORMULÁRIO ---
    // (o banco guarda tudo no campo 'endereco'; o campo Número é só conveniência)
    const numeroEl = document.getElementById('numero');
    if (numeroEl) {
        const form = numeroEl.closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                const endereco = document.getElementById('endereco');
                const numero = numeroEl.value.trim();
                if (endereco && numero && !/n[ºo]\s*\d/i.test(endereco.value)) {
                    endereco.value = endereco.value.trim().replace(/[,\s]*$/, '') + ', nº ' + numero;
                }
            });
        }
    }

});
