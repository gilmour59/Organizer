@extends('layout.app')

@section('content')
    <div class="text-center my-4">
        <h2>Organizer Test</h2>
    </div>
    <div class="card">
        <div class="card-header font-weight-bold">
            Search
        </div>
        <div class="card-body">
            <div class="form-group">
                <input id="search" name="search" class="form-control offset-3 col-sm-6" type="text" placeholder="Search Here">
            </div>
            <div class="table-responsive">
                <h6 align="left">Total Data: <span id="total_records"></span></h6>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Subject</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            
            fetch_data();

            function fetch_data(query = ''){
                $.ajax({
                    url: "{{ route('search.action') }}",
                    method: 'GET',
                    data: {
                        query: query
                    },
                    dataType: 'json',
                    success: function(data){
                        $('tbody').html(data.table_data);
                        $('#total_records').html(data.total_data);
                    }
                })
            }
            
            $.(document).on('keyup', '#search', function(){

                var query = $(this).val();
                fetch_data(query);
            })
        });
    </script>
@endsection