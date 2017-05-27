@extends('docs.layout')

@section('content')
<h1>Invoice / Payments</h1>

<ul class="toc">
  <li>
    <a href="#invoice">Invoice</a>
    <ul>
      <li><a href="#payment">Payments</a></li>
    </ul>
  </li>
</ul>

<br>
<br>

<h1 id="invoice">Invoice</h1>

<p>
    The <code>invoices</code> are generated when service <code>contract</code> is do, or when a <code>workorder</code> is created.
</p>

<h2>Resource Representation</h2>
<h4>Invoice</h4>
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
        <td>closed</td>
        <td>date</td>
        <td>The date when the <code>invoice</code> was closed (paid).</td>
      </tr>
      <tr>
        <td>amount</td>
        <td>numeric</td>
        <td>The monthy price for doing this service.</td>
      </tr>
      <tr>
        <td>currency</td>
        <td>string</td>
        <td>The currency the amount is based on.</td>
      </tr>
      <tr>
        <td>description</td>
        <td>text</td>
        <td>A more detailed description of the <code>invoice</code> in question.</td>
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
      <td><a href="#list_invoice">List invoices</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/invoices</td>
      <td>Returns a list of all <code>invoices</code> in your company.</td>
    </tr>
    <tr>
      <td><a href="#view_invoice">View a invoice</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/invoices/{id}</td>
      <td>Returns <code>invoice</code> information.</td>
    </tr>
    <tr>
      <td><a href="#delete_invoice">Delete a invoice</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-danger"><strong>DELETE</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/invoices/{id}</td>
      <td>Deletes the <code>invoice</code>.</td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="list_invoice">List Invoices</h3>

<p>Returns a list of the <code>invoices</code> in your company</p>
<p>You can query based on various parameters</p>
<br>
<pre>
    GET  {{url ('/api/v1/invoices') }}
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
      <td><code>closed</code></td>
      <td>boolean</td>
      <td>Filter <code>invoices</code> if they are closed or not.</td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="view_invoice">View Invoice</h3>

<p>Returns <code>invoice</code> information.</p>
<br>
<pre>
    GET  {{url ('/api/v1/invoices/{invoice_id}') }}
</pre>
<br>

<h3 id="delete_invoice">Delete Invoice</h3>

<p>Delete the <code>invoice</code>.</p>
<br>
<pre>
    DELETE  {{url ('/api/v1/invoices/{invoice_id}') }}
</pre>

<br>
<br>
<br>

<h1 id="payment">Payment</h1>

<p>
    The <code>payment</code> how to register payments in invoices.
</p>

<h2>Resource Representation</h2>
<h4>Payment</h4>
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
        <td>amount</td>
        <td>numeric</td>
        <td>The ammount paid in this payment. <i><strong>Amount is in the invoice currency</strong></i></td>
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
      <td><a href="#list_payment">List payments</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/invoices/{id}/payments</td>
      <td>Returns a list of all <code>payments</code> in your company.</td>
    </tr>
    <tr>
      <td><a href="#create_payment">Create a payment</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-warning"><strong>POST</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/invoices/{id}/payments</td>
      <td>Returns <code>payment</code> information.</td>
    </tr>
    <tr>
      <td><a href="#view_payment">View a payment</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/payments/{id}</td>
      <td>Returns <code>payment</code> information.</td>
    </tr>
    <tr>
      <td><a href="#delete_payment">Delete a payment</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-danger"><strong>DELETE</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/payments/{id}</td>
      <td>Deletes the <code>payment</code>.</td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="list_payment">List Payments</h3>

<p>Returns a list of the <code>payments</code> of the invoice</p>
<p>You can query based on various parameters</p>
<br>
<pre>
    GET  {{url ('/api/v1/invoice/{invoice_id}/payments') }}
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

<h3 id="create_payment">Create Payment</h3>

<p>Create a new <code>payment</code> for the invoice.</p>
<br>
<pre>
    POST  {{url ('/api/v1/invoice/{invoice_id}/payments') }}
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
        <td><code>amount</code></td>
        <td>numeric</td>
        <td>The ammount paid in this payment. <i><strong>Amount is in the invoice currency</strong></i></td>
      </tr>
    </tbody>
</table>

<br>

<h3 id="view_payment">View Payment</h3>

<p>Returns <code>payment</code> information.</p>
<br>
<pre>
    GET  {{url ('/api/v1/payments/{payment_id}') }}
</pre>
<br>

<h3 id="delete_payment">Delete Payment</h3>

<p>Delete the <code>payment</code>.</p>
<br>
<pre>
    DELETE  {{url ('/api/v1/payments/{payment_id}') }}
</pre>

@endsection
