@extends('docs.layout')

@section('content')
<h1>Today's Route</h1>

<p>
    The todays route view is just a list of the <code>services</code> that are do in a certain day.<br>
    This is so the technician can easily see which <code>services</code> are missing and which ones are done.
</p>

<br>

<h3>Todays Route List</h3>

<p>Returns a list of the <code>services</code> do today, or some other day.</p>
<p>You can query based on various parameters</p>
<br>
<pre>
    GET  {{url ('/api/v1/todaysroute') }}
</pre>

<br>

<h5>Optional query parameters</h5>
<table class="table table-bordered table-striped ">
  <thead>
    <tr>
      <th>Name</th>
      <th>Type</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>days_from_today</code></td>
      <td>integer</td>
      <td>
        You can query other route days of the week other than today. You can send how many days ahead you want to query.<br>
        <i>Example: If you want the day after tomorrow's route just send 2 as parameter.<br>
           Must be a number between 0 and 6
        </i>
      </td>
    </tr>
  </tbody>
</table>

<br>
<br>
<br>
<br>
<br>
<br>
<br>

@endsection
