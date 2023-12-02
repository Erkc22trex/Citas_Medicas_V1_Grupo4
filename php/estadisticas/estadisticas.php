<?php
include '../../php/ConexionDB.php';

$conn = new ConexionDB('localhost', 'root', '', 'gestion_de_citas');

?>

<html>

<head>
    <title>Estadisticas</title>
    <!-- Enlaces a Bootstrap y CSS personalizado -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="../styles/styles.css">
    
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            // Primera gráfica
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                <?php
                $sql = "SELECT
                    d.id_doctor,
                    CONCAT(p.nombre, ' ', p.apellido) AS nombre_completo,
                    SUM(df.precio) AS dinero_recaudado
                FROM
                    doctor d
                    JOIN persona p ON d.id_persona = p.id_persona
                    JOIN citas c ON d.id_doctor = c.id_doctor
                    JOIN facturas f ON c.id_cita = f.id_cita
                    JOIN detalle_facturas df ON f.id_factura = df.id_factura
                GROUP BY
                    d.id_doctor, nombre_completo;
                ";

                $res = $conn->hacerConsulta($sql);

                while ($tupla = mysqli_fetch_assoc($res)) {
                    echo "['" . $tupla["nombre_completo"] . "', " . $tupla["dinero_recaudado"] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Dinero recaudado por médico'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);

            // Segunda gráfica
            var data2 = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                <?php
                $sql2 = "
                SELECT
                    d.id_doctor,
                    CONCAT(p.nombre, ' ', p.apellido) AS nombre_completo,
                    COUNT(DISTINCT c.id_paciente) AS pacientes_atendidos
                FROM
                    doctor d
                    JOIN persona p ON d.id_persona = p.id_persona
                    LEFT JOIN citas c ON d.id_doctor = c.id_doctor
                GROUP BY
                    d.id_doctor, nombre_completo
                ORDER BY
                    pacientes_atendidos DESC
                LIMIT 6;
                ";

                $res2 = $conn->hacerConsulta($sql2);

                while ($tupla2 = mysqli_fetch_assoc($res2)) {
                    echo "['" . $tupla2["nombre_completo"] . "', " . $tupla2["pacientes_atendidos"] . "],";
                }
                ?>
            ]);

            var options2 = {
                title: 'Pacientes atendidos por médico',
                is3D: true,
            };

            var chart2 = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart2.draw(data2, options2);

            // Tercera gráfica
            var data3 = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                <?php
                $sql3 = "
                SELECT
                    pac.id_paciente,
                    CONCAT(p.nombre, ' ', p.apellido) AS nombre_completo,
                    COUNT(*) AS citas_canceladas
                FROM
                    paciente pac
                    JOIN persona p ON pac.id_persona = p.id_persona
                    JOIN citas c ON pac.id_paciente = c.id_paciente
                WHERE
                    c.estado = 'Cancelada'
                GROUP BY
                    pac.id_paciente, nombre_completo
                ORDER BY
                    citas_canceladas DESC
                LIMIT 10;";

                $res3 = $conn->hacerConsulta($sql3);

                while ($tupla3 = mysqli_fetch_assoc($res3)) {
                    echo "['" . $tupla3["nombre_completo"] . "', " . $tupla3["citas_canceladas"] . "],";
                }
                ?>
            ]);

            var options3 = {
                title: 'Pacientes con más citas canceladas',
                is3D: true,
            };

            var chart3 = new google.visualization.PieChart(document.getElementById('piechart_3d1'));
            chart3.draw(data3, options3);
        }
    </script>
</head>

<body style="background-color: #C9F2EE;">
    <div class="py-4 custon-bg">
        <h1 class="text-center text-white">Estadísticas</h1>
    </div>
    <div class="flex p-3">
        <button class="btn btn-primary btn-sm menu-button custon-btn" onclick="return menuPricipal()">Volver</button>
    </div>
    <div class="container text-center px-5" >
        <div class="row py-4">
            <div class="col">
                <div id="piechart" class="w-100"></div>
            </div>
            <div class="col">
                <div id="piechart_3d" class="w-100"></div>
            </div>
            <div class="col">
                <div id="piechart_3d1" class="w-100"></div>
            </div>
        </div>
    </div>

    <script>
        function menuPricipal() {
            window.location.href = "../MenuPrincipal.php";
        }
    </script>
</body>

</html>