@extends('layouts.master')
@section('title') Edit {{ $title }} @endsection
@section('css')
    <!-- Select2 css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"/>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') {{ $title }} @endslot
        @slot('title') {{ "Edit ".$title }} @endslot
    @endcomponent

    <!-- end row -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">

                    <form method="POST" action="{{ route('admin.'.request()->segment(2).'.update',[$fund->id]) }}" class="custom-validation" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">{{ ucwords(str_replace('_',' ','select_category')) }}</label>
                            <select name="category_id" id="category_id" class="form-control @error('category_id') parsley-error @enderror" required>
                                <option value="">{{ ucwords(str_replace('_',' ','select_category')) }}</option>
                                @forelse($categories as $id => $categories)
                                    <option value="{{ $id }}" {{ ($fund->category_id === $id) ? 'selected' : '' }}>{{ $categories }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('category_id')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ ucwords(str_replace('_',' ','name')) }}</label>
                            <input type="text" class="form-control @error('name') parsley-error @enderror" name="name"
                                   id="name" placeholder="{{ ucwords(str_replace('_',' ','name')) }}" value="{{ $fund->name }}" required/>
                            @error('name')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ ucwords(str_replace('_',' ','description')) }}</label>
                            <textarea class="form-control" name="description" id="description" placeholder="{{ ucwords(str_replace('_',' ','description')) }}">{{ $fund->description }}</textarea>
                            @error('description')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ ucwords(str_replace('_',' ','amount')) }}</label>
                            <input type="number" class="form-control @error('amount') parsley-error @enderror" name="amount"
                                   id="name" placeholder="{{ ucwords(str_replace('_',' ','amount')) }}" value="{{ old('amount',$fund->amount) }}" required/>
                            @error('amount')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="file" id="image" class="dropify" name="image" value="{{ $fund->image }}" data-height="200">
                            @error('image')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                Submit
                            </button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
@endsection
@section('script-bottom')
    <script>
        $(function () {
            $('#image').dropify({
                defaultFile: "{{ asset($fund->image) }}",
                messages: {
                    'default': 'Drop a file OR click',
                }
            });
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
