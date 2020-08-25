<extends path="layout/dashboard"/>

<block:content2>
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h1 class="h2 d-inline">
                    {{ $title }}
                </h1>
                @isset($event)
                    <form method="POST" action="@route('dashboard.events.destroy', [$event->id])">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                @endisset
            </div>
            <div class="card-body">
                <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf-token" value="{{ $csrfToken }}"/>

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" required value="{{ $event->title ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" name="date" required value="{{ $event->date ?? ' }}">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</block:content2>