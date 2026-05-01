<?php
include 'db.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

// GET (todas o una)
if ($method == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $result = $conn->query("SELECT * FROM notes WHERE id=$id");
        echo json_encode($result->fetch_assoc());
    } else {
        $result = $conn->query("SELECT * FROM notes");
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode($data);
    }
}

// POST (crear)
if ($method == 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    $sql = "INSERT INTO notes (title, author, datetime, body, classification)
            VALUES ('$data->title', '$data->author', NOW(), '$data->body', '$data->classification')";

    $conn->query($sql);

    echo json_encode(["message" => "Note created"]);
}

// PUT (editar)
if ($method == 'PUT') {
    $data = json_decode(file_get_contents("php://input"));
    $id = $_GET['id'];

    $sql = "UPDATE notes SET 
        title='$data->title',
        author='$data->author',
        body='$data->body',
        classification='$data->classification'
        WHERE id=$id";

    $conn->query($sql);

    echo json_encode(["message" => "Note updated"]);
}

// DELETE (eliminar)
if ($method == 'DELETE') {
    $id = $_GET['id'];

    $conn->query("DELETE FROM notes WHERE id=$id");

    echo json_encode(["message" => "Note deleted"]);
}
?>