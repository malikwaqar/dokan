@extends('admin.app')
@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Slug</th>
                <th>Categories</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @if($categories)
                @foreach($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->title}}</td>
                <td>{!! $category->description !!}</td>
                <td>{{$category->slug}}</td>
                <td>
                    @if($category->childrens()->count() > 0)
                        @foreach($category->childrens as $children)
                            {{$children->title}},
                            @endforeach
                        @else
                        <strong>{{"Parent Category"}}</strong>
                        @endif
                </td>
                <td>{{$category->created_at}}</td>
                <td><a class="btn btn-info btn-sm" href="#">Edit</a> | <a class="btn btn-danger btn-sm" href="#">Delete</a></td>
            </tr>
            @endforeach
            @else
                <tr>
                    <td colspan="5">No Categories Found</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    </main>
    </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace()
    </script>

    <!-- Graphs -->

@endsection