function mostrarErro(mensagem) {
  alert("Erro: " + mensagem);
}

function mostrarSucesso(mensagem) {
  alert("Sucesso: " + mensagem);
}

function confirmarAcao(mensagem) {
  return confirm(mensagem);
}

async function fazerRequisicao(url, metodo = "GET", dados = null) {
  try {
    const opcoes = {
      metodo: metodo,
      Headers: { "Content-Type": "application/json" },
    };

    if (dados) {
      opcoes.body = JSON.stringify(dados);
    }

    const resposta = await fetch(url, opcoes);

    if (!resposta.ok) {
      throw new Error("Erro na resposta do servidor");
    }
    return await resposta.json();
  } catch (error) {
    console.error("Erro na requisição: ", error);
    throw error;
  }
}

function validarCampo(campos) {
  for (const campo of campos) {
    if (!campo.value.trim()) {
      mostrarErro(`O campo ${campo.name} é obrigatório!`);
      campo.focus();
      return false;
    }
  }
  return true;
}

function limparFormulario(formulario) {
  formulario.reset();
  const campos = formulario.querySelectorAll('input[type="hidden]');
  campos.forEach((campo) => (campo.value = ""));
}
