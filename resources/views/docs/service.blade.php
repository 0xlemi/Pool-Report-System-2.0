@extends('docs.layout')

@section('content')


<h1>Service and Compontents</h1>

<ul class="toc">
  <li>
    <a href="#service">Service</a>
    <ul>
      <li><a href="#contract">Contract</a></li>
      <li><a href="#measurement">Measurements</a></li>
      <li><a href="#product">Products</a></li>
      <li><a href="#equipment">Equipment</a></li>
    </ul>
  </li>
</ul>

<br>

<h1 id="service">Service</h1>

<p>
    The <code>service</code> is a representation of the pool and the place where that resides. <br>
    You can attach alot of things to the <code>service</code> like: <code>contract</code>, <code>measurement</code>, <code>equipment</code> and <code>product</code>
</p>

<h2>Resource Representation</h2>
<h4>Service</h4>
<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>type</th>
        <th>description</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>name</td>
        <td>string</td>
        <td>Name to help identify the <code>service</code> quickly.</td>
      </tr>
      <tr>
        <td>address_line</td>
        <td>string</td>
        <td>The valid address of the <code>service</code>.</td>
      </tr>
      <tr>
        <td>city</td>
        <td>string</td>
        <td>The city where the <code>service</code> is located.</td>
      </tr>
       <tr>
        <td>state</td>
        <td>string</td>
        <td>The state where the <code>service</code> is located.</td>
      </tr>
      <tr>
        <td>postal_code</td>
        <td>string</td>
        <td>The postal code where the <code>service</code> is located.</td>
      </tr>
      <tr>
        <td>country</td>
        <td>string</td>
        <td>The country where the <code>service</code> is located.</td>
      </tr>
      <tr>
        <td>comments</td>
        <td>string</td>
        <td>Comments or specific information about the <code>service</code>.</td>
      </tr>
      <tr>
        <td>latitude</td>
        <td>numeric</td>
        <td>The <code>service</code> latitude location.</td>
      </tr>
      <tr>
        <td>longitude</td>
        <td>numeric</td>
        <td>The <code>service</code> longitude location.</td>
      </tr>
    </tbody>
  </table>
</div>

<h2>Actions</h2>

<div class="callout callout-info" role="alert">
    <ul>
        <li>
            All endpoints are relative to <a class="link--copy">{{ url('/api/v1') }}</a>
        </li>
        <li>
            All requests must be urlencoded.
        </li>
    </ul>
</div>

<table class="table table-bordered table-striped ">
  <thead>
    <tr>
      <th>Action</th>
      <th>HTTP request</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><a href="#list_service">List services</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/services</td>
      <td>Returns a list of all <code>services</code> in your company.</td>
    </tr>
    <tr>
      <td><a href="#create_service">Create service</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-warning"><strong>POST</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/services</td>
      <td>Creates new <code>service</code>.</td>
    </tr>
    <tr>
      <td><a href="#view_service">View a service</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/services/{id}</td>
      <td>Returns <code>service</code> information.</td>
    </tr>
    <tr>
      <td><a href="#update_service">Update a service</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-default"><strong>PATCH</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/services/{id}</td>
      <td>Updates <code>service</code> information.</td>
    </tr>
    <tr>
      <td><a href="#delete_service">Delete a service</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-danger"><strong>DELETE</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/services/{id}</td>
      <td>Deletes the <code>service</code>.</td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="list_service">List Services</h3>

<p>Returns a list of the <code>services</code> in your company</p>
<p>You can query based on various parameters</p>
<br>
<pre>
    GET  {{url ('/api/v1/services') }}
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
      <td><code>limit</code></td>
      <td>integer</td>
      <td>The number of results to be displayed per page. This value must be between 1 and 25. <i>Default: 5</i></td>
    </tr>
    <tr>
      <td><code>page</code></td>
      <td>integer</td>
      <td>Page of results selected.</td>
    </tr>
    <tr>
      <td><code>contract</code></td>
      <td>boolean</td>
      <td>Filter <code>services</code> by if they have an active <code>contract</code> or not.</td>
    </tr>
    <tr>
      <td><code>preview</code></td>
      <td>boolean</td>
      <td>Show a small preview of all <code>services</code>. <i>(great for dropdowns)</i></td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="create_service">Create Service</h3>

