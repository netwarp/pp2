<extends path="layout/app"/>

<block:content>
    <div class="admin-zone">
        <div class="row">
            <div class="col-md-2">
                <div class="sidebar">
                    <ul>
                        <li><a href="/dashboard">Dashboard</a></li>
                        <li><a href="/dashboard/posts">Posts</a></li>
                        <li><a href="/dashboard/podcasts">Podcasts</a></li>
                        <li><a href="/dashboard/events">Events</a></li>
                        <li><a href="/dashboard/support">Support</a></li>
                        <li><a href="/dashboard/contact">Contact</a></li>
                        <li><a href="/logout">Logout</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md">
                <block:content2>

                </block:content2>
            </div>
        </div>
    </div>
    @isset($success)
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            swal('Success', {{ $success }}, 'success');
        </script>
    @endisset
</block:content>


