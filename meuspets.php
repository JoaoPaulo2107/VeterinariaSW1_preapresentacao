<?php
// Incluindo o cabeçalho e o arquivo de conexão com o banco
include 'includes/header_cliente.php';
include 'includes/conexao.php';
session_start();

// Verifica se usuário está logado
if (!isset($_SESSION['usuario_id'], $_SESSION['usuario_email'])) {
    header('Location: index.php');
    exit;
}

// Busca o valor do id do usuário e guarda dentro de uma variável
$usuario_id = $_SESSION['usuario_id'];

// Busca pets do dono que tenham o id igual ao parâmetro ":id"
$sql = "SELECT * FROM animal WHERE idDono_animal = :id";
$stmt = $pdo->prepare($sql);

//Liga o parâmetro ":id" ao valor da variaável
$stmt->bindParam(':id', $usuario_id);
$stmt->execute();
//Pega todos os resultados da consulta e transforma em um array associativo
$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="meuspets-container">
    <section class="meuspets-section">

        <div class="meuspets-header">
            <h1 class="meuspets-title">Animais Cadastrados</h1>

            <button class="meuspets-btn-cadastrar" data-bs-toggle="modal" data-bs-target="#cadastroPetModal">
                Cadastrar Pets
            </button>
        </div>

        <div class="meuspets-grid">
        <!-- Para cada pet dentro do array $pets, ele cria um card. -->
        <?php foreach ($pets as $pet): ?>
            <div class="meuspets-card">
                <div class="meuspets-card-content">
                    <h5 class="meuspets-pet-name"><?= htmlspecialchars($pet['Nome']) ?></h5>
                    <p class="meuspets-pet-info">Espécie: <?= htmlspecialchars($pet['Especie']) ?></p>
                    <p class="meuspets-pet-info">Raça: <?= htmlspecialchars($pet['Raca']) ?></p>
                    <p class="meuspets-pet-info">Sexo: <?= htmlspecialchars($pet['Sexo']) ?></p>
                    <p class="meuspets-pet-info">Idade: <?= htmlspecialchars($pet['Idade']) ?></p>
                    <p class="meuspets-pet-info">Peso: <?= htmlspecialchars($pet['Peso']) ?></p>
                    <p class="meuspets-pet-info">Observação: <?= htmlspecialchars($pet['Observacao']) ?></p>

                    <!-- Botão Editar, que abre um modal -->
                    <a href="#"
                    class="meuspets-btn-editar"
                    data-bs-toggle="modal"
                    data-bs-target="#editarPetModal<?= $pet['ID_Animal'] ?>">
                    Editar
                    </a>

                    <!-- Botão Excluir, que quando clicado aparece um confirm para confirmar a exclusão do pet -->
                    <a href="crud/excluir_pet.php?id=<?= $pet['ID_Animal'] ?>"
                    class="meuspets-btn-excluir"
                    onclick="return confirm('Tem certeza que deseja excluir este pet?')">
                    Excluir
                    </a>
                </div>
            </div>

            <!-- MODAL EDITAR -->
            <div class="modal fade" id="editarPetModal<?= $pet['ID_Animal'] ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Editar Pet</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form action="crud/atualizar_pet.php" method="POST">
                            <div class="modal-body">

                                <input type="hidden" name="ID_Animal" value="<?= $pet['ID_Animal'] ?>">

                                <div class="mb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control" name="Nome" value="<?= htmlspecialchars($pet['Nome']) ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Espécie</label>
                                    <input type="text" class="form-control" name="Especie" value="<?= htmlspecialchars($pet['Especie']) ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Raça</label>
                                    <input type="text" class="form-control" name="Raca" value="<?= htmlspecialchars($pet['Raca']) ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Sexo</label>
                                    <input type="text" class="form-control" name="Sexo" value="<?= htmlspecialchars($pet['Sexo']) ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Idade</label>
                                    <input type="text" class="form-control" name="Idade" value="<?= htmlspecialchars($pet['Idade']) ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Peso</label>
                                    <input type="text" class="form-control" name="Peso" value="<?= htmlspecialchars($pet['Peso']) ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Observação</label>
                                    <input type="text" class="form-control" name="Observacao" value="<?= htmlspecialchars($pet['Observacao']) ?>">
                                </div>

                                <input type="hidden" name="idDono_animal" value="<?= $usuario_id ?>">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        <?php endforeach; ?>

        </div> <!-- .meuspets-grid -->
    </section>

<!-- MODAL CADASTRAR PET -->
<div class="modal fade" id="cadastroPetModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header" style="background-color: #3e51fa;">
                <h5 class="modal-title" style="color:white;">Cadastre um novo pet</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="crud/inserir_pet.php" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Nome do Pet</label>
                        <input type="text" class="form-control" name="Nome" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Espécie</label>
                        <select class="form-control" name="Especie" required>
                            <option value="" disabled selected>Selecione</option>
                            <option value="Cachorro">Cachorro</option>
                            <option value="Gato">Gato</option>
                            <option value="Pássaro">Pássaro/Ave</option>
                            <option value="Coelho">Coelho</option>
                            <option value="Hamster">Hamster/Rato</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Raça</label>
                        <input type="text" class="form-control" name="Raca" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Idade</label>
                        <input type="text" class="form-control" name="Idade" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Peso</label>
                        <input type="text" class="form-control" name="Peso" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sexo</label>
                        <select class="form-control" name="Sexo" required>
                            <option value="" disabled selected>Selecione</option>
                            <option value="Macho">Macho</option>
                            <option value="Fêmea">Fêmea</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Observação</label>
                        <input type="text" class="form-control" name="Observacao">
                    </div>

                    <input type="hidden" name="idDono_animal" value="<?= $usuario_id ?>">

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

</main>

<?php include 'includes/footer.php'; ?>
