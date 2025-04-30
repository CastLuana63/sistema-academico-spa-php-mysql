const formulario = document.getElementById("formularioAluno");
const tabela = document.getElementById("tabelaAlunos").querySelector("tbody");
const campoId = document.getElementById("campoId");
const campoNome = document.getElementById("campoNome");
const campoCurso = document.getElementById("campoCurso");

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
      while (campoCurso.options.length > 1) {
        campoCurso.remove(1);
      }

      dados.forEach((cursos) => {
        const opcao = document.createElement("option");
        opcao.value = cursos.IDCURSO;
        opcao.textContent = cursos.NOME;
        campoCurso.appendChild(opcao);
      });
    })
    .catch((error) => {
      console.error("Erro ao carregar cursos: ", error);
      mostrarErro("Erro ao carregar a lista de cursos: " + error.message);
    });
}

function carregarAlunos() {
  fetch("api/alunos/listarAlunos.php")
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

      dados.forEach((aluno) => {
        const linha = document.createElement("tr");
        linha.innerHTML = `
          <td>${aluno.IDALUNO}</td>
          <td>${aluno.NOME}</td>
          <td>${aluno.CURSO_NOME || "Sem Curso"}</td>
          <td>
            <button class="btn-editar" onclick='editarAluno(${
              aluno.IDALUNO
            }, ${JSON.stringify(aluno.NOME)}, ${
          aluno.IDCURSO || "null"
        })'>Editar</button>
            <button class="btn-excluir" onclick="excluirAluno(${
              aluno.IDALUNO
            })">Excluir</button>
          </td>
        `;
        tabela.appendChild(linha);
      });
    })
    .catch((error) => {
      console.error("Erro ao carregar alunos: ", error);
      mostrarErro("Erro ao carregar a lista de alunos: " + error.message);
    });
}

formulario.addEventListener("submit", (e) => {
  e.preventDefault();

  const dados = new FormData();
  dados.append("id", campoId.value);
  dados.append("nome", campoNome.value);
  dados.append("curso", campoCurso.value);

  const url = campoId.value
    ? "api/alunos/alterarAluno.php"
    : "api/alunos/inserirAlunos.php";

  fetch(url, { method: "POST", body: dados })
    .then((res) => {
      if (!res.ok) {
        throw new Error("Erro na resposta do servidor");
      }
      return res.json();
    })
    .then((retorno) => {
      if (retorno.status === "ok") {
        mostrarSucesso(retorno.mensagem);
        limparFormulario(formulario);
        carregarAlunos();
      } else {
        mostrarErro(retorno.mensagem);
      }
    })
    .catch((erro) => {
      console.error("Erro na requisição: ", erro);
      mostrarErro("Erro ao processar a requisição: " + erro.message);
    });
});

function editarAluno(id, nome, cursoId) {
  campoId.value = id;
  campoNome.value = nome;
  campoCurso.value = cursoId || "";
}

function excluirAluno(id) {
  if (confirmarAcao("Tem certeza que deseja excluir este aluno?")) {
    const dados = new FormData();
    dados.append("id", id);

    fetch("api/alunos/excluirAluno.php", {
      method: "POST",
      body: dados,
    })
      .then((res) => {
        if (!res.ok) {
          throw new Error("Erro na resposta do servidor");
        }
        return res.json();
      })
      .then((retorno) => {
        if (retorno.status === "ok") {
          mostrarSucesso(retorno.mensagem);
          carregarAlunos();
        } else {
          mostrarErro(retorno.mensagem);
        }
      })
      .catch((erro) => {
        console.error("Erro ao excluir aluno:", erro);
        mostrarErro("Erro ao excluir o aluno: " + erro.message);
      });
  }
}

carregarCursos();
carregarAlunos();
