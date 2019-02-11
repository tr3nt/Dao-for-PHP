<?php

require_once 'DAO.php';

// Your own class
// Tu clase propia
class UserDao extends DAO
{
    public function get_user(int $id)
    {
        // If method is executeGet(), it will return result set from database
        // Si el método es executeGet(), devolverá los datos de la base de datos
        $this->executeGet("SELECT * FROM users WHERE id = :id", ['id' => $id]);
    }
    public function save_user($name)
    {
        // Use execute() method to store data and set_msj() method to create custom message
        // Usar método execute() para insertar datos y el método set_msj() para crear un mensaje
        $this->execute("INSERT INTO users (name) VALUES (:name)", ['name' => $name]);
        $this->message("User saved successfully!");
    }
}

$user = new UserDao;

// Get user with id = 1
$user->get_user(1);

if (!$user->result['error']) {
    /* If correct, print name of user. Index 0 means get first element of array response
       Si no hay error imprimir el nombre del user
       El índice 0 indica que se obtiene el primer elemento del array de respuesta */
    echo $user->result['data'][0]['name'];
}
else {
    // If error, print error message
    // Si hay error imprimir el mensaje
    echo $user->result['data'];
}

// Close MySQL connection
// Cierra la conexión a MySQL
$user->close();