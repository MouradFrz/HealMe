<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
    <link rel="stylesheet" href="../styles/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body class="flex">
    <?php require __DIR__ . '/../components/admin_sidebar.php'; ?>
    <main class="flex flex-col w-[80%]">
        <?php require __DIR__ . '/../components/admin_navbar.php'; ?>
        <section class="pt-4 px-6 w-full">
            <div class="flex gap-3 mb-5">
                <div class="stat-box bg-red-600 gap-2">
                    <i class="bi bi-file-earmark-medical-fill text-4xl"></i>
                    <div>
                        <h1>Today's appointments</h1>
                        <p class="font-bold">
                            <?= sessionVar('todaysCount') ?>
                        </p>
                    </div>
                </div>
                <div class="stat-box bg-green-600 gap-2">
                    <i class="bi bi-clock-history text-4xl"></i>
                    <div>
                        <h1>Appointments last week</h1>
                        <p class="font-bold">
                            <?= sessionVar('lastWeeks') ?>
                        </p>
                    </div>
                </div>
                <div class="stat-box bg-blue-600 gap-2">
                    <i class="bi bi-hourglass-split text-4xl"></i>
                    <div>
                        <h1>Current appointment</h1>
                        <p class="font-bold">
                            <?php if (isset(sessionVar('currentClientName')['name'])) {
                                echo sessionVar('currentClientName')['name'] . ' at ' . sessionVar('currentClientName')['time'];
                            } else {
                                echo "None";
                            } ?>
                        </p>
                    </div>
                </div>
                <div class="stat-box bg-purple-600 gap-2">
                    <i class="bi bi-arrow-bar-right text-4xl"></i>
                    <div>
                        <h1>Next appointment</h1>
                        <p class="font-bold">
                            <?php if (isset(sessionVar('nextClientName')['name'])) {
                                echo sessionVar('nextClientName')['name'] . 'at' . sessionVar('nextClientName')['time'];
                            } else {
                                echo "None";
                            } ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 mb-5">
                <div class="w-[50%]">
                    <canvas id="barChart"></canvas>
                </div>
                <div class="w-[50%]">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
            <hr class="bg-blue-600">
            <div>
                <?php if (count(sessionVar('todaysAppointments'))) { ?>
                    <table class="text-left table-auto border-separate mt-4 w-full">
                        <tr class="py-5">
                            <th>Name</th>
                            <th>Time</th>
                            <th>Account name</th>
                        </tr>
                        <?php foreach (sessionVar('todaysAppointments') as $appointment) { ?>
                            <tr>
                                <td><?= $appointment["name"] ?></td>
                                <td><?= $appointment["time"] ?></td>
                                <td>
                                    <?= $appointment["user"]["fullname"] ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <p class="font-bold text-center text-3xl">You have no apppointments today</p>
                <?php } ?>
            </div>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const barStats = <?php echo json_encode(sessionVar("barStats")); ?>;
        const barData = {
            labels: barStats.map(el => el._id.time),
            datasets: [{
                label: "Appointments count",
                data: barStats.map(el => el.count),
                borderWidth: 2,
                backgroundColor: ["rgb(37 99 235)"],
            }]
        }
        const ctx = document.getElementById('barChart');
        new Chart(ctx, {
            type: 'bar',
            data: barData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        const lineStats = <?php echo json_encode(sessionVar("lineStats")); ?>;
        const lineData = {
            labels: lineStats.map(el => el._id.date),
            datasets: [{
                label: 'Appointments per day for the last week',
                data: lineStats.map(el => el.count),
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.2
            }]
        };

        const line = document.getElementById('lineChart');
        new Chart(line, {
            type: 'line',
            data: lineData,
        });
    </script>
</body>

</html>