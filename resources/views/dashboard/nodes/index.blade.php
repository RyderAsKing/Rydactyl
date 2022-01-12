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
                        <h4 class="card-title">Nodes <a href="{{ route('dashboard.nodes.add') }}"> <button type="submit"
                                    class="btn btn-success mb-2 float-right">+
                                    Add node</button></a></h4>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="nodes-table" style="margin-bottom: 15px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Node FQDN</th>
                                        <th>Slots</th>
                                        <th>Slots Used</th>
                                        <th>Slots Remaining</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(sizeof($nodes) < 1) <tr>
                                        <td colspan="8" align="center">No nodes</td>
                                        </tr>
                                        @else
                                        @foreach ($nodes as $node)
                                        <tr>
                                            <td> {{ $node->id }} </td>
                                            <td> {{ $node->name }} </td>
                                            <td> {{ $node->node_fqdn }} </td>
                                            <td> {{ $node->slots }} </td>
                                            <td> {{ $node->slots_used }} </td>
                                            <td> {{ $node->slots - $node->slots_used }} </td>
                                            <td> @if($node->enabled == true) <span
                                                    class="badge badge-success">Enabled</span> @else <span
                                                    class="badge badge-danger">Disabled</span> @endif</td>
                                            <td> <a href="{{ route('dashboard.nodes.id', $node->id) }}"><button
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
        $('#nodes-table').DataTable();
    });
</script>
@endsection