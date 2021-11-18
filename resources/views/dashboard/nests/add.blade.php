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
                        <h3>Make sure each nest are in their seperate location or this system will not work as expected.
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Select nest</h4>
                        <p class="card-description"> The nests are auto fetched from the panel, choose the one that you
                            want to add.
                        </p>
                        <form class="form-group" method="post" action={{ route('dashboard.nests.add') }}>
                            @csrf
                            <label for="node_id">Select target</label>
                            <select class="form-control form-control-lg mb-3" id="node_id" name="node_id">
                                @foreach ($nests as $nest)
                                <option value={{ $nest['attributes']['id'] }}>Nest ID: {{
                                    $nest['attributes']['id'] }} | {{
                                    $nest['attributes']['name'] }}</option>
                                @endforeach
                            </select>
                            @error('node_id')
                            <p>{{ $message }}</p>
                            @enderror
                            <button type="submit" class="btn btn-success mr-2">+ Add nest</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    </script>
    @endsection