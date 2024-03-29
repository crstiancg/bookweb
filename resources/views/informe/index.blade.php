@extends('adminlte::page')

@section('title', 'Informe')

@section('content_header')
    <h1 class="text-center font-weight-bold text-uppercase">Gestión de Informes</h1>
@stop

@section('content')
@can('informes.create')
<a class="btn btn-info mb-3" href="{{route('informes.create')}}">Registrar Informe</a>
@endcan
<div class="card">
  <div class="card-body">
    <div class="table-responsive">    
      <table class="table table table-striped" id="tinforme">
          <thead class="thead-dark">
            <tr>
              <th>Nombre</th>
              <th>Codigo</th>
              <th>Centro</th>
              <th>Docente</th>
              {{-- <th>Practicas</th> --}}
              <th>Estudiante</th>
              @can('informes.edit','informes.destroy')
              <th>Acciones</th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @foreach ($informe as $item)
            <tr>
              <td>{{$item->info_nombre}}</td>
              <td>{{$item->info_codigo}}</td>
              <td>{{$item->info_centro}}</td>
              <td>{{$item->docente->doce_nombre}} {{$item->docente->doce_paterno}} {{$item->docente->doce_materno}}</td>
              {{-- <td>{{$item->categoria->cate_nombre}}</td> --}}
              <td>{{$item->autor->au_nombre}} {{$item->autor->au_paterno}} {{$item->autor->au_materno}}</td>
              @can('informes.edit','informes.destroy')
              <td width="140px">
                <a href="{{$item->info_pdf}}" class="btn btn-outline-dark btn-sm" target="_blank"><i class="fas fa-lg fa-file"></i></a>
                <a href="{{route('informes.edit', $item)}}" class="btn btn-outline-success btn-sm"><i class="fas fa-lg fa-edit"></i></a>
                <form action="{{route('informes.destroy', $item)}}" method="post" style="display: inline;" class="eliminar"> @csrf @method('delete') <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-lg fa-trash"></i></button></form>
              </td>
              @endcan
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
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

  $('#tinforme').DataTable({
    order: [[0, 'desc']],
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