
<!-- Sidebar -->
<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading">Admin Panel </div>
    <div class="list-group list-group-flush">
        <a href="{{route('topics.create')}}" class="list-group-item list-group-item-action bg-light">Create new quiz</a>
        <a href="{{route('results.index')}}" class="list-group-item list-group-item-action bg-light">All Results</a>
        <a href="{{route('topics.index')}}" class="list-group-item list-group-item-action bg-light">Topics</a>
        <a href="{{route('questions.index')}}" class="list-group-item list-group-item-action bg-light">Questions</a>
        <a href="{{route('questionsOptions.index')}}" class="list-group-item list-group-item-action bg-light">Questions Options</a>
        <a href="{{route('users.index')}}" class="list-group-item list-group-item-action bg-light">User management</a>
    </div>
</div>
<!-- /#sidebar-wrapper -->

<!-- Page Content -->
<div id="page-content-wrapper">

    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

     
    </nav>



    <!-- Menu Toggle Script -->
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
