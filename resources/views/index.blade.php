
<div class="card mx-auto" style="width: 1150px;">
    <div class="card-header font-weight-bold">
        Search
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="addLetter">Type of Letter:</label>
                    <select class="form-control col-6" id="letter" name="letter">
                        <option value="1">Ingoing</option>
                        <option value="0">Outgoing</option>
                    </select>
                </div> 
            </div>
            <div class="col-sm-9 align-self-center">
                <div class="input-group">
                    <button id="refreshFile" class="btn btn-outline-success offset-1" onclick="ajaxLoad('{{route('index')}}?search=')">
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
            </div>
        </div>
        
        <div class="row">
                <div class="col-sm-6 align-self-end" style="text-align:left;">
                    <h6>Total Data: <span id="total_records"></span></h6>
                </div>
                <div class="col-sm-6 pb-1 align-self-end"  style="text-align:right;">
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
                        <th width="1%">
                            <a href="javascript:ajaxLoad('{{url('/?field=id&sort='.(request()->session()->get('sort')=='asc'?'desc':'asc'))}}')">
                                No.{{request()->session()->get('field')=='id'?(request()->session()->get('sort')=='asc'?'▴':'▾'):''}}
                            </a>
                        </th>
                        <th width="15%">
                            <a href="javascript:ajaxLoad('{{url('/?field=date&sort='.(request()->session()->get('sort')=='asc'?'desc':'asc'))}}')">
                                Date{{request()->session()->get('field')=='date'?(request()->session()->get('sort')=='asc'?'▴':'▾'):''}}
                            </a>
                            <small class="d-block">yyyy/mm/dd</small>
                        </th>
                        <th width="15%">
                            <a href="javascript:ajaxLoad('{{url('/?field=to&sort='.(request()->session()->get('sort')=='asc'?'desc':'asc'))}}')">
                                To{{request()->session()->get('field')=='to'?(request()->session()->get('sort')=='asc'?'▴':'▾'):''}}
                            </a>
                        </th>
                        <th width="15%">
                            <a href="javascript:ajaxLoad('{{url('/?field=from&sort='.(request()->session()->get('sort')=='asc'?'desc':'asc'))}}')">
                                From{{request()->session()->get('field')=='from'?(request()->session()->get('sort')=='asc'?'▴':'▾'):''}}
                            </a>
                        </th>
                        <th width="15%">
                            <a href="javascript:ajaxLoad('{{url('/?field=name&sort='.(request()->session()->get('sort')=='asc'?'desc':'asc'))}}')">
                                Name{{request()->session()->get('field')=='name'?(request()->session()->get('sort')=='asc'?'▴':'▾'):''}}
                            </a>
                        </th>
                        <th width="30%">
                            <a href="javascript:ajaxLoad('{{url('/?field=subject&sort='.(request()->session()->get('sort')=='asc'?'desc':'asc'))}}')">
                                Subject{{request()->session()->get('field')=='subject'?(request()->session()->get('sort')=='asc'?'▴':'▾'):''}}
                            </a>
                        </th>
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
                        <td class="align-middle"> <a style="font-size:12px" href="{{route('view', ['id' => $row->id])}}" target="_blank" class="btn btn-success">View</a> </td>
                        <td class="align-middle"> <a style="font-size:12px" href="{{route('download', ['id' => $row->id])}}" class="btn btn-primary">Download</a> </td>
                        <td class="align-middle"> <button style="font-size:12px" type="button" class="btn btn-info" data-toggle="modal" data-target="#editFile" onclick="ajaxEdit('{{ route('edit', ['id' => $row->id]) }}')">Edit</button> </td>
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

@include('modal.addModal')
@include('modal.editModal')

<script>
    $('.custom-file-input').on('change',function(){
        $(this).next('.form-control-file').addClass("selected").html($(this).val());
    })
</script>
