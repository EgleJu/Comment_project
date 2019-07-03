<?php

$connect = new PDO('mysql:host=localhost:3306;dbname:comments', 'root', '');

$query = "
SELECT * FROM comments.comment
WHERE parent_comment_id = '0'
ORDER BY id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
$output = '';
foreach ($result as $row) {
    $output .= '
    <div class="card m-4">
        <div class="card-header"> By <b>' . $row["name"] . '</b> on <i>' . $row["date"] . '</i></div>
        <div class="card-body">' . $row["message"] . '</div>
        <div class="card-footer" align="right"><button
        type="button" class="btn btn-dark reply" id="' . $row["id"] . '">Reply</button>
        </div>
    </div>';

    $output .= get_reply_comment($connect, $row["id"]);

}

echo $output;

function get_reply_comment($connect, $parent_id = 0, $marginleft = 0)
{
    $query = "
 SELECT * FROM comments.comment WHERE parent_comment_id = '" . $parent_id . "'
 ";
    $output = '';
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $count = $statement->rowCount();
    if ($parent_id == 0) {
        $marginleft = 0;
    } else {
        $marginleft = $marginleft + 70;
    }
    if ($count > 0) {
        foreach ($result as $row) {
            $output .= '

            <div class="card" style="margin-left:' . $marginleft . 'px",>
                    <div class="card-header "> By <b>' . $row["name"] . '</b> on <i>' . $row["date"] . '</i></div>
                    <div class="card-body" >' . $row["message"] . '</div>

        </div>
   ';
            $output .= get_reply_comment($connect, $row["id"], $marginleft);
        }
    }
    return $output;
}
