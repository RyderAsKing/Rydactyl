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
                        <a href="{{ route('dashboard.nests.id.eggs.id.toggle', [$egg->nest->id, $egg->id]) }}"> <button
                                type="submit" class="btn btn-danger mb-2">Disable</button></a>
                        @else
                        <h4 class="card-title">Enable Egg</h4>
                        <p> Enabling a Egg will allow any user to create a server using this Egg
                            has. Existing servers
                            will remain uneffected.</p>
                        <a href="{{ route('dashboard.nests.id.eggs.id.toggle', [$egg->nest->id, $egg->id]) }}"> <button
                                type="submit" class="btn btn-success mb-2">Enable</button></a>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('dashboard.nests.id.eggs.id', [$egg->nest->id, $egg->id]) }}"
                            method="post">
                            @csrf
                            <div class="form-group">
                                <label for="egg_name">Name</label>
                                <input type="text" class="form-control mb-3" id="egg_name" name="egg_name"
                                    placeholder="Name of the Egg (Displayed when deploying a server)" value={{
                                    old('egg_name') }}>
                                <small>Current
                                    Name: {{
                                    $egg->name }}</small>
                            </div>
                            @error('egg_name')
                            <p>{{ $message }}</p>
                            @enderror

                            <div class="form-group">
                                <label for="egg_description">Description</label>
                                <input type="text" class="form-control mb-3" id="egg_description" name="egg_description"
                                    placeholder="Description of the Egg" value={{ old('egg_description') }}>
                                <small>Current
                                    Description: {{
                                    $egg->description }}</small>
                            </div>
                            @error('egg_description')
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