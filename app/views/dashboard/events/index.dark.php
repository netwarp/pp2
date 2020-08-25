<extends path="layout/dashboard"/>

<block:content2>
    <style>
        .table td {
            vertical-align: middle;
        }
    </style>
    <div class="container-fluid mt-4">
        <h1>Events</h1>
        <div class="card">
            <div class="card-body">
                <a href="/dashboard/events/create" class="btn btn-primary my-4">Create new Event</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($events)
                            <?php foreach ($events as $event): ?>
                                <tr>
                                    <td>{{ $event->id ?? '' }}</td>
                                    <td>{{ $event->title ?? '' }}</td>
                                    <td>{{ $event->date ?? '' }}</td>
                                    <td>
                                        <a href="/dashboard/events/{{ $event->id }}" class="btn btn-info">Edit</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        @else
                            <tr>
                                <td colspan="4">Nothing available</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</block:content2>