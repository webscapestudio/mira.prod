<p class="h2 n-m font-thin v-center">
    @if (Route::currentRouteName() === 'platform.login')
    <img src={{ url('/images/logo_black.svg') }} alt="">
       @else
<img src={{ url('/images/logo.svg') }} alt="">
    @endif
</p>
