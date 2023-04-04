<?php 

    function chargerClasse($classe)
    {require $classe . '.class.php';}
    spl_autoload_register('chargerClasse');

    
    $Database = new Database();
    $taskManager = new TaskManager();

    if (isset($_POST['creer_tache'])) {
        $task = $_POST['creer_tache'];
        $taskManager->addTask($task);
    }
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $taskManager->delTask($id);
    }
    
    $tasks = $taskManager->getAllTasks();
?>




<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="index.css" />
    <meta http-equiv="Content-Type" content="text/html ; charset=UTF-8">
    <title>Page de test PHP</title>
</head>
<body>

<link rel="stylesheet" href="index.css"/>

<!-- On crée le formulaire permettant d'ajouter une tâche -->
<form class="taches_input" method="post" action="index.php">
    <input id="inserer" type="text" name="creer_tache"/>
    <button id="envoyer">Créer</button>
</form>

<!-- On affiche la liste des tâches -->
<table class="taches">
    <tr>
        <th>
            N
        </th>
        <th>
            Nom
        </th>
        <th>
            Action
        </th>
    </tr>
    <?php foreach ($tasks as $task):?>
        <tr>
            <td><?php echo $task->getId(); ?></td>
            <td><?php echo  $task->getName(); ?></td>
            <td>&emsp;&emsp;<a href="?id=<?php echo $task->getId(); ?>">x</a></td>
        </tr>
        <?php
    endforeach
    ?>
</table>
</body>
</html>