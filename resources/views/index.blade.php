
    <div class="text-center py-4">
        <h2>Organizer Test</h2>
    </div>
    <div class="card mx-auto" style="width: 1150px;">
        <div class="card-header font-weight-bold">
            Search
        </div>
        <div class="card-body">
            <div class="input-group">
                <button id="refreshFile" class="btn btn-outline-success offset-3" onclick="ajaxLoad('{{route('index')}}?search=')">
                    <i class="fas fa-redo"></i>
                </button>
                <input class="form-control col-sm-5" id="search" name="search" type="text" placeholder="Search Here" 
                value="{{ request()->session()->get('search') }}" onkeydown="javascript:if(event.keyCode == 13){ajaxLoad('{{route('index')}}?search='+this.value)}"/>
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-outline-primary" onclick="ajaxLoad('{{route('index')}}?search='+$('#search').val())">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
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
                        @foreach ($ogmFiles as $row)
                        <tr>
                            <td class="align-middle">{{ $row->id }}</td>
                            <td class="align-middle">{{ $row->date }}</td>
                            <td class="align-middle">{{ $row->to }}</td>
                            <td class="align-middle">{{ $row->from }}</td>
                            <td class="align-middle">{{ $row->name }}</td>
                            <td style="text-align:left">{{ $row->subject }}</td>
                            <td class="align-middle"> <a style="font-size:12px" href=" '. route('search.view') .'" target="_blank" class="btn btn-success">View</a> </td>
                            <td class="align-middle"> <a style="font-size:12px" href="" class="btn btn-primary">Download</a> </td>
                            <td class="align-middle"> <a style="font-size:12px" href="" class="btn btn-info">Edit</a> </td>
                            <td class="align-middle"> 
                                <input type="hidden" name="_method" value="delete"/>
                                <a style="font-size:12px" href="javascript:if(confirm('Are you sure want to delete?')) ajaxDelete('{{ route('destroy', ['id' => $row->id]) }}','{{csrf_token()}}')" class="btn btn-danger">X</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <ul class="pagination">
                    {{ $ogmFiles->links() }}
                </ul>
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
                        <form id="addFileForm" method="POST" action="/store" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                <label for="addLetter">Select Type of Letter:</label>
                                <select class="form-control" id="addLetter" name="addLetter">
                                    <option value="0">Ingoing</option>
                                    <option value="1">Outgoing</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="addDate">Date Received:</label>
                                <input class="form-control <?php $errors->has('addDate') ? "is-invalid": ""?>" type="date" name="addDate" id="addDate" autofocus>
                                <span id="error-addDate" class="invalid-feedback"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="addTo">To:</label>
                                <input class="form-control" type="text" name="addTo" id="addTo">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="addFrom">From:</label>
                                <input class="form-control" type="text" name="addFrom" id="addFrom">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="addName">Name:</label>
                                <input class="form-control" type="text" name="addName" id="addName">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="addSubject">Subject:</label>
                                <textarea name="addSubject" class="form-control <?php $errors->has('addSubject') ? "is-invalid": ""?>" id="addSubject" cols="5" rows="3"></textarea>
                                <span id="error-addSubject" class="invalid-feedback"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="addFileUpload">Upload File: </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input <?php $errors->has('addFileUpload') ? "is-invalid": ""?>" id="addFileUpload" name="addFileUpload">
                                    <label class="custom-file-label form-control-file" for="addFileUpload">Choose file</label>
                                    <span id="error-addFileUpload" class="invalid-feedback"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="closeAddFilebtn" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" form="addFileForm" class="btn btn-primary" value="Submit">Save</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.custom-file-input').on('change',function(){
            $(this).next('.form-control-file').addClass("selected").html($(this).val());
        })
    </script>
