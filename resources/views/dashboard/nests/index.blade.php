@extends('layout.app')
@include('layout.message')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        @yield('message')
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Nests <a href="{{ route('dashboard.nests.add') }}"> <button type="submit"
                                    class="btn btn-success mb-2 float-right">+
                                    Add nest</button></a></h4>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="nests-table" style="margin-bottom: 15px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Eggs</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(sizeof($nests) < 1) <tr>
                                        <td colspan="6" align="center">No nests</td>
                                        </tr>
                                        @else
                                        @foreach ($nests as $nest)
                                        <tr>
                                            <td> {{ $nest->id }} </td>
                                            <td> {{ $nest->name }} </td>
                                            <td> {{ Str::limit($nest->description, 32, '...') }} </td>
                                            <td> @if($nest->enabled == true) <span
                                                    class="badge badge-success">Enabled</span> @else <span
                                                    class="badge badge-danger">Disabled</span> @endif</td>
                                            <td> {{ $nest->egg->count() }} </td>
                                            <td> <a href="{{ route('dashboard.nests.id', $nest->id) }}"><button
                                                        class="btn btn-warning"><i
                                                            class="mdi mdi-table-edit"></i></button></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready( function () {
        $('#nests-table').DataTable();
    });
</script>
@endsection