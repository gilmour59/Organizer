@extends('layout.app')

@section('content')
    <div class="text-center py-4">
        <h2>Organizer Test</h2>
    </div>
    <div class="card mx-auto" style="width: 1150px;">
        <div class="card-header font-weight-bold">
            Search
        </div>
        <div class="card-body">
            <div class="form-group">
                <input id="search" name="search" class="form-control offset-3 col-sm-6" type="text" placeholder="Search Here">
            </div>
            <div class="row">
                    <div class="col-sm-6 align-self-end" style="text-align:left;">
                        <h6>Total Data: <span id="total_records"></span></h6>
                    </div>
                    <div class="col-sm-6 pb-1"  style="text-align:right;">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFile">
                            Add
                        </button>
                    </div>
                </div>
            <div class="table-responsive" style="font-size:14px">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th width="1%">No.</th>
                            <th width="15%">Date</th>
                            <th width="15%">To</th>
                            <th width="15%">From</th>
                            <th width="15%">Name</th>
                            <th width="30%">Subject</th>
                            <th width="1%"></th>
                            <th width="1%"></th>
                            <th width="1%"></th>
                            <th width="1%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ajax return -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addFile" tabindex="-1" role="dialog" aria-labelledby="FileTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="FileTitle">Add File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form method="POST" action="" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                    <label class="control-label" for="dateReceived">Date Received:</label>
                                    <input class="form-control" type="date" name="dateReceived" id="dateReceived">
                                </div>
                            <div class="form-group">
                                <label class="control-label" for="subject">Subject:</label>
                                <textarea name="subject" class="form-control" id="subject" cols="5" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="fileUpload">Upload File: </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="fileUpload" name="fileUpload">
                                    <label class="custom-file-label form-control-file" for="fileUpload">Choose file</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
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
            
            $(document).on('keyup', '#search', function(){

                var query = $(this).val();
                fetch_data(query);
            });
        });
    </script>
    <script>
        $('.custom-file-input').on('change',function(){
            $(this).next('.form-control-file').addClass("selected").html($(this).val());
        })
    </script>
@endsection