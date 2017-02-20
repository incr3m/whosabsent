<?php include 'controller/session.php'; ?>
<?php 

$myCon = createSQLCon();

if ($result = $myCon->query("SELECT username FROM Account LIMIT 10")) {
    printf("Select returned %d rows.\n", $result->num_rows);

    /* free result set */
    $result->close();
}

?>