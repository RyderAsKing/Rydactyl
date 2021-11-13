@extends('layout.app')
@include('layout.message')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        @yield('message')
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h3>Make sure each node are in their seperate location or this system will not work as expected.
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Select node</h4>
                        <p class="card-description"> The nodes are auto fetched from the panel, choose the one that you
                            want to add.
                        </p>
                        <div class="form-group">
                            <label for="node_select">Select target</label>
                            <select class="form-control form-control-lg mb-3" id="node_select">
                                @foreach ($nodes as $node)
                                <option>Location ID: {{ $node['attributes']['location_id'] }} | {{
                                    $node['attributes']['name'] }} | Memory: {{ $node['attributes']['memory']}} | Disk:
                                    {{ $node['attributes']['disk']}}</option>
                                @endforeach
                            </select>
                            <form class="forms-sample">
                                <div class="form-group">
                                    <label for="node_name">Name</label>
                                    <input type="text" class="form-control" id="node_name"
                                        placeholder="Name of the node (Displayed when deploying a server)">
                                </div>
                                <div class="form-group">
                                    <label for="node_description">Description</label>
                                    <input type="text" class="form-control" id="node_description"
                                        placeholder="Processor name perhaps?">
                                </div>
                                <div class="form-group">
                                    <label for="node_slots">Slots</label>
                                    <input type="number" class="form-control" id="node_slots"
                                        placeholder="How many servers can be created on this node?" min="0">
                                </div>
                                <button type="submit" class="btn btn-success mr-2">+ Add node</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    </script>
    @endsection