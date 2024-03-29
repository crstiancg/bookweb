@extends('adminlte::page')

@section('title', 'Libro Digital')

@section('content_header')
    <h1 class="text-center font-weight-bold text-uppercase">Gestión de libros</h1>
@stop

{{-- @section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap4.min.css">
@stop --}}

@section('css')
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/keytable/2.7.0/css/keyTable.bootstrap4.min.css"> --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@stop

@section('content')
@can('libros.create')
<a href="{{route('libros.create')}}" class="btn btn-info mb-3">Registrar libro</a>
@endcan
<div class="card">
  <div class="card-body">
<div class="table-responsive">
    <table id="tlibro" class="table">
        <thead class="thead-dark text-center">
          <tr>
            <th>Titulo</th>
            {{-- <th>Autor</th> --}}
            <th>Imagen</th>
            <th>Descripcion</th>
            @can('libros.edit','libros.destroy')
            <th>Editar</th>
            <th>Eliminar</th>
            @endcan
            {{-- <th>Eliminar</th> --}}
          </tr>
        </thead>
        {{-- <tbody>
          @foreach ($libros as $li)
          <tr>
            <td><a href="{{route('libros.show', $li)}}" class="text-decoration-none">{{$li->li_titulo}}</a></td>
            <td>{{$li->li_autor}}</td>
            <td><img src="{{$li->li_image}}" alt="" width="50px"></td>
            <td class="text-justify" >{{Str::limit($li->li_descripcion, 200)}}</td>
            @can('libros.edit','libros.destroy')
            <td width="140px">
              <a href="{{$li->li_enlace}}" class="btn btn-outline-dark btn-sm" target="_blank"><i class="fas fa-lg fa-file"></i></a>
              <a href="{{route('libros.edit', $li)}}" class="btn btn-outline-success btn-sm"><i class="fas fa-lg fa-edit"></i></a>
              <form action="{{route('libros.destroy', $li)}}" method="post" class="d-inline eliminar"> @csrf @method('delete')<button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-lg fa-trash"></i></button></form>
            </td>
            @endcan
          </tr>
          @endforeach
        </tbody> --}}
      </table>
    </div>
  </div>
</div>
@stop

{{-- <div class="container">
<div class="row">
@foreach ($libros->chunk(3) as $chunk)
<div class="card-group">
  @foreach ($chunk as $li)
  <div class="card m-2">
  <div class="col">
    <div class="card-body">
      <h5 class="card-title">{{$li->li_titulo}}</h5>
      <p class="card-text">{{$li->li_descripcion}}</p>
      <div class="df aling-items-start">
          <a href="{{$li->li_enlace}}" class="btn btn-outline-dark btn-sm" target="_blank"><i class="fas fa-lg fa-file"></i></a></td>
          <a href="{{route('libro.edit', $li)}}" class="btn btn-outline-success btn-sm"><i class="fas fa-lg fa-edit"></i></a></td>
          <form action="{{route('libro.destroy', $li)}}" method="post"> @csrf @method('delete') <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-lg fa-trash"></i></button></form>
      </div>    
    </div>
  </div>
</div>
@endforeach
</div
@endforeach
</div>
</div> --}}

@section('js')
{{-- 
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap4.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/keytable/2.7.0/js/dataTables.keyTable.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
    $('#tlibro').DataTable({
    // processing: true, // Habilitar el indicador de procesamiento
    responsive: true, // Habilitar la funcionalidad de diseño responsivo
    autoWidth: false,
    pagingType: "full_numbers", // Mostrar todos los controles de paginación
      "ajax": '{{ route('datatable.libro') }}',
      columns: 
      [
        {data: 'li_titulo'},
        {data: 'li_image',
          render: function(data) {
            return '<img src='+data+' alt="" width="50px">';
          }    
        },
        {data: 'li_descripcion'},
        {data: 'li_slug',
          render: function(data) {
              return '<div class="df aling-items-start"><a class="btn btn-outline-success btn-sm" href="/libros/'+data+'/edit"><i class="fas fa-lg fa-edit"></i></a></div>';
            } 
        },
        {data: 'li_slug',
          render: function(data) {
              return '<div class="df aling-items-start"><form action="/libros/'+data+'" method="post" style="display: inline;" class="eliminar"> @csrf @method('delete')<button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-lg fa-trash"></i></button></div>';
            } 
        },
      ],
      order: [[2, 'desc']],
      responsive: true,
      autoWidth: false,     
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    }
    });
</script>

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
</script>
@stop