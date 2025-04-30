const formulario = document.getElementById("formularioCurso");
const tabela = document.getElementById("tabelaCursos").querySelector("tbody");
const campoId = document.getElementById("campoId");
const campoNome = document.getElementById("campoNome");

function carregarCursos() {
  fetch("api/cursos/listarCursos.php")
    .then((res) => {
      if (!res.ok) {
        throw new Error("Erro na resposta do servidor");
      }
      return res.json();
    })
    .then((dados) => {
      if (dados.status === "erro") {
        throw new Error(dados.mensagem);
      }
      tabela.innerHTML = "";
      dados.forEach((curso) => {
        const linha = document.createElement("tr");
        linha.innerHTML = ` 
        <td>${curso.IDCURSO}</td>
        <td>${curso.NOME}</td>
        <td>
            <button class="btn-editar" onclick="editarCurso(${curso.IDCURSO},'${curso.NOME}')" >Editar</button>
            <button class="btn-excluir" onclick="excluirCurso(${curso.IDCURSO})" >Excluir</button>
        </td>`;
        tabela.appendChild(linha);
      });
    })
    .catch((error) => {
      console.error("Erro ao carregar cursos: ", error);
      mostrarErro("Erro ao carregar a lista de cursos: " + error.message);
    });
}

formulario.addEventListener("submit", (e) => {
  e.preventDefault();

  const dados = new FormData();
  dados.append("id", campoId.value);
  dados.append("nome", campoNome.value);

  const url = campoId.value
    ? "api/cursos/alterarCursos.php"
    : "api/cursos/inserirCursos.php";

  fetch(url, { method: "POST", body: dados })
    .then((res) => res.json())
    .then((retorno) => {
      if (retorno.status === "ok") {
        mostrarSucesso(retorno.mensagem);
        limparFormulario(formulario);
        carregarCursos();
      } else {
        mostrarErro(retorno.mensagem);
      }
    })
    .catch((erro) => {
      console.error("Erro na requisição:", erro);
      mostrarErro("Erro ao processar a requisição: " + erro.message);
    });
});

function editarCurso(id, nome) {
  campoId.value = id;
  campoNome.value = nome;
}

function excluirCurso(id) {
  if (confirmarAcao("Tem certeza que deseja excluir este curso?")) {
    const dados = new FormData();
    dados.append("id", id);

    fetch("api/cursos/excluirCursos.php", { method: "POST", body: dados })
      .then((res) => {
        if (!res.ok) {
          throw new Error("Erro na resposta do servidor!");
        }
        return res.json();
      })
      .then((retorno) => {
        if (retorno.status === "ok") {
          mostrarSucesso(retorno.mensagem);
          carregarCursos();
        } else {
          mostrarErro(retorno.mensagem);
        }
      })
      .catch((erro) => {
        console.error("Erro ao excluir curso:", erro);
        mostrarErro("Erro ao excluir o curso: " + erro.message);
      });
  }
}

carregarCursos();
