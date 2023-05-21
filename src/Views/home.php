<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_ENV["APP_NAME"] ?></title>
    <link rel="stylesheet" href="./styles/home.css">
</head>

<body class="bg-[url('../images/main_bg.jpg')] bg-no-repeat bg-cover">
    <div class="container">
        <nav class="py-4 flex justify-between items-center">
            <div class="flex gap-4">
                <img src="../images/logo.png" alt="logo" class="w-12 h-12">
                <div>
                    <h1 class="font-bold text-3xl">HealMe</h1>
                    <p class="text-xs max-w-[200px]">The place where you are priority.</p>
                </div>
            </div>
            <div class="flex flex-list">
                <ul class="flex gap-2 items-center">
                    <li><a href="">Home</a></li>
                    <li><a href="">About</a></li>
                    <li><a href="">Services</a></li>
                    <li><a href="">Contact</a></li>
                    <li><a href="">Q&A</a></li>
                </ul>
            </div>
            <div class="numbers ">
                <button>ENG</button>
                <button>+213 6-72-15-56-48</button>
            </div>
        </nav>
        <main class="py-14">
            <div>
                <p class="max-w-[700px] text-[2.6rem] font-semibold letter tracking-wide drop-shadow-lg leading-relaxed">Over a long period of work we have provided hundreds of thousands of healthcare services</p>
            </div>
            <div class="flex justify-between mt-10">
                <div class=" flex ">
                    <p class="font-semibold text-xl pr-20">Facts</p>
                    <div class="w-[300px]">
                        <p class="border-b-[1px]  border-white/40 pb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex, tenetur.</p>
                        <p class="border-b-[1px] border-white/40 pb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex, tenetur.</p>
                        <p class="border-b-[1px] border-white/40 pb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex, tenetur.</p>
                    </div>
                </div>
                <div class="bg-blue-700 p-5 flex flex-col justify-between h-60 border-[1px] shadow-lg border-white/20">
                    <p class="max-w-[70%]">Take the discount for the first visit for all types of doctors.</p>
                    <div class="flex justify-between items-center">
                        <h3 class="text-4xl italic font-bold">20%</h3>
                        <a href="" class="bg-white text-black rounded-full font-semibold px-4 py-2">Make an appointment!</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>