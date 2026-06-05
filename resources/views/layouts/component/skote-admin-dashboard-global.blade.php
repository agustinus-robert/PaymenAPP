<div class="col-md-8">
    <div class="jumbotron bg-light p-2">
        <h2>Assalamu'alaikum {{ auth()->user()->name }}!</h2>
        <p class="text-muted">Selamat datang di Solo CMS</p>
    </div>
</div>

<div class="col-md-4">
    @include('account::includes.account-info')
</div>
