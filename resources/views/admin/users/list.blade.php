@extends('admin.main')

@section('content')
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
    <table class="table">
        <thead>
        <tr>
            <th>User</th>
            <th>Email</th>
            <th>level</th>
            <th>Update</th>
            <th style="width: 100px">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $key => $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                {{($user->level === 0 )?'Admin' :'User'}}
                </td>

                <td>{{ $user->updated_at }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="/admin/users/edit/{{ $user->id }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" class="btn btn-danger btn-sm"
                       onclick="removeRow({{ $user->id }},'/admin/users/destroy')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="card-footer clearfix">
        {!! $users->links() !!}
    </div>

@endsection
