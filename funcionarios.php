<?php
// Inicia a sessão pra garantir que o usuário esteja logado
session_start();

// Conecta ao banco de dados
require_once __DIR__ . '/includes/conexao.php';

// Se o usuário não tiver logado, manda ele pro (login)
if (!isset($_SESSION['usuario_id'], $_SESSION['usuario_email'])) {
    header('Location: index.php');
    exit;
}

// Inclui o cabeçalho específico do administrador
include 'includes/header_adm.php';
?>

<main>
    <section class="py-5">
        <div class="container px-5">
            <div class="row gx-5">
                <div class="col-12">
                    <h2 class="display-6 mb-4">Funcionários</h2>

                    <?php if (isset($_GET['msg'])): ?>
                        <!-- Exibe uma mensagem de sucesso (ex: "Funcionário cadastrado") -->
                        <div class="alert alert-success text-center">
                            <?= htmlspecialchars($_GET['msg']); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Tabela com todos os funcionários cadastrados -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" style="border-radius:10px; box-shadow:0 0 10px rgba(0,0,255,0.1);">
                            <thead class="table" style="background-color:blue; color:white;">
                                <tr>
                                    <th>NOME</th>
                                    <th>CPF</th>
                                    <th>DATA NASC.</th>
                                    <th>SEXO</th>
                                    <th>CRMV</th>
                                    <th>EMAIL</th>
                                    <th>TELEFONE</th>
                                    <th>ESPECIALIDADE</th>
                                    <th>EDITAR</th>
                                </tr>
                            </thead>
                            <tbody>

<?php
// Busca os funcionários no banco e ordena por nome
$sql = "SELECT * FROM Funcionario ORDER BY Nome ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Se não tiver nenhum funcionário, mostra uma mensagem
if (!$dados) {
    echo '<tr><td colspan="9" class="text-center">Nenhum funcionário cadastrado.</td></tr>';
} else {
    // Caso tenha funcionários, exibe cada um na tabela
    foreach ($dados as $f) {
        echo "
        <tr>
            <td>{$f['Nome']}</td>
            <td>{$f['CPF']}</td>
            <td>" . date('d/m/Y', strtotime($f['Data_Nascimento'])) . "</td>
            <td>{$f['Sexo']}</td>
            <td>{$f['CRMV']}</td>
            <td>{$f['Email']}</td>
            <td>{$f['Telefone']}</td>
            <td>{$f['Especialidade']}</td>
            <td>
                <!-- Botão que abre o modal de edição com os dados do funcionário -->
                <button class='btn btn-warning'
                    data-bs-toggle='modal'
                    data-bs-target='#editarModal'
                    data-id='{$f['ID_veterinario']}'
                    data-cpf='{$f['CPF']}'
                    data-nome='{$f['Nome']}'
                    data-sexo='{$f['Sexo']}'
                    data-email='{$f['Email']}'
                    data-telefone='{$f['Telefone']}'
                    data-crmv='{$f['CRMV']}'
                    data-especialidade='{$f['Especialidade']}'
                    data-data='{$f['Data_Nascimento']}'>
                    Editar
                </button>
            </td>
        </tr>";
    }
}
?>

                            </tbody>
                        </table>
                    </div>

                    <!-- Botão pra abrir o modal de cadastro de novo funcionário -->
                    <div class="text-center mt-4">
                        <button class="btn btn-secondary" style="background-color:blue;" data-bs-toggle="modal" data-bs-target="#cadModal">
                            Cadastrar Funcionário
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>

<!-- Modal de Cadastro (formulário pra adicionar funcionário novo) -->
<div class="modal fade" id="cadModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:blue;">
                <h5 class="modal-title" style="color:white;">Cadastrar Funcionário</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Formulário de cadastro de funcionário -->
            <form action="crud/salvar_funcionario.php" method="POST">
                <div class="modal-body">

                    <!-- Campos divididos em linhas e colunas -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nome</label>
                            <input type="text" name="Nome" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>CPF</label>
                            <input type="text" name="CPF" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Data Nascimento</label>
                            <input type="date" name="Data_Nascimento" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Sexo</label>
                            <select name="Sexo" class="form-control">
                                <option>Masculino</option>
                                <option>Feminino</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>CRMV</label>
                            <input type="text" name="CRMV" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="Email" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Telefone</label>
                            <input type="text" name="Telefone" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Especialidade</label>
                            <input type="text" name="Especialidade" class="form-control">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <!-- Botão pra cadastrar -->
                    <button class="btn btn-success">Cadastrar</button>

                    <!-- Botão pra fechar o modal sem salvar -->
                    <button class="btn btn-secondary" style="background-color:blue;" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal pra editar os dados de um funcionário existente -->
<div class="modal fade" id="editarModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header" style="background-color:blue;">
                <h5 class="modal-title" style="color:white;">Editar Funcionário</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Formulário de edição -->
            <form action="crud/atualizar_funcionario.php" method="POST">
                <div class="modal-body">

                    <!-- Campo oculto que guarda o ID do funcionário -->
                    <input type="hidden" name="ID_veterinario" id="edit_id">

                    <!-- Campos preenchidos automaticamente quando o botão Editar é clicado -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nome</label>
                            <input type="text" id="edit_nome" name="Nome" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>CPF</label>
                            <input type="text" id="edit_cpf" name="CPF" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Data Nascimento</label>
                            <input type="date" id="edit_data" name="Data_Nascimento" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Sexo</label>
                            <select id="edit_sexo" name="Sexo" class="form-control">
                                <option>Masculino</option>
                                <option>Feminino</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>CRMV</label>
                            <input type="text" id="edit_crmv" name="CRMV" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" id="edit_email" name="Email" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Telefone</label>
                            <input type="text" id="edit_telefone" name="Telefone" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Especialidade</label>
                            <input type="text" id="edit_especialidade" name="Especialidade" class="form-control">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <!-- Botão pra salvar alterações -->
                    <button class="btn btn-success">Atualizar</button>

                    <!-- Botão pra excluir funcionário -->
                    <a id="btnExcluir" class="btn btn-danger">Excluir</a>

                    <!-- Botão pra fechar o modal -->
                    <button class="btn btn-secondary" style="background-color:blue;" data-bs-dismiss="modal">Cancelar</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- Script que preenche o modal de edição com os dados do funcionário clicado -->
<script>
document.addEventListener("click", function (e) {
    // Se o elemento clicado tiver os atributos data- (botão Editar)
    if (e.target.matches("[data-id]")) {

        // Preenche os campos do modal com as informações do funcionário
        document.getElementById("edit_id").value = e.target.dataset.id;
        document.getElementById("edit_nome").value = e.target.dataset.nome;
        document.getElementById("edit_cpf").value = e.target.dataset.cpf;
        document.getElementById("edit_data").value = e.target.dataset.data;
        document.getElementById("edit_sexo").value = e.target.dataset.sexo;
        document.getElementById("edit_crmv").value = e.target.dataset.crmv;
        document.getElementById("edit_email").value = e.target.dataset.email;
        document.getElementById("edit_telefone").value = e.target.dataset.telefone;
        document.getElementById("edit_especialidade").value = e.target.dataset.especialidade;

        // Define o link de exclusão já com o ID do funcionário
        document.getElementById("btnExcluir").href = "crud/excluir_funcionario.php?id=" + e.target.dataset.id;
    }
});
</script>

<?php 
// Fecha a página incluindo o rodapé do painel
include 'includes/footer.php'; 
?>
