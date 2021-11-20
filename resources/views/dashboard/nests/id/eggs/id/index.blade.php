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
                        @if($egg->enabled == true)
                        <h4 class="card-title">Disable Egg</h4>
                        <p> Disabling a Egg will not allow any user to create a server using this Egg
                            has. Existing servers will remain uneffected.</p>
                        <a href="{{ route('dashboard.nests.id.eggs.id.toggle', $egg->id) }}"> <button type="submit"
                                class="btn btn-danger mb-2">Disable</button></a>
                        @else
                        <h4 class="card-title">Enable Egg</h4>
                        <p> Enabling a Egg will allow any user to create a server using this Egg
                            has. Existing servers
                            will remain uneffected.</p>
                        <a href="{{ route('dashboard.nests.id.eggs.id.toggle', $egg->id) }}"> <button type="submit"
                                class="btn btn-success mb-2">Enable</button></a>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="node_name">Name</label>
                            <input type="text" class="form-control" id="node_name" name="node_name"
                                placeholder="Name of the node (Displayed when deploying a server)" value={{
                                old('node_name') }}>
                        </div>
                        @error('node_name')
                        <p>{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="node_description">Description</label>
                            <input type="text" class="form-control" id="node_description" name="node_description"
                                placeholder="Processor name perhaps?" value={{ old('node_description') }}>
                        </div>
                        @error('node_description')
                        <p>{{ $message }}</p>
                        @enderror
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