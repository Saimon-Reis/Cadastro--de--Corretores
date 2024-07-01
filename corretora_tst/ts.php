<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Lcss/style.css">
    <title>Cadastro de Corretores</title>
</head>

<body>
    <section>
        <div class="container">
            <h1 id="formTitle">Cadastro de Corretores</h1>
            <form id="corretorForm">
                <div class="segunda">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" maxlength="11" required>

                <label for="creci">Creci</label>
                <input type="text" id="creci" name="creci" minlength="2" required>
                </div>
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" minlength="2" required>

                <button type="submit" id="submitButton">Enviar</button>
            </form>
        </div>
    </section>
    <section2 >
    <table id="corretoresTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Creci</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <!--inserção de dados -->
        </tbody>
    </table>
    </section>
    <script src="./js/script.js"></script>
</body>

</html>