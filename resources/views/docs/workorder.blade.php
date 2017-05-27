@extends('docs.layout')

@section('content')

<h1>Work Order and Works</h1>

<ul class="toc">
  <li>
    <a href="#workorder">Work Order</a>
    <ul>
      <li><a href="#works">Works</a></li>
    </ul>
  </li>
</ul>

<br>
<br>

<h1 id="workorder">Work Order</h1>

<p>
    The <code>workorder</code> is the way of employes to registered the workorder after the pool has been serviced
</p>

<h2>Resource Representation</h2>
<h4>Work Order</h4>
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
        <td>person</td>
        <td>integer</td>
        <td>The id of <code>user-role</code> who opened the workorder.</td>
      </tr>
       <tr>
        <td>service</td>
        <td>integer</td>
        <td>The id of <code>service</code> <i>(pool)</i> this work order is acting upon.</td>
      </tr>
      <tr>
        <td>title</td>
        <td>string</td>
        <td>Name to help identify the <code>workorder</code> quickly.</td>
      </tr>
      <tr>
        <td>start</td>
        <td>datetime</td>
        <td>The date and time when <code>workorder</code> was started.</td>
      </tr>
      <tr>
        <td>end</td>
        <td>datetime</td>
        <td>The date and time when <code>workorder</code> was finished.</td>
      </tr>
      <tr>
        <td>price</td>
        <td>numeric</td>
        <td>The <code>workorder</code> price.</td>
      </tr>
       <tr>
        <td>currency</td>
        <td>string</td>
        <td>The currency the price is on based. <i>Accept <a href="http://www.xe.com/iso4217.php" target="_blank">ISO 4217 Code</a> currency format</i></td>
      </tr>
       <tr>
        <td>description</td>
        <td>text</td>
        <td>A more detailed description of the <code>workorder</code> in question.</td>
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
      <td><a href="#list_workorder">List workorders</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/workorders</td>
      <td>Returns a list of all <code>workorders</code> in your company.</td>
    </tr>
    <tr>
      <td><a href="#create_workorder">Create workorder</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-warning"><strong>POST</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/workorders</td>
      <td>Creates new <code>workorder</code>.</td>
    </tr>
    <tr>
      <td><a href="#view_workorder">View a workorder</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/workorders/{id}</td>
      <td>Returns <code>workorder</code> information.</td>
    </tr>
    <tr>
      <td><a href="#update_workorder">Update a workorder</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-default"><strong>PATCH</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/workorders/{id}</td>
      <td>Updates <code>workorder</code> information.</td>
    </tr>
    <tr>
      <td><a href="#delete_workorder">Delete a workorder</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-danger"><strong>DELETE</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/workorders/{id}</td>
      <td>Deletes the <code>workorder</code>.</td>
    </tr>
    <tr>
      <td><a href="#finish_workorder">Finish a workorder</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-warning"><strong>POST</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/workorders/{id}/finish</td>
      <td>Marks the <code>workorder</code> as finished.</td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="list_workorder">List Work Orders</h3>

<p>Returns a list of the <code>workorders</code> in your company</p>
<p>You can query based on various parameters</p>
<br>
<pre>
    GET  {{url ('/api/v1/workorders') }}
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
      <td><code>finished</code></td>
      <td>boolean</td>
      <td>Filter <code>workorders</code> if they are finished or not.</td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="create_workorder">Create Work Order</h3>

<p>Create a new <code>workorder</code> in your company</p>
<br>
<pre>
    POST  {{url ('/api/v1/workorders') }}
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
        <td><code>person</code></td>
        <td>integer</td>
        <td>The id of <code>user-role</code> who opened the workorder.</td>
      </tr>
       <tr>
        <td><code>service</code></td>
        <td>integer</td>
        <td>The id of <code>service</code> <i>(pool)</i> this work order is acting upon.</td>
      </tr>
      <tr>
        <td><code>title</code></td>
        <td>string</td>
        <td>Name to help identify the <code>workorder</code> quickly.</td>
      </tr>
      <tr>
        <td><code>start</code></td>
        <td>datetime</td>
        <td>The date and time when <code>workorder</code> was started.</td>
      </tr>
      <tr>
        <td><code>price</code></td>
        <td>numeric</td>
        <td>The <code>workorder</code> price.</td>
      </tr>
       <tr>
        <td><code>currency</code></td>
        <td>string</td>
        <td>The currency the price is on based. <i>Accept <a href="http://www.xe.com/iso4217.php" target="_blank">ISO 4217 Code</a> currency format</i></td>
      </tr>
       <tr>
        <td><code>description</code></td>
        <td>text</td>
        <td>A more detailed description of the <code>workorder</code> in question.</td>
      </tr>
      <tr>
        <td><code>photos</code></td>
        <td>array</td>
        <td>Array of file photos of the pool before the <code>workorder</code> has started.</td>
      </tr>
    </tbody>
