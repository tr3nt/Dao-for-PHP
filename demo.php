<?php

require_once 'DAO.php';

// Your own class
// Tu clase propia
class UserDao extends DAO
{
    public function get_user($id)
    {
        $this->query = $this->con->prepare("SELECT * FROM users WHERE id = '{$id}'");
        // void equals 'false' to return user data from query
        // void igual a 'false' indica que devuelva los datos de user
        $this->execute(false);
    }
    public function save_user($name)
    {
        $this->query = $this->con->prepare("INSERT INTO users (name) VALUES ('{$name}')");
        $this->execute();
        // Set custom message to display if not errors, on result['data']
        // Crear mensaje personalizado que se mostrará si no hay errores, en result['data']
        $this->set_msj('User saved successfully!');
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