<p>Create a new <code>service</code> in your company</p>
<br>
<pre>
    POST  {{url ('/api/v1/services') }}
</pre>
<br>

<h5>Request body</h5>
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
        <td><code>name</code></td>
        <td>string</td>
        <td>Name to help identify the <code>service</code> quickly.</td>
      </tr>
      <tr>
        <td><code>address_line</code></td>
        <td>string</td>
        <td>The valid address of the <code>service</code>.</td>
      </tr>
      <tr>
        <td><code>city</code></td>
        <td>string</td>
        <td>The city where the <code>service</code> is located.</td>
      </tr>
       <tr>
        <td><code>state</code></td>
        <td>string</td>
        <td>The state where the <code>service</code> is located.</td>
      </tr>
      <tr>
        <td><code>postal_code</code></td>
        <td>string</td>
        <td>The postal code where the <code>service</code> is located.</td>
      </tr>
      <tr>
        <td><code>country</code></td>
        <td>string</td>
        <td>The country where the <code>service</code> is located.</td>
      </tr>
      <tr>
        <td><code>comments</code></td>
        <td>string</td>
        <td>Comments or specific information about the <code>service</code>.</td>
      </tr>
      <tr>
        <td><code>latitude</code></td>
        <td>numeric</td>
        <td>The <code>service</code> latitude location. <i>Must be a value between -90 and 90</i></td>
      </tr>
      <tr>
        <td><code>longitude</code></td>
        <td>numeric</td>
        <td>The <code>service</code> longitude location. <i>Must be a value between -180 and 180</i></td>
      </tr>
       <tr>
        <td><code>photo</code></td>
        <td>file</td>
        <td>The <code>service</code> photo. <i>Photo of the house or the pool.</i></td>
      </tr>
  </tbody>
</table>

<br>

<h3 id="view_service">View Service</h3>

<p>Returns <code>service</code> information.</p>
<br>
<pre>
    GET  {{url ('/api/v1/services/{service_id}') }}
</pre>
<br>

<h3 id="update_service">Update Service</h3>

<p>Update the <code>service</code> information.</p>
<br>
<pre>
    PATCH  {{url ('/api/v1/services/{service_id}') }}
</pre>
<br>

<h5>Request body</h5>
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
        <td><code>name</code></td>
        <td>string</td>
        <td><i><strong>(Optional)</strong></i> Name to help identify the <code>service</code> quickly.</td>
      </tr>
      <tr>
        <td><code>address_line</code></td>
        <td>string</td>
        <td><i><strong>(Optional)</strong></i> The valid address of the <code>service</code>.</td>
      </tr>
      <tr>
        <td><code>city</code></td>
        <td>string</td>
        <td><i><strong>(Optional)</strong></i> The city where the <code>service</code> is located.</td>
      </tr>
       <tr>
        <td><code>state</code></td>
        <td>string</td>
        <td><i><strong>(Optional)</strong></i> The state where the <code>service</code> is located.</td>
      </tr>
      <tr>
        <td><code>postal_code</code></td>
        <td>string</td>
        <td><i><strong>(Optional)</strong></i> The postal code where the <code>service</code> is located.</td>
      </tr>
      <tr>
        <td><code>country</code></td>
        <td>string</td>
        <td><i><strong>(Optional)</strong></i> The country where the <code>service</code> is located.</td>
      </tr>
      <tr>
        <td><code>comments</code></td>
        <td>string</td>
        <td><i><strong>(Optional)</strong></i> Comments or specific information about the <code>service</code>.</td>
      </tr>
      <tr>
        <td><code>latitude</code></td>
        <td>numeric</td>
        <td><i><strong>(Optional)</strong></i> The <code>service</code> latitude location. <i>Must be a value between -90 and 90</i></td>
      </tr>
      <tr>
        <td><code>longitude</code></td>
        <td>numeric</td>
        <td><i><strong>(Optional)</strong></i> The <code>service</code> longitude location. <i>Must be a value between -180 and 180</i></td>
      </tr>
       <tr>
        <td><code>photo</code></td>
        <td>file</td>
        <td><i><strong>(Optional)</strong></i> The <code>service</code> photo. <i>Photo of the house or the pool.</i></td>
      </tr>
  </tbody>
</table>

<br>

<h3 id="delete_service">Delete Service</h3>

