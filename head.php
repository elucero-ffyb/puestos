<?php
header("Content-Type: text/html;charset=utf-8");
//session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <link href="css/all.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme-min.css" rel="stylesheet">
    <link href="css/estilosxx.css" rel="stylesheet">
    <link href="css/estilosH.css" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
    <script type="text/javascript" src="js/jquery.3.4.1.min.js"></script>
    <script type="text/javascript" src="js/tether.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

    <title>Acceso puestos de trabajo</title>
    <style>
        .form-inline .form-group {
            display: block;
        }

        .col-md-8 {
            max-width: 99.99%;
        }

        #filtrar {
            width: -moz-available;
        }
        .btn-group-sm > .btn, .btn-sm{
            background-color: silver;
        }
        #fz a.btn{
            color: #fff;
            background-color: #0275d8;
            border-color: #0275d8;
            background-image: -webkit-linear-gradient(top,#428bca 0,#2d6ca2 100%);
            background-image: linear-gradient(to bottom,#428bca 0,#2d6ca2 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff428bca', endColorstr='#ff2d6ca2', GradientType=0);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            background-repeat: repeat-x;
            border-color: #2b669a;
        }
        #fz button.btn, #fz a.btn {
            width: 48%; /* Opcional: para que ambos botones tengan tamaño similar */
        }
        #Bcerrar btn {
            width: 100%; /* Opcional: para que ambos botones tengan tamaño similar */
        }

    </style>
    <style>
    .table-responsive {
        overflow-x: auto; /* Permite desplazamiento horizontal */
        -webkit-overflow-scrolling: touch; /* Mejor desplazamiento en dispositivos móviles */
    }

    table {
        width: 100%; /* Asegura que la tabla ocupe todo el ancho */
        border-collapse: collapse; /* Quita espacio entre las celdas */
        font-size: 11px; /* Tamaño de fuente para las celdas */
    }

    th, td {
        white-space: nowrap; /* Evita que el texto se divida en varias líneas */
        text-align: center; /* Centra el contenido en las celdas */
        padding: 8px; /* Espaciado interno de las celdas */
    }

    th {
        background-color: #f8f9fa; /* Color de fondo para el encabezado */
        font-weight: bold;
    }

    .card {
        overflow: hidden; /* Asegura que no haya desbordamiento */
    }
    .card-header:first-child {
	    border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0; 
	    /*height: 800px;*/
    }
    #menu {
    overflow: visible !important;
    }
    select.form-control:not([size]):not([multiple]) {
        font-size: 12px;
    }
    input[type="text"] {
        font-size: 12px;
        /*width: 250px;*/
    }
    th {
            cursor: pointer;
        }
</style>

</head>

<body>