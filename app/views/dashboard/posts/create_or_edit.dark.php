<extends path="layout/dashboard"/>

<block:content2>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">

    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h1 class="h2 d-inline">
                    {{ $title }}
                </h1>

                @isset($post)
                    <form method="POST" action="@route('dashboard.posts.destroy', [$post->id])">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                @endisset
            </div>
            <div class="card-body">
                <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf-token" value="{{ $csrfToken }}"/>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $post->title ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label for="file">File (jpf or png)</label>
                        <input type="file" class="file" name="file" accept="image/jpeg, image/png">
                    </div>

                    <div class="form-group">
                        <label for="preview">Preview</label>
                        <textarea name="preview" class="form-control" rows="4">{{ $post->preview ?? '' }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" id="content">{{ $post->content ?? '' }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="unpublished" {{ isset($post) && $post->status === 'unpublished' ? 'selected' : '' }}>Unpublished</option>
                            <option value="published" {{ isset($post) && $post->status === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script>
        var simplemde = new SimpleMDE({
            element: document.querySelector('#content')
        });
    </script>
</block:content2>