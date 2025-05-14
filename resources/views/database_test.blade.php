<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel and MySQL Database Connection</title>
</head>
<body>
    <?php
        use Illuminate\Support\Facades\DB;
        
        if(DB::connection()->getPDO()){
            echo "Database successfully configured and connected!" . DB::connection()->getDatabaseName();
        }
        else{
            echo "Database connect to failed.";
        }
    ?>
</body>
</html>