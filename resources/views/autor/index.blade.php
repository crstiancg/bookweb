@extends('adminlte::page')

@section('title', 'Autor')

@section('content_header')
    <h1 class="text-center font-weight-bold text-uppercase">Lista de Estudiantes</h1>
@stop

@section('content')

<a class="btn btn-info mb-3" href="{{route('autors.create')}}">Crear Nuevo Estudiante</a>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">    
            <table class="table table-striped text-center" id="tautor">
                <thead class="thead-dark">
                    <tr>
                    <th>Nombre</th>
                    <th>Paterno</th>
                    <th>Materno</th>
                    <th>Codigo</th>
                    <th>Sexo</th>
                    <th>Correo</th>
                    <th>Celular</th>
                    <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($autores as $item)
                    <tr>
                    <td>{{$item->au_nombre}}</td>
                    <td>{{$item->au_paterno}}</td>
                    <td>{{$item->au_materno}}</td>
                    <td>{{$item->au_codigo}}</td>
                    <td>{{$item->au_sexo}}</td>
                    <td>{{$item->au_correo}}</td>
                    <td>{{$item->au_celular}}</td>
                    <td width="140px">
                        <a href="{{route('autors.edit', $item)}}" class="btn btn-outline-success btn-sm"><i class="fas fa-lg fa-edit"></i></a>
                        <form action="{{route('autors.destroy', $item)}}" method="post" style="display: inline"> @csrf @method('delete') <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-lg fa-trash"></i></button></form>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $('#tautor').DataTable({
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