@extends('layouts/admin/contentLayoutMaster')

@section('title', 'View Role & Permissions')

@section('content')
{{-- breadcrumb-start --}}
<div class="row">

    <div class="col-10 text-left">
        <h3>@yield('title')</h3>
    </div>

    <div class="col-2 text-right">

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

<div class="row">

    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-header">
                <h4 class="pt-2">Role & Permissions Details</h4>
            </div>
            <div class="card-body">

                <ul class="list-group">

                    <li class="list-group-item"><strong>Role Name: </strong>{{$role->name}}</li>

                </ul>

            </div>
        </div>
    </div>

    @if(!empty($rolePermissions))

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="pt-2">Permissions</h4>
                </div>
                <div class="card-body">

                    <ul class="list-group list-group-flush">

                        @foreach($rolePermissions as $rolePermission)

                            <li class="list-group-item"><strong>{{$rolePermission->name}}</strong></li>

                        @endforeach

                    </ul>

                </div>
            </div>
        </div>

    @endif

</div>

@endsection
