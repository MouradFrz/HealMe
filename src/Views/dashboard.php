<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard|Healme</title>
    <link rel="stylesheet" href="./styles/dashboard.css">
</head>

<body>
    <div class="container">
        <?php require 'components/navbar.php' ?>
        <main>
            <div class="flex gap-10 h-[calc(100vh-130px)] my-4">
                <div class="w-[50%] h-full">
                    <div class="section mb-4">
                        <div>
                            <h2>Appointments</h2>
                            <a href="/book">Book</a>
                        </div>
                    </div>
                    <div class="section">
                        <div>
                            <h2>History</h2>
                            <a href="">View All</a>
                        </div>
                    </div>
                </div>
                <div class="w-[50%] section long">
                    <div>
                        <h2>Latest Discussions</h2>
                        <a href="">More</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>