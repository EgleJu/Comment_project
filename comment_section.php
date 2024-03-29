<?php

$connect = new PDO('mysql:host=localhost:3306;dbname:comments', 'root', '');

$error = '';
$comment_name = '';
$comment_email = '';
$comment_content = '';

//Email adress validation
if (isset($_POST["comment_email"]) == true && empty($_POST['comment_email']) == false) {
    $comment_email = $_POST['comment_email'];
    if (filter_var($comment_email, FILTER_VALIDATE_EMAIL) == false) {
        $error .= '<p class="text-danger">Email address must contain @ and "."  </p>';
    }
}

//required name
if (empty($_POST["comment_name"])) {
    $error .= '<p class="text-danger">Name is required</p>';
} else {
    $comment_name = $_POST["comment_name"];
}

//required email
if (empty($_POST["comment_email"])) {
    $error .= '<p class="text-danger">Email is required</p>';
} else {
    $comment_email = $_POST["comment_email"];
}

//required comment message
if (empty($_POST["comment_content"])) {
    $error .= '<p class="text-danger">Comment is required</p>';
} else {
    $comment_content = $_POST["comment_content"];
}

//data import to the database
if ($error == '') {
    $query = "
    INSERT INTO comments.comment
    (parent_comment_id, name, email, message)
    VALUES (:parent_comment_id, :name, :email, :message)";

    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            ':parent_comment_id' => $_POST["comment_id"],
            ':name' => $comment_name,
            ':email' => $comment_email,
            ':message' => $comment_content,
        )
    );
    $error = '<label class="text-success">Your comment is added</label>';
}

$data = array(
    'error' => $error,
);

echo json_encode($data);
