@extends('layouts/admin/contentLayoutMaster')

@section('title', 'Users')

@section('style')

  <link rel="stylesheet" href="{{ asset('css/datatables/datatables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatables/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatables/autoFill.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatables/buttons.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatables/colReorder.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatables/dataTables.dateTime.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatables/fixedColumns.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatables/fixedHeader.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatables/keyTable.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatables/responsive.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatables/rowGroup.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatables/rowReorder.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatables/scroller.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatables/searchBuilder.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatables/searchPanes.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatables/select.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatables/stateRestore.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">

@endsection

@section('content')
{{-- breadcrumb-start --}}
<div class="row">

    <div class="col-10 text-left">
        <h3>@yield('title')</h3>
    </div>

    <div class="col-2 text-right">

        @can('user-add')
            <a href="{{route('useradd')}}" class="btn btn-primary text-white">Add User</a>
        @endcan

    </div>

    <div class="col-12 mt-1 mb-3">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            @if(@isset($breadcrumbs))
            <ol class="breadcrumb">
                {{-- this will load breadcrumbs dynamically from controller --}}
                @foreach ($breadcrumbs as $breadcrumb)
                <li class="breadcrumb-item">
                    @if(isset($breadcrumb['link']))
                    <a href="{{ $breadcrumb['link'] == 'javascript:void(0)' ? $breadcrumb['link']:url($breadcrumb['link']) }}">
                        @endif
                        {{$breadcrumb['name']}}
                        @if(isset($breadcrumb['link']))
                    </a>
                    @endif
                </li>
                @endforeach
            </ol>
            @endisset
        </nav>
    </div>

</div>
{{-- breadcrumb-end --}}

<!-- Datatables -->

  @can('user-list')

    <div class="row">
      <div class="col-12">
        <div class="card">
            <div class="card-body">

                <table id="zero_configuration_table" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Role</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
      </div>
    </div>

  @endcan

<!--/ Datatables -->

<style>

    /* romove order arrow icon */
    table.dataTable thead>tr>th.sorting:before,
    table.dataTable thead>tr>th.sorting_asc:before,
    table.dataTable thead>tr>th.sorting_desc:before,
    table.dataTable thead>tr>th.sorting_asc_disabled:before,
    table.dataTable thead>tr>th.sorting_desc_disabled:before,
    table.dataTable thead>tr>td.sorting:before,
    table.dataTable thead>tr>td.sorting_asc:before,
    table.dataTable thead>tr>td.sorting_desc:before,
    table.dataTable thead>tr>td.sorting_asc_disabled:before,
    table.dataTable thead>tr>td.sorting_desc_disabled:before {
        content: none;
    }

    table.dataTable thead>tr>th.sorting:after,
    table.dataTable thead>tr>th.sorting_asc:after,
    table.dataTable thead>tr>th.sorting_desc:after,
    table.dataTable thead>tr>th.sorting_asc_disabled:after,
    table.dataTable thead>tr>th.sorting_desc_disabled:after,
    table.dataTable thead>tr>td.sorting:after,
    table.dataTable thead>tr>td.sorting_asc:after,
    table.dataTable thead>tr>td.sorting_desc:after,
    table.dataTable thead>tr>td.sorting_asc_disabled:after,
    table.dataTable thead>tr>td.sorting_desc_disabled:after {
        content: none;
    }

</style>

@endsection

@section('script')

  <script src="{{ asset('js/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('js/datatables/dataTables.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/datatables/autoFill.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/datatables/buttons.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/datatables/colReorder.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/datatables/dataTables.dateTime.min.js') }}"></script>
  <script src="{{ asset('js/datatables/fixedColumns.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/datatables/fixedHeader.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/datatables/jszip.min.js') }}"></script>
  <script src="{{ asset('js/datatables/keyTable.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/datatables/pdfmake.min.js') }}"></script>
  <script src="{{ asset('js/datatables/responsive.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/datatables/rowGroup.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/datatables/rowReorder.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/datatables/scroller.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/datatables/searchBuilder.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/datatables/searchPanes.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/datatables/select.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/datatables/stateRestore.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/datatables/vfs_fonts.js') }}"></script>
  <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

<?php if(Auth::user()->can('user-list')) { ?>

  <script type="text/javascript">
      $.ajaxSetup({

      headers: {

          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

      }

      });
        $(document).ready(function() {


          dtable = $('#zero_configuration_table').DataTable({
              "language": {
                  "lengthMenu": "_MENU_",
              },
              "columnDefs": [ {
                "targets": "_all",
                "orderable": false
              } ],
              responsive: true,
              'serverSide': true,//Feature control DataTables' server-side processing mode.

              "ajax": {
                "url": "{{route('admin.getUser')}}",
                'beforeSend': function (request) {
                  request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
              },
                "type": "POST",
                "data" :function ( data ) {

                    },
              },
          });

          $('.panel-ctrls').append("<i class='separator'></i>");
          $('.panel-footer').append($(".dataTable+.row"));
          $('.dataTables_paginate>ul.pagination').addClass("pull-right");

          $("#apply_filter_btn").click(function()
          {
            dtable.ajax.reload(null,false);
          });

          $(document).on('click','.deleteRecord',function(){

      var id = $(this).data("id");
      var $tr = $(this).closest('tr');
      var token = $("meta[name='csrf-token']").attr("content");
      Swal.fire({
      title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!',
              confirmButtonClass: 'btn btn-primary',
              cancelButtonClass: 'btn btn-danger ml-1',
              buttonsStyling: false,
              }).then(function (result) {
      if (result.value) {
      $.ajax(
              {

              url: "user/" + id,
                      type: 'DELETE',
                      data: {

                      "id": id,

                      },
                      'beforeSend': function (request) {
                  request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
                      },
                      success: function (){

                      $tr.find('td').fadeOut(1000, function(){
                      $tr.remove();
                      });
                      Swal.fire(
                      {
                      type: "success",
                              title: 'Deleted!',
                              text: 'Your record has been deleted.',
                              confirmButtonClass: 'btn btn-success',
                      }
                      )

                      }

              });
      }
      })
              });


      });
  </script>

<?php } ?>

@endsection



