<?php
    header("Content-type: text/css; charset: UTF-8");
?>

/* BAR GRAPH */
caption {
    padding-top: .5rem;
    padding-bottom: 5rem;
    color: #162e42;
    text-align: center;
}

.charts-css.bar.show-labels {
    --labels-size: 150px;
}

#territories.bar {
    --labels-size: 200px;
}

#territories.column {
    --labels-size: 4rem;
}

#territories tbody {
    width: 90%;
}

#territories tbody td {
    margin-inline-start: 10px;
    margin-inline-end: 20px;
    box-shadow:
    1px -1px 1px lightgrey,
    2px -2px 1px lightgrey,
    3px -3px 1px lightgrey,
    4px -4px 1px lightgrey,
    5px -5px 1px lightgrey,
    6px -6px 1px lightgrey,
    7px -7px 1px lightgrey,
    8px -8px 1px lightgrey,
    9px -9px 1px lightgrey,
    10px -10px 1px lightgrey;
}