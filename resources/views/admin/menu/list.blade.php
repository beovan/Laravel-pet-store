@extends('admin.main')



@section('content')
 <!-- Main content -->
 <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="simple-results.html">
                    <div class="input-group">
                        <input type="search" class="form-control form-control-lg" placeholder="Type your keywords here">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th >Active</th>
                <th>Update</th>
                <th style="width: 100px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        {!! \App\Helpers\Helper::menu($menus) !!}
        </tbody>
    </table>
@endsection


