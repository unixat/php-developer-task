<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to RMP</title>
    <link href="/css/app2.css" rel="stylesheet">
</head>

<body>
    <div class="header container">
        <div><img src="/images/logo.png" alt="RMP Logo" title="RMP logo" width="100%"></div>
        <div class="form-group">
            <input type="button" class="btm-md btn-success" value="View all students" id="view_all" />
        </div>
    </div>

    <div class="container-fluid">
        <table class="student-table">
            <tr>
                <th>Id</th>
                <th>Filename</th>
                <th>No. Records</th>
                <th>Date Created</th>
            </tr>

            @if(count($exportHistory) > 0)
            @foreach($exportHistory as $export)
            <tr>
                <td>{{ $export['id'] }}</td>
                <td>{{ $export['filename'] }}</td>
                <td>{{ $export['records'] }}</td>
                <td>{{ $export['created_at'] }}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="6" style="text-align: center">Oh dear, no data found.</td>
            </tr>
            @endif
        </table>
    </div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        $('#view_all').on('click', function(event) {
            event.preventDefault();
            window.location.assign('/view');
        });
    });
</script>
</body>

</html>
