<extends path="layout/dashboard"/>

<block:content2>
    <style>
        .table td {
            vertical-align: middle;
        }
    </style>
    <div class="container-fluid mt-4">
        <h1>Posts</h1>
        <div class="card">
            <div class="card-body">
                <a href="/dashboard/posts/create" class="btn btn-primary my-4">Create new Post</a>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Created_at</th>
                            <th>Updated_at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($posts)
                            <?php foreach ($posts as $post): ?>
                                <tr>
                                    <td><a href="/dashboard/posts/{{ $post->id }}">{{ $post->id ?? '' }}</a></td>
                                    <td>
                                        <a href="/dashboard/posts/{{ $post->id }}">
                                            <img src="{{ $post->image ?? '' }}" alt="image post" style="max-width: 80px">
                                        </a>
                                    </td>
                                    <td><a href="/dashboard/posts/{{ $post->id }}">{{ $post->title ?? '' }}</a></td>
                                    <td>{{ $post->status ?? '' }}</td>
                                    <td>{{ $post->created_at->date ?? '' }}</td>
                                    <td>{{ $post->updated_at->date ?? '' }}</td>
                                    <td>
                                        <a href="/dashboard/posts/{{ $post->id }}" class="btn btn-info">Edit</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        @else
                            <tr>
                                <td colspan="6">Nothing available</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</block:content2>