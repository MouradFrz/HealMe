<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Healme</title>
    <link rel="stylesheet" href="./styles/dashboard.css">
</head>

<body>
    <div class="container">
        <?php require 'components/navbar.php' ?>
        <main class="h-[calc(100vh-180px)]">
            <?php if (inSession('success')) { ?>
                <p class="font-semibold p-4 bg-green-400 my-2 rounded-md"><?= sessionVar('success') ?></p>
            <?php } ?>
            <div class="flex gap-10 h-full my-4">
                <div class="w-[50%] h-full section">
                    <div class="mb-2">
                        <h2>Appointments</h2>
                        <a href="/book">Book</a>
                    </div>
                    <div class="h-full overflow-y-scroll">
                        <div class="flex flex-col min-h-full">
                            <?php if (count(sessionVar("appointments"))) { ?>
                                <?php foreach (sessionVar("appointments") as $app) { ?>
                                    <?php if (strtotime(date("Y-m-d")) < strtotime($app["date"])) { ?>
                                        <div class="flex flex-col justify-center mb-3">
                                            <p class="ml-4"><span class="font-bold ">Patient name: </span><?= $app["name"] ?></p>
                                            <p class="ml-4"><span class="font-bold ">Appointment date and time: </span><?= format_date($app["date"]) ?> at <?= $app["time"] ?></p>
                                            <p class="ml-4"><span class="font-bold ">Reservation date: </span><?= $app["created_at"]->toDateTime()->format("Y-m-d H:i") ?></p>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } else { ?>
                                <p class="ml-4 text-center w-full">You have no appointments!</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="w-[50%] h-full section">
                    <div class="mb-2">
                        <h2>History</h2>
                    </div>
                    <div class="h-full overflow-y-scroll">
                        <div class="flex flex-col min-h-full">
                            <?php if (count(sessionVar("appointments"))) { ?>
                                <?php foreach (sessionVar("appointments") as $index => $app) { ?>
                                    <?php if ($index === 3) break; ?>
                                    <?php if (strtotime(date("Y-m-d")) > strtotime($app["date"])) { ?>
                                        <div class="flex flex-col justify-center mb-3">
                                            <p class="ml-4"><span class="font-bold ">Patient name: </span><?= $app["name"] ?></p>
                                            <p class="ml-4"><span class="font-bold ">Appointment date and time: </span><?= format_date($app["date"]) ?> at <?= $app["time"] ?></p>
                                            <p class="ml-4"><span class="font-bold ">Reservation date: </span><?= $app["created_at"]->toDateTime()->format("Y-m-d H:i") ?></p>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } else { ?>
                                <p class="ml-4 text-center w-full">You have no appointments!</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>