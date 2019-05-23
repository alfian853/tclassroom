@extends('layouts.master')
@section('title')
List Materi
@endsection

@section('add-script')
@parent
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="{{asset('js/file_upload.js')}}"></script>
<script>
    function viewDocument(link){
            // $('#document-iframe').attr('src','/ViewerJS/index.html#..'+link);
            $('#google-iframe').attr('src','https://docs.google.com/viewer?url=http://etc.if.its.ac.id'+link+'&embedded=true');
            $('#view-document-modal').modal('show');
        }

        $(document).ready(function () {
            $.ajaxSetup({
                headers:
                    { 'X-CSRF-TOKEN': '{{csrf_token()}}' }
            });
            let fileUploadModal = new FileUploadModal(
                '{{route('post.agenda.materi',['agenda_id' => request()->agenda_id,
                'no_pertemuan' => request()->no_pertemuan])}}',
                $('input[name=_token]').val(), 'Upload File'
            )

            fileUploadModal.setOnSuccessHandler(function () {
                location.reload(true);
            })
            fileUploadModal.init();

            $('#upload-file-trigger').click(function () {
                $('#' + fileUploadModal.getModalId()).modal('show')
            })

            $('#materi-select').select2({
                placeholder : 'Please select warehouse...',
                ajax : {
                    url : '{{route('get.agenda.list_materi')}}',
                    params : null,
                    delay : 350,
                    headers : { 'X-CSRF-TOKEN': '{{csrf_token()}}' } ,
                    data : function (params) {
                        let query = {
                            search : (params.term != null)?params.term:"",
                            page : (params.page)?params.page:0,
                            length : 10
                        };
                        this.params = query;
                        return query;
                    },
                    processResults : function (result) {
                        let params = this['$element'].params;
                        result.pagination = {
                            more : params.length*params.page < result['recordsFiltered']
                        };
                        let tmp = result.results;
                        let len = tmp.length;
                        for(let i=0; i<len; i++){
                            tmp[i].text = tmp[i].filename;
                            tmp[i].id = tmp[i].text;
                        }
                        console.log(result);
                        return result;
                    }

                }
            });
        })
</script>
@endsection

@section('content')
@csrf

@if(\App\Helpers\AgendaRoleChecker::isPIC(request()->agenda_id))
<p style="padding-top:5px;"></p>
<div class="container">
    <a class="btn btn-md btn-success" id="upload-file-trigger">
        <font color="white"><i class="fa fa-plus-circle"></i>
            <span class="padding-left:10px">Upload Materi Baru</span></font>
    </a>
</div>
<div class="container">
    <a class="btn btn-md btn-success" onclick="(()=>{
        $('#tambah-materi-modal').modal('show');

    })()">
        <font color="white"><i class="fa fa-plus-circle"></i>
            <span class="padding-left:10px">Tambah Materi</span></font>
    </a>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Hapus Materi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h2>Apakah Anda Yakin Ingin Menghapus Materi? </h2>
                <h3 id="nama-materi"></h3>
            </div>
            <form id="form-delete-materi" class="modal-footer" method="post" action="">
                @csrf
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" id="tambah-materi-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form id="form-tambah-materi" class="modal-footer" method="post"
              action="{{route('post.agenda.tambah_materi',['agenda_id' => request()->agenda_id,
                'no_pertemuan' => request()->no_pertemuan])}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Materi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Pilih Materi</label>
                    <select id="materi-select" style="width: 300px;" name="filename">
                    </select>
                </div>
                    @csrf
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                    <button type="submit" class="btn btn-success">Tambahkan Materi</button>
            </div>
        </form>
    </div>
</div>




@endif

<div class="modal fade" id="view-document-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{--<iframe id="document-iframe" src="" width='470' height='680' allowfullscreen--}}
                    {{--webkitallowfullscreen></iframe>--}}
                <iframe id="google-iframe"
                        src="" style="width:600px; height:680px;" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>
<p style="padding-top:10px;"></p>
<div class="container">
    <div class="card bg-light">
        <div class="card-body">
            <h1 align="center">List Materi</h1>
            <div class="row table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark" align="center">
                        <tr>
                            <th>Nama File</th>
                            <th>Tanggal Upload</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @foreach($list_materi as $materi)
                    <tr>
                        <td>{{$materi->filename}}</td>
                        <td align="center">{{$materi->created_at}}</td>
                        <td align="center">
                            <a class="btn btn-success" href="/resources/materi/{{$materi->filename}}">Download</a>
                            <a class="btn btn-primary text-white"
                                onclick="viewDocument('/resources/materi/{{$materi->filename}}')">View</a>
                            @if(\App\Helpers\AgendaRoleChecker::isPIC(request()->agenda_id))
                            <a class="btn btn-danger text-white" data-toggle="modal" data-target="#exampleModalCenter"
                                onclick="(()=>{
                        $('#nama-materi').html('{{$materi->filename}}');
                        $('#form-delete-materi').attr('action','\
                    {{ route('delete.agenda.materi',
                    [
                        'materi_id' => $materi->id,
                        'agenda_id' => request()->agenda_id,
                        'no_pertemuan'=> request()->no_pertemuan
                    ] ) }}')

                    })()">Delete</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

@endsection