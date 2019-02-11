## Dao-for-PHP v1.0
Abstract class DAO for PDO/MySQL

Class heritage Example

```
class User extends DAO
{
    public function get_by_id(int $id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id';
        $this->executeGet($sql, ['id' => $id]);
    }

    public function create_user(string $name)
    {
        $sql = 'INSERT INTO users (name) VALUES (:name)';
        $this->execute($sql, ['name' => $name]);

        $this->message('User created successfully!');
    }
}
```

Get user by id example

```
$user = new User();

$user->get_by_id(1);

if ($user->result['error']) {
    $error = $user->result['data'];
} else {
    $user_obtained = $user->result['data'][0];
}
```

Create user example

```
$user = new User();

$user->create_user('John Doe');

$response = $user->result['data'];
```

#### Properties:

**public array $result**

- _$this->result['error']_
  - Boolean
- _$this->result['data']_
  - Array|String from executeGet() method
  - String from execute() method

**protected PDO $con**
- PDO MySQL connection

**protected PDO $query**
- PDO prepared statement for execution

#### Methods:

**public void execute(string $query, array $params)**

**public void executeGet(string $query, array $params)**

- _string $query_
  - SQL sentence with alias
- _array $params_
  - Assoc array with alias as key

**public void message(string $message)**

- _string $message_
  - Create custom response message after execute() method

**public void close()**

- Close MySQL connection