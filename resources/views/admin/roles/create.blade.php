@extends('layouts.master')
@section('title') Create {{ $title }} @endsection
@section('css')
    <!-- Select2 css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endsection
@section('content')
    @php
        if (request()->segment(3) == 'create') {
            $action = route("admin.roles.store");
            $page = 'Create';
        } elseif (request()->segment(4) == 'edit') {
            $action = route("admin.roles.update", [$role->id]);
            $page = 'Edit';
        }
    @endphp
    @component('components.breadcrumb')
        @slot('li_1') {{ $title }} @endslot
        @slot('title') {{ $page." ".$title }} @endslot
    @endcomponent

    <!-- end row -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">

                    <form method="POST" action="{{ $action }}" class="custom-validation" enctype="multipart/form-data">
                        @csrf
                        @if(request()->segment(4) == 'edit')
                            @method('PUT')
                        @endif
                        <div class="form-group">
                            <label>{{ ucwords(str_replace('_',' ','title')) }}</label>
                            <input type="text" class="form-control @error('title') parsley-error @enderror"
                                   value="{{ $role->title ?? '' }}" name="title" id="title"
                                   placeholder="{{ ucwords(str_replace('_',' ','title')) }}" required/>
                            @error('title')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="required" for="permissions">Select Permissions</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">Select All</span>
                                <span class="btn btn-danger btn-xs deselect-all" style="border-radius: 0">Delect All</span>
                            </div>
                            <select class="form-control select2 {{ $errors->has('permissions') ? 'parsley-error' : '' }}" name="permissions[]" id="permissions" multiple required>
                                @foreach($permissions as $id => $permissions)
                                    <option value="{{ $id }}" {{ in_array($id, old('permissions', [])) ? 'selected' : '' }}>{{ $permissions }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('permissions'))
                                <span class="text-danger">{{ $errors->first('permissions') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection
@section('script')
    <script src="{{ asset('assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
    <!-- Plugins js -->
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
@endsection
@section('script-bottom')
    <script>
        $(function () {
            $('.select2').select2();
            $('.select-all').click(function () {
                let $select2 = $(this).parent().siblings('.select2')
                $select2.find('option').prop('selected', 'selected')
                $select2.trigger('change')
            })
            $('.deselect-all').click(function () {
                let $select2 = $(this).parent().siblings('.select2')
                $select2.find('option').prop('selected', '')
                $select2.trigger('change')
            })
        })
    </script>
@endsection
