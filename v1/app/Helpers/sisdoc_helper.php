<?php
function get($var)
{
    $vlr = '';
    if (isset($_GET[$var])) {
        $vlr = $_GET[$var];
    }
    if (isset($_POST[$var])) {
        $vlr = $_POST[$var];
    }
    //$vlr = str_replace($vlr,"'","~");
    return $vlr;
}

/* Funcao troca */
function troca($qutf, $qc, $qt)
{
    if (!is_array($qc)) {
        $qc = array($qc);
    }
    if (!is_array($qt)) {
        $qt = array($qt);
    }
    return (str_replace($qc, $qt, $qutf));
}

function pre($dt, $force = true)
{
    echo '<pre>';
    print_r($dt);
    echo '</pre>';
    if ($force) {
        exit;
    }
}
