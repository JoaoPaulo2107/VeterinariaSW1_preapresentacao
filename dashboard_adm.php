<?php
session_start();
require_once __DIR__ . '/includes/conexao.php';

// Verifica login
if (!isset($_SESSION['usuario_id'], $_SESSION['usuario_email'])) {
    header('Location: ../index.php');
    exit;
}

include 'includes/header_adm.php';
?>

<!-- Cabeçalho -->
<header class="masthead">
    <div class="container px-5">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-6">
                <div class="mb-5 mb-lg-0 text-center text-lg-start">
                    <h1 class="display-1 lh-1 mb-3">Bem-vindo, Administrador!</h1>
                    <p class="lead fw-normal text-muted mb-5">
                        Agora você está logada. Confira e gerencie as consultas abaixo.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="assets/img/menina.png" alt="Imagem de animais" class="img-fluid">
            </div>
        </div>
    </div>
</header>

<main>
<section class="py-5">
<div class="container px-5">
<div class="row gx-5">
<div class="col-12">
<h2 class="display-6 mb-4">Consultas Pendentes</h2>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success text-center">
        <?= htmlspecialchars($_GET['msg']); ?>
    </div>
<?php endif; ?>

<?php
$sql = "SELECT 
            c.ID_consulta, 
            a.Nome AS NomeAnimal, 
            u.Nome AS NomeDono,
            u.Email, u.Telefone, u.CPF,
            a.Especie, a.Raca, a.Idade, a.Peso, a.Sexo, a.Observacao AS ObsAnimal,
            c.Procedimento, c.Data_consulta, c.Horario, c.Observacao AS ObsConsulta, c.Status
        FROM consulta c
        JOIN animal a ON c.ID_Animal = a.ID_Animal
        JOIN usuario u ON a.idDono_animal = u.ID_usuario
        ORDER BY c.Data_consulta ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="table-responsive">
<table class="table table-striped table-hover"
    style="border-radius:10px; box-shadow:0 0 10px rgba(0,0,255,0.1); overflow:hidden;">
    <thead class="table" style="background-color:blue; color:white;">
        <tr>
            <th>NOME DO DONO</th>
            <th>ANIMAL</th>
            <th>ESPÉCIE</th>
            <th>DATA</th>
            <th>HORÁRIO</th>
            <th>STATUS</th>
            <th>AÇÃO</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($consultas)): ?>
            <tr><td colspan="7" class="text-center">Nenhuma consulta cadastrada.</td></tr>
        <?php else: ?>
            <?php foreach ($consultas as $c): ?>
                <tr>
                    <td><?= htmlspecialchars($c['NomeDono']) ?></td>
                    <td><?= htmlspecialchars($c['NomeAnimal']) ?></td>
                    <td><?= htmlspecialchars($c['Especie']) ?></td>
                    <td><?= date('d/m/Y', strtotime($c['Data_consulta'])) ?></td>
                    <td><?= htmlspecialchars($c['Horario']) ?></td>
                    <td>
                        <?php if ($c['Status'] == 'Pendente'): ?>
                            <span class="badge bg-warning text-dark">Pendente</span>
                        <?php elseif ($c['Status'] == 'Aceita'): ?>
                            <span class="badge bg-success">Aceita</span>
                        <?php elseif ($c['Status'] == 'Recusada'): ?>
                            <span class="badge bg-danger">Recusada</span>
                        <?php elseif ($c['Status'] == 'Cancelada'): ?>
                            <span class="badge bg-secondary">Cancelada</span>
                        <?php else: ?>
                            <span class="badge bg-dark">Indefinido</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#detalhesModal"
                            data-id="<?= $c['ID_consulta'] ?>"
                            data-dono="<?= htmlspecialchars($c['NomeDono']) ?>"
                            data-animal="<?= htmlspecialchars($c['NomeAnimal']) ?>"
                            data-especie="<?= htmlspecialchars($c['Especie']) ?>"
                            data-raca="<?= htmlspecialchars($c['Raca']) ?>"
                            data-idade="<?= htmlspecialchars($c['Idade']) ?>"
                            data-peso="<?= htmlspecialchars($c['Peso']) ?>"
                            data-sexo="<?= htmlspecialchars($c['Sexo']) ?>"
                            data-procedimento="<?= htmlspecialchars($c['Procedimento']) ?>"
                            data-data="<?= htmlspecialchars($c['Data_consulta']) ?>"
                            data-horario="<?= htmlspecialchars($c['Horario']) ?>"
                            data-obsconsulta="<?= htmlspecialchars($c['ObsConsulta']) ?>"
                            data-obsanimal="<?= htmlspecialchars($c['ObsAnimal']) ?>"
                            data-telefone="<?= htmlspecialchars($c['Telefone']) ?>"
                            data-email="<?= htmlspecialchars($c['Email']) ?>"
                            data-cpf="<?= htmlspecialchars($c['CPF']) ?>">
                            Ver detalhes
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
</div>

