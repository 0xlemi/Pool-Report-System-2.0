@extends('docs.layout')

@section('content')
<h1>Chat</h1>

<p>The chat system is based on <a href="https://sendbird.com/">SendBird</a>.</p>

<br>

<div class="callout callout-info" role="alert">
  <h4><a href="https://docs.sendbird.com/">Checkout SendBird Documentation</a></h4>
  <p>To integrate you can go and take a look at their great <a href="https://docs.sendbird.com/">documentation</a>.</p>
  <p>You will need <code>chat_id</code> and <code>token</code> credentials.</p>
</div>

<h3>Get Sendbird Credentials</h3>

<p>Returns the current logged <code>user-role</code> sendbird chat credentials.</p>
<br>
<pre>
    GET  {{url ('/api/v1/account/chat') }}
</pre>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

@endsection
