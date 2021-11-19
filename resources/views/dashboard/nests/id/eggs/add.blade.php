@extends('layout.app')
@include('layout.message')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        @yield('message')
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Select egg</h4>
                        <p class="card-description"> The eggs are auto fetched from the panel, choose the one that you
                            want to add.
                        </p>
                        <form class="form-group" method="post" action={{ route('dashboard.nests.id.eggs.add', $nest_id)
                            }}>
                            @csrf
                            <label for="egg_id">Select target</label>
                            <select class="form-control form-control-lg mb-3" id="egg_id" name="egg_id">
                                @foreach ($eggs as $egg)
                                <option value={{ $egg['attributes']['id'] }}>Egg ID: {{
                                    $egg['attributes']['id'] }} | {{
                                    $egg['attributes']['name'] }}</option>
                                @endforeach
                            </select>
                            @error('egg_id')
                            <p>{{ $message }}</p>
                            @enderror
                            <button type="submit" class="btn btn-success mr-2">+ Add egg</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    </script>
    @endsection