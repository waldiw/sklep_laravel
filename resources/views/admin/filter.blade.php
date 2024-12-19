@extends('layouts.app')

@section('title', 'E-sklep Administracja')

@section('content')
    <h2>Zamówienia:</h2>
    {{--    <a href="{{ route('limit') }}" class="btn btn-success">Ostatnie 10</a>--}}
    <div class="container">
        <h1 class="text-center text-success mt-5 mb-5"><b>Laravel 10 Datatables Date Range Filter</b></h1>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col col-9"><b>Sample Data</b></div>
                    <div class="col col-3">
                        <div id="daterange"  class="float-end" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%; text-align:center">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span>
                            <i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="daterange_table">
                    <thead>
                    <tr>
                        <th>Numer</th>
                        <th>Nazwa</th>
                        <th>Data</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script type="text/javascript">

        $(function () {

            var start_date = moment().subtract(1, 'M');

            var end_date = moment();

            $('#daterange span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

            $('#daterange').daterangepicker({
                startDate : start_date,
                endDate : end_date
            }, function(start_date, end_date){
                $('#daterange span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

                table.draw();
            });

            var table = $('#daterange_table').DataTable({
                processing : true,
                serverSide : true,
                ajax : {
                    url : "{{ route('filter') }}",

                    data : function(data){
                        console.log(data);
                        data.from_date = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                        data.to_date = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                        // console.log(data);
                    }
                },
                columns : [
                    {data : 'id', name : 'id'},
                    {data : 'name', name : 'name'},
                    {data : 'created_at', name : 'created_at'}
                ]
            });

        });

    </script>

@endsection
