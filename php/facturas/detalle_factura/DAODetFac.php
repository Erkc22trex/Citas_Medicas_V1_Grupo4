<?php

class DAODetFac
{

    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "gestion_de_citas");
    }

    public function navegar($idFactura)
    {
        echo "<script>
                window.location.href = './FormularioDetFac.php?id_factura=' + $idFactura;
            </script>";
    }

    public function getTabla($idFactura)
    {

        if ($idFactura == null) {
            return;
        }

        $sql = "SELECT * FROM detalle_facturas where id_factura = " . $idFactura;
        $res = $this->conn->query($sql);

        $tabla = "<table class='table table-dark'>
        <thead>
            <tr>
                <th scope='col'>Código</th>
                <th scope='col'>Descripción</th>
                <th scope='col'>Precio</th>
                <th scope='col'>Seleccionar</th>
            </tr>
        </thead><tbody>";
        while ($tupla = mysqli_fetch_assoc($res)) {

            $tabla .=
                "<tr>"
                . "<td>" . $tupla["id_det_Factura"] . "</td>"
                . "<td>" . $tupla["descripcion"] . "</td>"
                . "<td>" . $tupla["precio"] . "</td>"
                . "<td>
                    <button class='btn btn-success'>"
                . "<a href='javascript:void(0);' class='link-offset-2 link-underline link-underline-opacity-0 text-light' onclick='seleccionarDetalleFactura(\""
                . $tupla["id_det_Factura"] . "\",\""
                . $tupla["id_factura"] . "\",\""
                . $tupla["descripcion"] . "\",\""
                . $tupla["precio"] . "\")'>Seleccionar</a>
                    </button>
                </td>"
                . "</tr>";
        }

        $tabla .= "</tbody></table>";
        $res->close();
        return $tabla;
    }

    public function ingresarDetalleFactura($detFac)
    {
        $sql = "INSERT INTO detalle_facturas (id_factura, descripcion, precio) VALUES ("
            . $detFac->getIdFactura() . ", '"
            . $detFac->getDescripcion() . "', "
            . $detFac->getPrecio() . ")";

        $this->conn->query($sql);
        $this->navegar($detFac->getIdFactura());
    }

    public function actualizarDetalleFactura($detFac)
    {
        $sql = "UPDATE detalle_facturas SET descripcion = '"
            . $detFac->getDescripcion() . "', precio = "
            . $detFac->getPrecio() . " WHERE id_det_Factura = "
            . $detFac->getIdDetalleFactura();

        $this->conn->query($sql);
        $this->navegar($detFac->getIdFactura());
    }

    public function eliminarDetalleFactura($detFac)
    {
        $sql = "DELETE FROM detalle_facturas WHERE id_det_Factura = "
            . $detFac->getIdDetalleFactura();

        $this->conn->query($sql);
        $this->navegar($detFac->getIdFactura());
    }
}
