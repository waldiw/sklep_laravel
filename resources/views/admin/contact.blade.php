@extends('layouts.app')

@section('title', 'E-sklep Administracja')

@section('content')
    <h2>Strona Kontakt:</h2>
    <form method="post" action="{{ Route('contact') }}" enctype="multipart/form-data">
        @csrf

        {{ method_field('PUT') }}

        <label for="contact"></label>
        <textarea class="form-control" id="contact" placeholder="kontakt" name="contact">{{ $contact }}</textarea>
        <div class="btnAddArticle">
            <button type="submit" class="btnDodaj">Zapisz dane kontaktowe <i class="fa-regular fa-square-plus"
                                                                             style="color: #ffffff;"></i></button>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $('#contact').summernote({
            placeholder: 'Dane kontaktowe',
            tabsize: 2,
            height: 500,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    </script>
@endsection
