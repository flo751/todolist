<?php

abstract class AbstractTaskManager{

    // Ajout d’une tache
abstract public function addTask(string $task);

// Supprime la tâche en base
abstract public function delTask(int $id);

// Récupère toutes les tâches en cours
abstract public function getAllTasks();

}

class TaskManager extends AbstractTaskManager{
    protected $id; // l’identifiant unique de la tâche
    protected $name; // le nom de la tâche
    protected $dbh; // l’instance de la connexion à la base de données

    public function __construct()
    {
        $this->dbh = new Database();
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function addTask(string $task)
    {
        $stmt = $this->dbh->prepare("INSERT INTO tache (tache) VALUES (:tache)");
        $stmt->bindParam(':tache', $task);
        $stmt->execute();
    }

    public function delTask(int $id)
    {
        $stmt = $this->dbh->prepare("DELETE FROM tache WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function getAllTasks()
    {
        $sql = "SELECT * FROM tache";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $dbh = $this->dbh;
        $tasks = $stmt->fetchAll(PDO::FETCH_FUNC, function ($id, $name) {
            $task = new TaskManager($this->dbh);
            $task->setId($id);
            $task->setName($name);
            return $task;
        });
    
}}
?>