</table>

<br>

<h3 id="view_workorder">View Work Order</h3>

<p>Returns <code>workorder</code> information.</p>
<br>
<pre>
    GET  {{url ('/api/v1/workorders/{workorder_id}') }}
</pre>
<br>

<h3 id="update_workorder">Update Work Order</h3>

<p>Update the <code>workorder</code> information.</p>
<br>
<pre>
    PATCH  {{url ('/api/v1/workorders/{workorder_id}') }}
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
        <td><code>service</code></td>
        <td>integer</td>
        <td>The id of <code>service</code> <i>(pool)</i> this work order is acting upon.</td>
      </tr>
      <tr>
        <td><code>title</code></td>
        <td>string</td>
        <td>Name to help identify the <code>workorder</code> quickly.</td>
      </tr>
      <tr>
        <td><code>start</code></td>
        <td>datetime</td>
        <td>The date and time when <code>workorder</code> was started.</td>
      </tr>
       <tr>
        <td><code>description</code></td>
        <td>text</td>
        <td>A more detailed description of the <code>workorder</code> in question.</td>
      </tr>
      <tr>
        <td><code>add_photos</code></td>
        <td>array</td>
        <td>Array of file photos of the pool before the <code>workorder</code> has started.</td>
      </tr>
      <tr>
        <td><code>remove_photos</code></td>
        <td>array</td>
        <td>Array of integers of the order of the <code>workorder</code> photo you want to remove.</td>
      </tr>
    </tbody>
</table>

<br>

<h3 id="delete_workorder">Delete Work Order</h3>

<p>Delete the <code>workorder</code>.</p>
<br>
<pre>
    DELETE  {{url ('/api/v1/workorders/{workorder_id}') }}
</pre>

<br>

<h3 id="finish_workorder">Finish Work Order</h3>

<p>Mark the <code>workorder</code> as finished.</p>
<br>
<pre>
    POST  {{url ('/api/v1/workorders/{workorder_id}/finish') }}
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
        <td><code>end</code></td>
        <td>dateTime</td>
        <td>The date and time when the <code>workorder</code> was finished.</td>
      </tr>
      <tr>
        <td><code>photos</code></td>
        <td>array</td>
        <td>Array of file photos of the pool after the <code>workorder</code> has finished.</td>
      </tr>
    </tbody>
</table>

<br>
<br>
<br>

<h1 id="works">Work</h1>

<p>
    The <code>work</code> is a record of operations (work) that are part of the <code>workorder</code>.
</p>

<br>

<h2>Resource Representation</h2>
<h4>Work</h4>
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
        <td>person</td>
        <td>integer</td>
        <td>The id of <code>user-role</code> who opened the workorder.</td>
      </tr>
      <tr>
        <td>title</td>
        <td>string</td>
        <td>Name to help identify the <code>work</code> quickly.</td>
      </tr>
       <tr>
        <td>quantity</td>
        <td>numeric</td>
        <td>The quantity of whatever was executed as <code>work</code>. <i>Example: pool tiles, concrete, manhours</i></td>
      </tr>
       <tr>
        <td>units</td>
        <td>string</td>
        <td>The units of the quantity</td>
      </tr>
       <tr>
        <td>cost</td>
        <td>numeric</td>
        <td>Cost that this work generated. <i>Note costs are in the <code>workorder</code> currency</i></td>
      </tr>
       <tr>
        <td>description</td>
        <td>text</td>
        <td>A more detailed description of the <code>workorder</code> in question.</td>
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
      <td><a href="#list_work">List works</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/workorders/{id}/work</td>
      <td>Returns a list of all <code>works</code> in your company.</td>
    </tr>
    <tr>
      <td><a href="#create_work">Create work</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-warning"><strong>POST</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/workorders/{id}/work</td>
      <td>Creates a new <code>work</code>.</td>
    </tr>
    <tr>
      <td><a href="#view_work">View a work</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/works/{id}</td>
      <td>Returns <code>work</code> information.</td>
    </tr>
    <tr>
      <td><a href="#update_work">Update a work</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-default"><strong>PATCH</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/works/{id}</td>
      <td>Updates <code>work</code> information.</td>
    </tr>
    <tr>
      <td><a href="#delete_work">Delete a work</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-danger"><strong>DELETE</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/works/{id}</td>
      <td>Deletes the <code>work</code>.</td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="list_work">List Work</h3>

