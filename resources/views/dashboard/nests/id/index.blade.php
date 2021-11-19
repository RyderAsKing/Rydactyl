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
                        <h4 class="card-title">Eggs (Nest ID: {{ $nest['id'] }}) <a
                                href="{{ route('dashboard.nests.id.eggs.add', $nest['id']) }}"> <button type="submit"
                                    class="btn btn-success mb-2 float-right">+
                                    Add egg</button></a></h4>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="nests-table" style="margin-bottom: 15px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(sizeof($nest->egg) < 1) <tr>
                                        <td colspan="6" align="center">No eggs</td>
                                        </tr>
                                        @else
                                        @foreach ($nest->egg as $egg)
                                        <tr>
                                            <td> {{ $egg->id }} </td>
                                            <td> {{ $egg->name }} </td>
                                            <td> {{ Str::limit($egg->description, 32, '...') }} </td>
                                            <td> Coming Soon </td>
                                            {{-- <td> <a href="{{ route('dashboard.nests.id', $egg->id) }}"><button
                                                        class="btn btn-warning"><i
                                                            class="mdi mdi-table-edit"></i></button></a>
                                            </td> --}}
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