<p>Delete the <code>service</code>.</p>
<br>
<pre>
    DELETE  {{url ('/api/v1/services/{service_id}') }}
</pre>

<br>
<br>
<br>

<h1 id="contract">Contract</h1>

<p>
    A <code>service</code> with out a <code>contract</code> is just a pool address.<br>
    <code>Contract</code> is the commitment that the pool is going to be serviced.<br>
    When you attach a <code>contract</code> to a <code>service</code> then the pool cleaning schedule and billing take place inside the system.
</p>

<h2>Resource Representation</h2>
<h4>Contract</h4>
<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>type</th>
        <th>description</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>start</td>
        <td>date</td>
        <td>Day the <code>contract</code> was started (for billing purpuses). <i>Example: If the <code>contract</code> was created in april 3th. The day 3th of every month the invoice is going to be generated.</i></td>
      </tr>
      <tr>
        <td>active</td>
        <td>boolean</td>
        <td>If the <code>service</code> is currently active. If inactive there is no going to be schedule or invioce generation.</td>
      </tr>
      <tr>
        <td>service_days</td>
        <td>array</td>
        <td>Days of the week in witch the <code>service</code> must be done.</td>
      </tr>
       <tr>
        <td>amount</td>
        <td>numeric</td>
        <td>The monthy price for doing this service.</td>
      </tr>
      <tr>
        <td>currency</td>
        <td>string</td>
        <td>The currency the amount is based. <i>Accept <a href="http://www.xe.com/iso4217.php" target="_blank">ISO 4217 Code</a> currency format</i></td>
      </tr>
      <tr>
        <td>start_time</td>
        <td>time</td>
        <td>The earliest in the day the <code>service</code> can be done.</td>
      </tr>
      <tr>
        <td>end_time</td>
        <td>time</td>
        <td>The latest in the day the <code>service</code> can be done.</td>
      </tr>
      <tr>
        <td>comments</td>
        <td>string</td>
        <td>Comments or specific information about the <code>contract</code>.</td>
      </tr>
    </tbody>
  </table>
</div>

<h2>Actions</h2>

<div class="callout callout-info" role="alert">
    <ul>
        <li>
            All endpoints are relative to <a class="link--copy">{{ url('/api/v1') }}</a>
        </li>
        <li>
            All requests must be urlencoded.
        </li>
    </ul>
</div>

<table class="table table-bordered table-striped ">
  <thead>
    <tr>
      <th>Action</th>
      <th>HTTP request</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><a href="#view_contract">View the contract</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/services/{id}/contract</td>
      <td>Returns <code>contract</code> information.</td>
    </tr>
    <tr>
      <td><a href="#create_update_contract">Create/Update a contract</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-warning"><strong>POST</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/services/{id}/contract</td>
      <td>Updates <code>contract</code> information.</td>
    </tr>
    <tr>
      <td><a href="#delete_contract">Delete a contract</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-danger"><strong>DELETE</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/services/{id}/contract</td>
      <td>Deletes the <code>contract</code>.</td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="view_contract">View Contract</h3>

<p>Returns <code>contract</code> information.</p>
<br>
<pre>
    GET  {{url ('/api/v1/services/{service_id}/contract') }}
</pre>
<br>

<h3 id="create_update_contract">Create/Update Contract</h3>

<p>Update the <code>contract</code> information.</p>
<br>
<pre>
    POST  {{url ('/api/v1/services/{service_id}/contract') }}
</pre>
<br>

<h5>Request body</h5>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>type</th>
        <th>description</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><code>start</code></td>
        <td>date</td>
        <td>Day the <code>contract</code> was started (for billing purpuses). <i>Example: If the <code>contract</code> was created in april 3th. The day 3th of every month the invoice is going to be generated.</i></td>
      </tr>
      <tr>
        <td><code>active</code></td>
        <td>boolean</td>
        <td>If the <code>service</code> is currently active. If inactive there is no going to be schedule or invioce generation.</td>
      </tr>
      <tr>
        <td><code>service_days</code></td>
        <td>array</td>
        <td>Days of the week in witch the <code>service</code> must be done.</td>
      </tr>
       <tr>
        <td><code>amount</code></td>
        <td>numeric</td>
        <td>The monthy price for doing this service.</td>
      </tr>
      <tr>
        <td><code>currency</code></td>
        <td>string</td>
        <td>The currency the amount is based. <i>Accept <a href="http://www.xe.com/iso4217.php" target="_blank">ISO 4217 Code</a> currency format</i></td>
      </tr>
      <tr>
        <td><code>start_time</code></td>
        <td>time</td>
        <td>The earliest in the day the <code>service</code> can be done.</td>
      </tr>
      <tr>
        <td><code>end_time</code></td>
        <td>time</td>
        <td>The latest in the day the <code>service</code> can be done.</td>
      </tr>
      <tr>
        <td><code>comments</code></td>
        <td>string</td>
        <td>Comments or specific information about the <code>contract</code>.</td>
      </tr>
    </tbody>
  </table>

