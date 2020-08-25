<extends path="layout/dashboard"/>

<block:content2>
    <style>
        .table td {
            vertical-align: middle;
        }
    </style>
    <div class="container-fluid mt-4">
        <h1>Podcasts</h1>
        <div class="card">
            <div class="card-body">
                <a href="/dashboard/podcasts/create" class="btn btn-primary my-4">Create new Podcasts</a>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Created_at</th>
                            <th>Updated_at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($podcasts)
                            <?php foreach ($podcasts as $podcast): ?>
                                <tr>
                                    <td><a href="/dashboard/podcasts/{{ $podcast->id }}">{{ $podcast->id ?? '' }}</a></td>

                                    <td><a href="/dashboard/podcasts/{{ $podcast->id }}">{{ $podcast->title ?? '' }}</a></td>
                                    <td>{{ $podcast->status ?? '' }}</td>
                                    <td>{{ $podcast->created_at->date ?? '' }}</td>
                                    <td>{{ $podcast->updated_at->date ?? '' }}</td>
                                    <td>
                                        <a href="/dashboard/podcasts/{{ $podcast->id }}" class="btn btn-info">Edit</a>
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