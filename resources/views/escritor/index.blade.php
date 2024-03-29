@extends('adminlte::page')

@section('title', 'Autores')

@section('content_header')
    <h1 class="text-center font-weight-bold text-uppercase">Gestión de Tipo de Practica</h1>
@stop

@section('content')

<a class="btn btn-info mb-3" href="{{route('escritor.create')}}">Registrar Escritor</a>

<div class="card">
  <div class="card-body">
    <table class="table table-striped text-center" id="tcategoria">
      <thead class="thead-dark">
        <tr>
          <th>Nombre</th>
          <th>Acciones</th>
          
        </tr>
      </thead>
      <tbody>
        @foreach ($escritor as $esc)
        <tr>
          <td>{{$esc->nombres}}</td>
          <td width="140px">
            <a href="{{route('escritor.edit', $esc)}}" class="btn btn-outline-success btn-sm"><i class="fas fa-lg fa-edit"></i></a>
            <form action="{{route('escritor.destroy', $esc)}}" method="post" style="display: inline" class="eliminar"> @csrf @method('delete') <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-lg fa-trash"></i></button></form>
          </td>
          
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@stop

@section('js')

@if(session('eliminar') == 'delete')
<script>
 Swal.fire(
          '¡Eliminado!',
          'El registro ha sido eliminado.',
          'success'
        )
</script>
@endif
<script>
  $('.eliminar').submit(function(e){
    e.preventDefault();

    Swal.fire({
      title: '¿Estas seguro?',
      text: "No podrás revertir esto!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '¡Si, eliminarlo!',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {

        this.submit();
      }
    })

  });

  $('#tcategoria').DataTable({
    responsive: true,
    autoWidth: false,
    "language": {
          "lengthMenu": "Mostrar "+`
          <select class="custom-select custom-select-sm form-control form-control-sm">
            <option value="10">10</option> 
            <option value="25">25</option> 
            <option value="50">50</option> 
            <option value="100">100</option> 
            <option value="-1">All</option> 
          </select>
          `+" registros por paginas",
          "zeroRecords": "Nada encontrado - lo siento",
          "info": "Mostrando la pagina _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(filtrado de _MAX_ registro total)",
          "search":"Buscar: ",
          "paginate":{
            "next": "Siguiente",
            "previous": "Anterior"
          }
      }
  });
</script>
@stop