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
                        @if($nest->enabled == true)
                        <h4 class="card-title">Disable Nest</h4>
                        <p> Disabling a Nest will not allow any user to create a server using any of the egg this Nest
                            has. Existing servers will remain uneffected.</p>
                        <a href="{{ route('dashboard.nests.id.toggle', $nest->id) }}"> <button type="submit"
                                class="btn btn-danger mb-2">Disable</button></a>
                        @else
                        <h4 class="card-title">Enable Nest</h4>
                        <p> Enabling a Nest will allow any user to create a server using any of the egg this Nest
                            has. Existing servers
                            will remain uneffected.</p>
                        <a href="{{ route('dashboard.nests.id.toggle', $nest->id) }}"> <button type="submit"
                                class="btn btn-success mb-2">Enable</button></a>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Eggs (Nest ID: {{ $nest->id }}) <a
                                href="{{ route('dashboard.nests.id.eggs.add', $nest->id) }}"> <button type="submit"
                                    class="btn btn-success mb-2 float-right">+
                                    Add egg</button></a></h4>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="nests-table" style="margin-bottom: 15px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
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
                                            <td> @if($egg->enabled == true) <span
                                                    class="badge badge-success">Enabled</span> @else <span
                                                    class="badge badge-danger">Disabled</span> @endif</td>
                                            <td> <a
                                                    href="{{ route('dashboard.nests.id.eggs.id.manage', [$nest->id, $egg->id]) }}"><button
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