</div>
</div>
</div>
</section>
</main>

<!-- MODAL DETALHES -->
<div class="modal fade" id="detalhesModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color:blue;">
        <h5 class="modal-title" style="color:white;">Detalhes da Consulta</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <h6><b>Animal:</b> <span id="det_nome_animal"></span></h6>
            <p><b>Espécie:</b> <span id="det_especie"></span></p>
            <p><b>Raça:</b> <span id="det_raca"></span></p>
            <p><b>Sexo:</b> <span id="det_sexo"></span></p>
            <p><b>Idade:</b> <span id="det_idade"></span></p>
            <p><b>Peso:</b> <span id="det_peso"></span> kg</p>
            <p><b>Observações do animal:</b> <span id="det_obsanimal"></span></p>
          </div>
          <div class="col-md-6">
            <h6><b>Dono:</b> <span id="det_nome_dono"></span></h6>
            <p><b>Telefone:</b> <span id="det_telefone"></span></p>
            <p><b>Email:</b> <span id="det_email"></span></p>
            <p><b>CPF:</b> <span id="det_cpf"></span></p>
          </div>
        </div>
        <hr>
        <p><b>Procedimento:</b> <span id="det_procedimento"></span></p>
        <p><b>Data:</b> <span id="det_data"></span></p>
        <p><b>Horário:</b> <span id="det_horario"></span></p>
        <p><b>Observações da consulta:</b> <span id="det_obsconsulta"></span></p>
      </div>
      <div class="modal-footer">
        <a id="btnAceitar" class="btn btn-success">Aceitar</a>
        <a id="btnRecusar" class="btn btn-danger">Recusar</a>
        <button class="btn btn-secondary" style="background-color:blue;" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!-- Script para preencher o modal -->
<script>
document.addEventListener("click", function(e) {
  if (e.target.matches("[data-id]")) {
    const b = e.target.dataset;
    document.getElementById("det_nome_animal").textContent = b.animal;
    document.getElementById("det_especie").textContent = b.especie;
    document.getElementById("det_raca").textContent = b.raca;
    document.getElementById("det_sexo").textContent = b.sexo;
    document.getElementById("det_idade").textContent = b.idade;
    document.getElementById("det_peso").textContent = b.peso;
    document.getElementById("det_obsanimal").textContent = b.obsanimal;

    document.getElementById("det_nome_dono").textContent = b.dono;
    document.getElementById("det_telefone").textContent = b.telefone;
    document.getElementById("det_email").textContent = b.email;
    document.getElementById("det_cpf").textContent = b.cpf;

    document.getElementById("det_procedimento").textContent = b.procedimento;
    document.getElementById("det_data").textContent = b.data;
    document.getElementById("det_horario").textContent = b.horario;
    document.getElementById("det_obsconsulta").textContent = b.obsconsulta;

    document.getElementById("btnAceitar").href = "crud/atualizar_status_consulta.php?id=" + b.id + "&acao=aceitar";
    document.getElementById("btnRecusar").href = "crud/atualizar_status_consulta.php?id=" + b.id + "&acao=recusar";
  }
});
</script>

<?php include 'includes/footer.php'; ?>
