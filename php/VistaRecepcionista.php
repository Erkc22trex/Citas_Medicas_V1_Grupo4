<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<button onclick="mostrarError()">Mostrar error</button>

<script>
function mostrarError() {
  Swal.fire({
    type: 'Exito',
    title: 'Exito',
    text: 'Ingreso de datos exitoso'
  })
}
</script>

