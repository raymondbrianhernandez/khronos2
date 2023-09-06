<?php

include ( 'db.php' );
include ( 'debug.php' );

/* SQL QUERIES */
$sql_elders     = "SELECT first_name, last_name FROM publishers WHERE privilege='elder'";
$sql_servants   = "SELECT first_name, last_name FROM publishers WHERE privilege='servant'";
$sql_sisters    = "SELECT first_name, last_name FROM publishers WHERE privilege='sister'";
$sql_brothers   = "SELECT first_name, last_name FROM publishers WHERE privilege='brother'";

/* ELDERS */
$result = mysqli_query ( $con, $sql_elders );
$elders = array();
if ( mysqli_num_rows ( $result ) > 0 ) {
    // output data of each row
    while ( $row = mysqli_fetch_assoc ( $result ) ) {
        $elders[] = $row;
    }
} else {
    echo "0 results";
}
echo "<pre>";
print_r ( $elders );
echo "</pre>";

/* $elders = array(
    " ", 
    "Abrenica, Rey",
    "Bagas Jr., Fernando",
    "Bongato, Sal",
    "Dizon, Jun",
    "Fernando Bagas Jr.",
    "Gavino, Nelson",
    "Gutierrez, Jed",
    "Hernandez, Carlos",
    "Josue II, Antonio",
    "Limuel Torres",
    "Mendoza Jr., Constancio",
    "Torres, Limuel"
); */

$elders = array(
    " ",
    "Antonio Josue II",
    "Carlos Hernandez",
    "Constancio Mendoza Jr.",
    "Fernando Bagas Jr.",
    "Jed Gutierrez",
    "Jun Dizon",
    "Limuel Torres",
    "Nelson Gavino",
    "Rey Abrenica",
    "Sal Bongato"
);

$publishers = array(
    " ",
    "--ELDERS--",
    "CHAIRMAN", 
    "Antonio Josue II",
    "Carlos Hernandez",
    "Constancio Mendoza Jr.",
    "Fernando Bagas Jr.",
    "Jed Gutierrez",
    "Jun Dizon",
    "Limuel Torres",
    "Nelson Gavino",
    "Rey Abrenica",
    "Sal Bongato",
    " ", 
    "--SERVANTS--",
    "Jeremy Villavicente",
    "Joseph Villavicente",
    "Marte Bustamante",
    "Mario Sebastian",
    "Noli Sampang",
    "Raymond Hernandez",
    "Ric Abueg",
    "Rosario Talvo",
    " ", 
    "--BROTHERS--", 
    "Benjamin Abrenica",
    "Daniel Yabut",
    "Joey Villavicente",
    "Ivan Soto",
    "Norman Gavino",
    "Robin Obidos",
    "Socrates Roxas",
    "Timothy Abrenica",
    "Xian Roxas",
    " ", 
    "--SISTERS--", 
    "Abrenica, Annie",
    "Abrenica, Kathleen Clair",
    "Abrenica, Miles",
    "Abueg, Josephine",
    "Bagas, Sony",
    "Bernardo, Rosalyn",
    "Bustamante, Teresita",
    "Cabuco, Eunice",
    "Caparros, Divinia",
    "Dizon, Cresencia",
    "Dizon, Lourdes",
    "Dizon, Marylou",
    "Domingo, Marieta",
    "Fernandez, Gloria",
    "Galindo, Josephine",
    "Gavino, Agnes",
    "Gavino, Melchora",
    "Gutierrez, Charm",
    "Hernandez, Nora",
    "Josue, Cynthia",
    "Landicho, Guiliana",
    "Landicho, Ivy",
    "Lucero, Godafreda",
    "Monzon, Ester",
    "Obidos, Lyrere Ann",
    "Piefer, Mila",
    "Rebong, Ruth",
    "Roxas, Roselle",
    "Sabordo, Rosalinda",
    "Sampang, Noemi",
    "Sampang, Zhayuri",
    "Talvo, Elisa",
    "Tarranco, Celestina",
    "Torres, Amelia",
    "Villavicente, Julie",
    "Villavicente, Nelly",
    "Vargas, Aizle",
);

