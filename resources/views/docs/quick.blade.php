@extends('docs.layout')

@section('content')

<h1>Quick Start</h1>
<p>The Platform API enables you to interact with your Pool Report System information. The APIs are designed around RESTful principles, and return JSON in response to HTTP requests.</p>
<h2>Headers</h2>
<p>A typical request to the API includes the following headers:</p>

<pre class="line-numbers"><code class="language-json">
{
    Accept: application/json
    Authorization: Bearer {API_Token}
}
</code></pre>

<ul>
    <li>
        <strong>Accept</strong>
        : Every request must include a Accept header.
    </li>
    <li>
        <strong>Authorization</strong>
        : An API Token is required to identify and authenticate your application. An exception is when you wish to perform actions outside of a specific application, such as creating a new company (sign up).
    </li>
</ul>

<h2>Authentication</h2>

<h4>Personal Access Tokens</h4>
<br>
<p>While in developent or lingering, you can use personal access tokens to authenticate to the application</p>

<strong>To get a personal access token </strong>:
<ol>
    <li>
        Log in to your account.
    </li>
    <li>
        Go to the <a href="{{ url('developer') }}" target="_blank">Developer Settings</a>.
    </li>
    <li>
        Click on create new personal access token.
    </li>
</ol>

<br>

<h4>OAuth Authentication Tokens</h4>
<br>
<p>Pool Report System is fully compatible with the OAuth2 standard. You can read more about it at <a href="https://oauth.net/2/" target="_blank" >OAuth2 Documentation</a></p>

<strong>To create a new OAuth Client</strong>:
<ol>
    <li>
        Log in to your account.
    </li>
    <li>
        Go to the <a href="{{ url('developer') }}" target="_blank" >Developer Settings</a>.
    </li>
    <li>
        Click on create new client.
    </li>
</ol>

<h2>Url Encoding</h2>
<p>When sending requests over HTTP, it is required that you encode your URLs into a browser-readable format. urlencoding replaces unsafe non-ASCII characters with a % followed by hex digits in order to ensure readability.</p>
<br>


@endsection
