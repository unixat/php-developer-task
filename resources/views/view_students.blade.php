<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome to RMP</title>
        <link href="/css/app2.css" rel="stylesheet">
    </head>

    <body>

        <form action="/export" method="post" id="student_form">
            {{ csrf_field() }}

            <div class="header container">
                <div><img src="/images/logo.png" alt="RMP Logo" title="RMP logo" width="100%"></div>

                @if(isset($error) || isset($info))

                <div class="alert @if(isset($error)) alert-danger @else alert-success @endif ">
                    <b>{{ $error ?? "$info" }}</b>
                </div>
                <div class="form-group">
                    <input type="button" class="btm-md btn-info" value="View all students" id="view_all" />
                    <input type="button" class="btn-md btn-info" value="View export history" id="view_history" />
                </div>
                @else
                    @if (session('alert'))
                        <div class="alert alert-warning">
                            {{ session('alert') }}
                        </div>
                    @endif
                     <div class="form-group" >
                        <input type="button" value="Select All" id="select_all" />
                        <input type="input" name="exportFilename" value="" placeholder="export filename" id="export_filename" />
                        <input type="submit" value="Export" id="submit" />
                    </div>
                    <div class="form-group" >
                        <input type="button" class="btn-md btn-info" value="View export history" id="view_history" />
                    </div>

                    </div>
                @endif
            </div>

            <div style='margin: 10px; text-align: center;'>
                <table class="student-table">
                    <tr>
                        <th></th>
                        <th>Forename</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>University</th>
                        <th>Course</th>
                    </tr>

                    @if(count($students) > 0)
                    @foreach($students as $student)
                    <tr>
                        <td><input type="checkbox" class="checkbox" name="studentId[]" value="{{ $student['id'] }}"></td>
                        <td>{{ $student['firstname'] }}</td>
                        <td>{{ $student['surname'] }}</td>
                        <td>{{ $student['email'] }}</td>
                        <td>{{ $student['course']['university'] }}</td>
                        <td>{{ $student['course']['course_name'] }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6" style="text-align: center">Oh dear, no data found.</td>
                    </tr>
                    @endif
                </table>
            </div>

        </form>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script>
          $(document).ready(function() {

            var allChecked = false;

            $("#select_all").click(function(event){
                event.preventDefault();
                allChecked = !allChecked;
                $(".checkbox").prop('checked', allChecked);
                setSelectAllLabel(allChecked);
            });

            $('.checkbox').change(function(){
                if(false == $(this).prop("checked")){
                    allChecked = false;
                }
                if ($('.checkbox:checked').length == $('.checkbox').length ){
                    allChecked = true;
                }
                setSelectAllLabel(allChecked);
            });

            $('#view_all').on('click', function(event) {
                event.preventDefault();
                window.location.assign('/view');
            });

            $('#view_history').on('click', function(event) {
                event.preventDefault();
                window.location.assign('/viewHistory');
            });

            $('form').on('submit', function(e) {
                if (!$('.checkbox:checked').length){
                    alert("Please select records to export");
                    return false;
                }
                if (!$('#export_filename').val()) {
                    alert("Please enter the export filename");
                    return false;
                }
                return true;
            });

            function setSelectAllLabel(allChecked) {
                if (allChecked) {
                    $("#select_all").prop("value", "Unselect All");
                } else {
                    $("#select_all").prop("value", "Select All");
                }
            }

          });
        </script>
    </body>

</html>