/* $publishers = array(
    " ",
    "--ELDERS--",
    "CHAIRMAN", 
    "Abrenica, Rey",
    "Bagas Jr., Fernando",
    "Bongato, Sal",
    "Dizon, Jun",
    "Fernando Bagas Jr.",
    "Gavino, Nelson",
    "Gutierrez, Jed",
    "Hernandez, Carlos",
    "Josue II, Antonio",
    "Limuel Torres",
    "Mendoza Jr., Constancio",
    "Torres, Limuel",
    " ", 
    "--SERVANTS--",
    "Abueg, Ric",
    "Bustamante, Marte",
    "Hernandez, Raymond",
    "Sampang, Noli",
    "Sebastian, Mario",
    "Talvo, Rosario",
    "Villavicente, Jeremy",
    "Villavicente, Joseph",
    " ", 
    "--BROTHERS--", 
    "Abrenica, Benjamin",
    "Abrenica, Timothy",
    "Gavino, Norman",
    "Obidos, Robin",
    "Roxas, Socrates",
    "Roxas, Xian",
    "Soto, Ivan",
    "Villavicente, Joey",
    "Yabut, Daniel",
    " ", 
    "--SISTERS--", 
    "Abrenica, Annie",
    "Abrenica, Benjamin",
    "Abrenica, Kathleen Clair",
    "Abrenica, Miles",
    "Abueg, Josephine",
    "Bagas, Sony",
    "Bernardo, Rosalyn",
    "Bustamante, Teresita",
    "Cabuco, Eunice",
    "Caparros, Divinia",
    "Dizon, Cresencia",
    "Dizon, Lourdes",
    "Dizon, Marylou",
    "Domingo, Marieta",
    "Fernandez, Gloria",
    "Galindo, Josephine",
    "Gavino, Agnes",
    "Gavino, Melchora",
    "Gutierrez, Charm",
    "Hernandez, Nora",
    "Josue, Cynthia",
    "Landicho, Guiliana",
    "Landicho, Ivy",
    "Lucero, Godafreda",
    "Monzon, Ester",
    "Obidos, Lyrere Ann",
    "Piefer, Mila",
    "Rebong, Ruth",
    "Roxas, Roselle",
    "Sabordo, Rosalinda",
    "Sampang, Noemi",
    "Sampang, Zhayuri",
    "Talvo, Elisa",
    "Tarranco, Celestina",
    "Torres, Amelia",
    "Villavicente, Julie",
    "Villavicente, Nelly",
    "Vargas, Aizle",
); */

?>

<!-- <select name="publishers">
    < ?php
    foreach ($publishers as $publisher) {
        echo "<option value='$publisher'>$publisher</option>";
    }
    ?>
</select> -->

<!-- 
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Agnes','Gavino');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Amelia','Torres');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Annie','Abrenica');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Aizle','Vargas');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Celestina','Tarranco');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Charm','Gutierrez');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Cresencia','Dizon');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Cynthia','Josue');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Divinia','Caparros');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Ester','Monzon');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Elisa','Talvo');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Eunice','Cabuco');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Gloria','Fernandez');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Godafreda','Lucero');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Ester','Monzon');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Lyrere Ann','Obidos');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Mila','Piefer');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Ruth','Rebong');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Roselle','Roxas');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Rosalinda','Sabordo');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Noemi','Sampang');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Zhayuri','Sampang');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Elisa','Talvo');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Celestina','Tarranco');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Amelia','Torres');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Julie','Villavicente');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Nelly','Villavicente');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','sister','Aizle','Vargas');

INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','brother','Benjamin','Abrenica');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','brother','Daniel','Yabut');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','brother','Joey','Villavicente');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','brother','Ivan','Soto');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','brother','Norman','Gavino');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','brother','Robin','Obidos');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','brother','Socrates','Roxas');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','brother','Timothy','Abrenica');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','brother','Xian','Roxas');

INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','servant','Jeremy','Villavicente');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','servant','Joseph','Villavicente');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','servant','Marte','Bustamante');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','servant','Mario','Sebastian');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','servant','Noli','Sampang');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','servant','Raymond','Hernandez');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','servant','Ric','Abueg');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','servant','Rosario','Talvo');

INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','elder','Antonio','Josue II');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','elder','Carlos','Hernandez');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','elder','Constancio','Mendoza Jr.');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','elder','Fernando','Bagas Jr.');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','elder','Jed','Gutierrez');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','elder','Jun','Dizon');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','elder','Limuel','Torres');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','elder','Nelson','Gavino');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','elder','Rey','Abrenica');
INSERT INTO `publishers`(`congregation`, `privilege`, `first_name`, `last_name`) VALUES ('Topanga Canyon Tagalog','elder','Sal','Bongato');

-->