<aside class="min-w-[20%] sticky top-0 left-0 h-[100vh] px-2 bg-slate-100 flex flex-col">
    <div class="py-4 flex gap-4 w-full justify-center">
        <img src="../../images/logo.png" alt="logo" class="w-12 h-12">
        <div class=" sticky top-0 left-0">
            <h1 class="font-bold text-3xl">HealMe</h1>
            <p class="text-xs max-w-[200px]">The place where you are priority.</p>
        </div>
    </div>
    <ul class="pt-4">
        <li class="sidebar-element"><a href="/admin/dashboard"><i class="bi bi-house-door"></i> Home</a></li>
        <li class="sidebar-element"><a href=""><i class="bi bi-clipboard2-pulse"></i> Appointments</a></li>
        <li class="sidebar-element"><a href="/admin/access-control"><i class="bi bi-shield-check"></i> Access management</a></li>
        <li class="sidebar-element"><a href=""><i class="bi bi-calendar-date"></i> Schedule management</a></li>
    </ul>
    <form action="/admin/logout" class="mt-auto" method="POST">
        <button class="mb-5 w-full bg-blue-400 py-2 rounded-full font-bold align-end">Logout</button>
    </form>
</aside>