<?php
include("../private/db_config.php");

$congregationData = $_GET['congregationData'] ?? null;

if ($congregationData) {
    $stmt = $con->prepare("SELECT `boundary`, `border_name` FROM `borders` WHERE `congregation` = ?");
    $stmt->bind_param("s", $congregationData);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($data);
    } else {
        echo json_encode(["error" => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "No congregationData provided"]);
}

$con->close();
?>