<br>

<h3 id="delete_contract">Delete Contract</h3>

<p>Delete the <code>contract</code>.</p>
<br>
<pre>
    DELETE  {{url ('/api/v1/services/{service_id}/contract') }}
</pre>

<br>
<br>
<br>

<h1 id="measurement">Measurement</h1>

<p>
    A <code>mesurement</code> is the list of <code>global measurements</code> that you are going to measure in this specific <code>service</code><br>
    Depending on the <code>measurements</code> on the <code>service</code>, is going to determine the <code>readings</code> asked when createing a report associated to that <code>service</code>.
</p>

<h2>Resource Representation</h2>
<h4>Measurement</h4>
<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>type</th>
        <th>description</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>global_measurement</td>
        <td>date</td>
        <td>The id of the global measurement, this measurement is related to.</i></td>
      </tr>
    </tbody>
  </table>
</div>

<h2>Actions</h2>

<div class="callout callout-info" role="alert">
    <ul>
        <li>
            All endpoints are relative to <a class="link--copy">{{ url('/api/v1') }}</a>
        </li>
        <li>
            All requests must be urlencoded.
        </li>
    </ul>
</div>

<table class="table table-bordered table-striped ">
  <thead>
    <tr>
      <th>Action</th>
      <th>HTTP request</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><a href="#list_measurement">List measurements</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/services/{id}/measurements</td>
      <td>Returns a list of all <code>measurements</code> in your company.</td>
    </tr>
    <tr>
      <td><a href="#create_measurement">Create a measurements</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-warning"><strong>POST</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/services/{id}/measurements</td>
      <td>Updates <code>measurement</code> information.</td>
    </tr>
    <tr>
      <td><a href="#view_measurement">View the measurements</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/services/{id}/measurements</td>
      <td>Returns <code>measurement</code> information.</td>
    </tr>
    <tr>
      <td><a href="#delete_measurement">Delete a measurements</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-danger"><strong>DELETE</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/services/{id}/measurements</td>
      <td>Deletes the <code>measurement</code>.</td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="list_measurement">List Measurements</h3>

<p>Returns a list of the <code>measurements</code> that the service has attached.</p>
<p>You can query based on various parameters</p>
<br>
<pre>
    GET  {{url ('/api/v1/services/{service_id}/measurements') }}
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
      <td><code>limit</code></td>
      <td>integer</td>
      <td>The number of results to be displayed per page. This value must be between 1 and 25. <i>Default: 5</i></td>
    </tr>
    <tr>
      <td><code>page</code></td>
      <td>integer</td>
      <td>Page of results selected.</td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="create_measurement">Create Measurement</h3>

<p>Create the <code>measurement</code> information.</p>
<br>
<pre>
    POST  {{url ('/api/v1/services/{service_id}/measurements') }}
</pre>
<br>

<h5>Request body</h5>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>type</th>
        <th>description</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><code>global_measurement</code></td>
        <td>date</td>
        <td>The ID of the <code>global_measurement</code> you want to add to this <code>service</code>.</i></td>
      </tr>
    </tbody>
  </table>

<br>

<h3 id="view_measurement">View Measurement</h3>

<p>Returns <code>measurement</code> information.</p>
<br>
<pre>
    GET  {{url ('/api/v1/measurements/{measurement_id}') }}
</pre>

<br>

<h3 id="delete_measurement">Delete Measurement</h3>

<p>Delete the <code>measurement</code>.</p>
<br>
<pre>
    DELETE  {{url ('/api/v1/measurements/{measurement_id}') }}
</pre>


@endsection
