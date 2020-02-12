# RMP Enterprise Developer Task - CSV Export
### David Sullivan

# fputcsv
Only used fputcsv for verifying the unit tests. Originally just worked out the expected results from reading the CSV IETF spec. Using fputcsv seemed more sensible and robust way of affirming the outputs are correct, hopefully it's usage in this way is legitimate with regard to the task brief.

# Overwritting CSV file
There is no warning if an existing filename is selected, any existing file gets overwritten.

# Services
There are two classes, CsvFileService (which is a service in my opinion), and ExportCsvService. My MVC thinking is normally would be a Model. Reason the class is a "Service" is that Eloquent classes appears (with my limited Laravel experience) to bind tightly with a database table. If I had time to go back, I think it should be a Model class (if Eloquent regime allows that).

# SASS
After installing bootstrap-sass with npm, had problems with webpack building the css files. Would have liked to have added some basic styling to improve the look of new buttons. Just used some bootstrap classes to provide some crude button styling.

# Feedback
An interesting exercise which has improved my knowledge of Laravel's convenience and seamless provision for PHP development. I'm sure there are some mistakes here, any feedback would be most welcome.

David Sullivan