<p>Returns a list of the <code>work</code>.</p>
<p>You can query based on various parameters</p>
<br>
<pre>
    GET  {{url ('/api/v1/workorders/{workorder_id}/work') }}
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

<h3 id="create_work">Create Work</h3>

<p>Create a new <code>work</code> in your company</p>
<br>
<pre>
    POST  {{url ('/api/v1/workorders/{workorder_id}/work') }}
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
        <td><code>person</code></td>
        <td>integer</td>
        <td>The id of <code>user-role</code> who opened the workorder.</td>
      </tr>
      <tr>
        <td><code>title</code></td>
        <td>string</td>
        <td>Name to help identify the <code>work</code> quickly.</td>
      </tr>
       <tr>
        <td><code>quantity</code></td>
        <td>numeric</td>
        <td>The quantity of whatever was executed as <code>work</code>. <i>Example: pool tiles, concrete, manhours</i></td>
      </tr>
       <tr>
        <td><code>units</code></td>
        <td>string</td>
        <td>The units of the quantity</td>
      </tr>
       <tr>
        <td><code>cost</code></td>
        <td>numeric</td>
        <td>Cost that this work generated. <i>Note costs are in the <code>workorder</code> currency</i></td>
      </tr>
       <tr>
        <td><code>description</code></td>
        <td>text</td>
        <td>A more detailed description of the <code>work</code> in question.</td>
      </tr>
       <tr>
        <td><code>photos</code></td>
        <td>array</td>
        <td>Array of file photos of the <code>work</code>.</td>
      </tr>
    </tbody>
</table>

<br>

<h3 id="view_work">View Work</h3>

<p>Returns <code>workorder</code> information.</p>
<br>
<pre>
    GET  {{url ('/api/v1/work/{work_id}') }}
</pre>
<br>

<h3 id="update_work">Update Work</h3>

<p>Update the <code>workorder</code> information.</p>
<br>
<pre>
    PATCH  {{url ('/api/v1/work/{work_id}') }}
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
        <td><code>person</code></td>
        <td>integer</td>
        <td>The id of <code>user-role</code> who opened the workorder.</td>
      </tr>
      <tr>
        <td><code>title</code></td>
        <td>string</td>
        <td>Name to help identify the <code>work</code> quickly.</td>
      </tr>
      <tr>
        <td><code>quantity</code></td>
        <td>numeric</td>
        <td>The quantity of whatever was executed as <code>work</code>. <i>Example: pool tiles, concrete, manhours</i></td>
      </tr>
      <tr>
        <td><code>units</code></td>
        <td>string</td>
        <td>The units of the quantity</td>
      </tr>
      <tr>
        <td><code>cost</code></td>
        <td>numeric</td>
        <td>Cost that this work generated. <i>Note costs are in the <code>workorder</code> currency</i></td>
      </tr>
      <tr>
        <td><code>description</code></td>
        <td>text</td>
        <td>A more detailed description of the <code>work</code> in question.</td>
      </tr>
      <tr>
        <td><code>add_photos</code></td>
        <td>array</td>
        <td>Array of file photos of the <code>work</code>.</td>
      </tr>
      <tr>
        <td><code>remove_photos</code></td>
        <td>array</td>
        <td>Array of integers of the order of the <code>work</code> photo you want to remove.</td>
      </tr>
    </tbody>
</table>

<br>

<h3 id="delete_work">Delete Work</h3>

<p>Delete the <code>work</code>.</p>
<br>
<pre>
    DELETE  {{url ('/api/v1/work/{work_id}') }}
</pre>

<br>

@endsection
