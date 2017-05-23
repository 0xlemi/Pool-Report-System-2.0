@extends('docs.layout')

@section('content')
<h1>Company</h1>

<p>The company is the representation of the pool company organization, all you the other elements are linked to it.</p>

<h2>Resource Representation</h2>
<h4>Company</h4>
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
        <td>The <code>company</code> name.</td>
      </tr>
      <tr>
        <td>timezone</td>
        <td>string</td>
        <td>The <code>company</code> timezone. The timezone is in the <a href="https://gist.github.com/ykessler/3349960" target="_blank">Olson Format</a></td>
      </tr>
      <tr>
        <td>website</td>
        <td>string</td>
        <td>The <code>company</code> website url.</td>
      </tr>
      <tr>
        <td>facebook</td>
        <td>string</td>
        <td>The <code>company</code> facebook username.</td>
      </tr>
      <tr>
        <td>twitter</td>
        <td>string</td>
        <td>The <code>company</code> twitter username.</td>
      </tr>
      <tr>
        <td>language</td>
        <td>string</td>
        <td>The language users created in your <code>company</code> are going to default to.</td>
      </tr>
      <tr>
        <td>latitude</td>
        <td>numeric</td>
        <td>The <code>company</code> location latitude.</td>
      </tr>
      <tr>
        <td>longitude</td>
        <td>numeric</td>
        <td>The <code>company</code> location longitude.</td>
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
      <td><a href="#view_company">View a company</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/company</td>
      <td>Returns <code>company</code> information.</td>
    </tr>
    <tr>
      <td><a href="#update_company">Update a company</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-default"><strong>PATCH</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/company</td>
      <td>Updates <code>company</code> information.</td>
    </tr>
    <tr>
      <td><a href="#delete_company">Delete a company</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-danger"><strong>DELETE</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/company</td>
      <td>Deletes the <code>company</code>.</td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="view_company">View Company</h3>

<p>Returns <code>company</code> information.</p>
<br>
<pre>
    GET  {{url ('/api/v1/company/{company_id}') }}
</pre>
<br>

<h3 id="update_company">Update Company</h3>

<p>Update the <code>company</code> information.</p>
<br>
<pre>
    PATCH  {{url ('/api/v1/company/{company_id}') }}
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
      <td><i><strong>(Optional)</strong></i> The <code>company</code> name.</td>
    </tr>
    <tr>
      <td><code>timezone</code></td>
      <td>string</td>
      <td><i><strong>(Optional)</strong></i> The <code>company</code> cellphone number.</td>
    </tr>
    <tr>
      <td><code>website</code></td>
      <td>string</td>
      <td><i><strong>(Optional)</strong></i> The <code>company</code> website url.</td>
    </tr>
    <tr>
      <td><code>facebook</code></td>
      <td>string</td>
      <td><i><strong>(Optional)</strong></i> The <code>company</code> facebook username.</td>
    </tr>
        <tr>
      <td><code>twitter</code></td>
      <td>string</td>
      <td><i><strong>(Optional)</strong></i> The <code>company</code> twitter username.</td>
    </tr>
        <tr>
      <td><code>language</code></td>
      <td>string</td>
      <td><i><strong>(Optional)</strong></i> The <code>company</code> default users language.</td>
    </tr>
        <tr>
      <td><code>latitude</code></td>
      <td>numeric</td>
      <td><i><strong>(Optional)</strong></i> The <code>company</code> location latitude. <i>Must be a value between -90 and 90</i></td>
    </tr>
        <tr>
      <td><code>longitude</code></td>
      <td>numeric</td>
      <td><i><strong>(Optional)</strong></i> The <code>company</code> location longitude. <i>Must be a value between -180 and 180</i></td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="delete_company">Delete Company</h3>

<p>Delete the <code>company</code>.</p>
<br>
<pre>
    DELETE  {{url ('/api/v1/company/{company_id}') }}
</pre>

@endsection
