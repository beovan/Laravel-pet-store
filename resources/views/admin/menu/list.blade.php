@extends('admin.main')



@section('content')
 <!-- Main content -->
 <section class="content">
   
            <div class="col-md-8 offset-md-2">
                <form action="">
                    <div class="input-group">
                        <input type="search" name="q" class="form-control form-control-lg" placeholder="Type your keywords here" value="{{$search_param}}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
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
    {!! $menus->links() !!}
@endsection


