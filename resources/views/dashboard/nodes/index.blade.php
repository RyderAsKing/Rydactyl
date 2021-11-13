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
                        <h4 class="card-title">Nodes <button type="submit" class="btn btn-success mb-2 float-right">+
                                Add node</button></h4>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="nodes-table" style="margin-bottom: 15px">
                                <thead>
                                    <tr>
                                        <th> Name</th>
                                        <th> Panel FQDN</th>
                                        <th> Slots</th>
                                        <th> Slots Used</th>
                                        <th> Slots Remaining</th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(sizeof($nodes) < 1) <tr>
                                        <td colspan="6" align="center">No nodes</td>
                                        </tr>
                                        @else
                                        @foreach ($nodes as $node)
                                        <tr>
                                            <td> {{ $node->name }} </td>
                                            <td> {{ $node->panel_fqdn }} </td>
                                            <td> {{ $node->slots }} </td>
                                            <td> {{ $node->slots_used }} </td>
                                            <td> {{ $node->slots - $node->slots_used }} </td>
                                            <td> <a href="{{ route('dashboard.nodes.manage', $node->id) }}"><button
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