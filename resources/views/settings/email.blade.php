<header class="box-typical-header-sm">Report email preferences:</header>

<email-preference :person="{{ $user->userable() }}" :url="'{{ $url->email }}'"></email-preference>
