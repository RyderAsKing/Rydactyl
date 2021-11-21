@extends('layout.app')
@include('layout.message')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        @yield('message')
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        @if($node->enabled == true)
                        <h4 class="card-title">Disable Node</h4>
                        <p> Disabling a Node will not allow any user to create a server using this Node
                            has. Existing servers will remain uneffected.</p>
                        <a href="{{ route('dashboard.nodes.id.toggle', $node->id) }}">
                            <button type="submit" class="btn btn-danger mb-2">Disable</button></a>
                        @else
                        <h4 class="card-title">Enable Node</h4>
                        <p> Enabling a Node will allow any user to create a server using this Node
                            has. Existing servers
                            will remain uneffected.</p>
                        <a href="{{ route('dashboard.nodes.id.toggle', $node->id) }}">
                            <button type="submit" class="btn btn-success mb-2">Enable</button></a>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('dashboard.nodes.id', $node->id) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="node_name">Name</label>
                                <input type="text" class="form-control mb-3" id="node_name" name="node_name"
                                    placeholder="Name of the Node (Displayed when deploying a server)" value={{
                                    old('node_name') }}>
                                <small>Current
                                    Name: {{
                                    $node->name }}</small>
                            </div>
                            @error('node_name')
                            <p>{{ $message }}</p>
                            @enderror

                            <div class="form-group">
                                <label for="node_description">Description</label>
                                <input type="text" class="form-control mb-3" id="node_description"
                                    name="node_description" placeholder="Description of the Node" value={{
                                    old('node_description') }}>
                                <small>Current
                                    Description: {{
                                    $node->description }}</small>
                            </div>
                            @error('node_description')
                            <p>{{ $message }}</p>
                            @enderror

                            <div class="form-group">
                                <label for="node_slots">Slots</label>
                                <input type="number" class="form-control" id="node_slots" name="node_slots"
                                    placeholder="How many servers can be created on this node?" min="0" value={{
                                    old('node_slots') }}>
                                <small>Current
                                    Slots: {{ $node->slots_used }} / {{
                                    $node->slots }} </small>
                            </div>
                            @error('node_slots')
                            <p>{{ $message }}</p>
                            @enderror

                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
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