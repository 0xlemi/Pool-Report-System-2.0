@extends('docs.layout')

@section('content')

<h1>Company and Components</h1>

<ul class="toc">
  <li>
    <a href="#company">Company</a>
    <ul>
      <li><a href="#global_measurement">Global Measurements</a></li>
      <li><a href="#global_product">Global Products</a></li>
    </ul>
  </li>
</ul>

<br>
<br>
<br>

<h1 id="company">Company</h1>

<p>The <code>company</code> is the representation of the pool company organization, all you the other elements are linked to it.</p>

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

<br>
<br>
<br>

<h1 id="global_measurement">Global Measurement</h1>

<p>The <code>global measurements</code> are all the things the pool service company measures in a pool when doing a <code>report</code>.<br>
    Some come by default, but you can add your own depending on what your company needs to keep track of.<br>
    Also <code>global measurements</code> are all the <code>measurements</code> that your <code>company</code> is going to eventualy assign to the <code>service</code>.<br>
    <br>
    <i><strong>Note</strong>: You assign the <code>measurements</code> you like to each <code>service</code>. <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    So that if you have different pools that measure different things you only get asked for those ones when doing <code>reports</code>.<br></i>
</p>

<h2>Resource Representation</h2>
<h4>Global Measurements</h4>
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
        <td>The name of what you are measuring.</td>
      </tr>
      <tr>
        <td>labels</td>
        <td>array</td>
        <td>Are the options you can choose from a measurement.<br>
            Array must have 3 values:
            <ul>
                <li><code>name</code> : The name of the option.</li>
                <li><code>color</code> : The hex color code value for this option. <i>Without the # simbol</i></li>
                <li><code>value</code> : The integer order value that determines which option is higher and lower.</li>
            </ul>
        </td>
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
      <td><a href="#list_global_measurement">List global measurements</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/globalmeasurements</td>
      <td>Returns a list of all <code>global measurements</code> in your company.</td>
    </tr>
    <tr>
      <td><a href="#create_global_measurement">Create global measurement</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-warning"><strong>POST</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/globalmeasurements</td>
      <td>Creates new <code>globalmeasurement</code>.</td>
    </tr>
    <tr>
      <td><a href="#view_global_measurement">View a global measurement</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/globalmeasurements/{id}</td>
      <td>Returns <code>globalmeasurement</code> information.</td>
    </tr>
    <tr>
      <td><a href="#update_global_measurement">Update a global measurement</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-default"><strong>PATCH</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/globalmeasurements/{id}</td>
      <td>Updates <code>globalmeasurement</code> information.</td>
    </tr>
    <tr>
      <td><a href="#delete_global_measurement">Delete a global measurement</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-danger"><strong>DELETE</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/globalmeasurements/{id}</td>
      <td>Deletes the <code>globalmeasurement</code>.</td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="list_global_measurement">List Global Measurements</h3>

<p>Returns a list of all the <code>global measurements</code> in your company</p>
<p>You can query based on various parameters</p>
<br>
<pre>
    GET  {{url ('/api/v1/globalmeasurements') }}
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

<h3 id="create_global_measurement">Create Global Measurement</h3>

<p>Create a new <code>global measurement</code> in your company</p>
<br>
<pre>
    POST  {{url ('/api/v1/globalmeasurements') }}
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
        <td>The name of what you are measuring.</td>
      </tr>
      <tr>
        <td><code>labels</code></td>
        <td>array</td>
        <td>
            Are the options you can choose from a measurement.<br>
            Array must have 3 values:
            <ul>
                <li><code>name</code> : The name of the option.</li>
                <li><code>color</code> : The hex color code value for this option. <i>Without the # simbol</i></li>
                <li><code>value</code> : The integer order value that determines which option is higher and lower.</li>
            </ul>
        </td>
      </tr>
      <tr>
        <td><code>photos</code></td>
        <td>array</td>
        <td>Array of file photos of the <code>global measurement</code>.</td>
      </tr>
  </tbody>
</table>

<br>

<h3 id="view_global_measurement">View Global Measurement</h3>

<p>Returns <code>global measurement</code> information.</p>
<br>
<pre>
    GET  {{url ('/api/v1/globalmeasurements/{globalmeasurement_id}') }}
</pre>
<br>

<h3 id="update_global_measurement">Update Global Measurement</h3>

<p>Update the <code>global measurement</code> information.</p>
<br>
<pre>
    PATCH  {{url ('/api/v1/globalmeasurements/{globalmeasurement_id}') }}
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
        <td>The name of what you are measuring.</td>
      </tr>
      <tr>
        <td><code>add_labels</code></td>
        <td>array</td>
        <td>
            Add more options to the <code>global measurement</code>.<br>
            Array must have 3 values:
            <ul>
                <li><code>name</code> : The name of the option.</li>
                <li><code>color</code> : The hex color code value for this option. <i>Without the # simbol</i></li>
                <li><code>value</code> : The integer order value that determines which option is higher and lower.</li>
            </ul>
        </td>
      </tr>
      <tr>
        <td><code>remove_labels</code></td>
        <td>array</td>
        <td>
            Array of values of the options you want to remove from <code>global measurement</code>.
        </td>
      </tr>
      <tr>
        <td><code>add_photos</code></td>
        <td>array</td>
        <td>Array of file photos of the <code>global measurement</code>.</td>
      </tr>
      <tr>
        <td><code>remove_photos</code></td>
        <td>array</td>
        <td>Array of integers of the order of the photo you want to remove.</td>
      </tr>
  </tbody>
</table>

<br>

<h3 id="delete_global_measurement">Delete Global Measurement</h3>

<p>Delete the <code>global measurement</code>.</p>
<br>
<pre>
    DELETE  {{url ('/api/v1/globalmeasurements/{globalmeasurement_id}') }}
</pre>

<br>
<br>
<br>

<h1 id="global_product">Global Product</h1>

<p>
    The <code>global products</code> are a recolection of all the <code>products</code> (chemicals and consumables) your <code>company</code> uses in the different pools.<br>
    The main reason behind this is to keep track of the cost and inventory of the products you use in your <code>services</code>.
</p>

<h2>Resource Representation</h2>
<h4>Global Products</h4>
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
        <td>The name of the <code>global product</code>.</td>
      </tr>
      <tr>
        <td>brand</td>
        <td>string</td>
        <td>The name of the brand of this <code>global product</code>.</td>
      </tr>
      <tr>
        <td>type</td>
        <td>string</td>
        <td>What is the type or category this <code>global product</code> belongs.</td>
      </tr>
      <tr>
        <td>units</td>
        <td>string</td>
        <td>The units this <code>global product</code> is measured.</td>
      </tr>
      <tr>
        <td>unit_price</td>
        <td>numeric</td>
        <td>Price for a single unit of <code>global product</code>.</td>
      </tr>
      <tr>
        <td>unit_currency</td>
        <td>string</td>
        <td>The currency in which the <code>unit_price</code> is based. <i>Accept <a href="http://www.xe.com/iso4217.php" target="_blank">ISO 4217 Code</a> currency format</i></td>
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
      <td><a href="#list_global_product">List global products</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/globalproducts</td>
      <td>Returns a list of all <code>global products</code> in your company.</td>
    </tr>
    <tr>
      <td><a href="#create_global_product">Create global product</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-warning"><strong>POST</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/globalproducts</td>
      <td>Creates new <code>globalproduct</code>.</td>
    </tr>
    <tr>
      <td><a href="#view_global_product">View a global product</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/globalproducts/{id}</td>
      <td>Returns <code>globalproduct</code> information.</td>
    </tr>
    <tr>
      <td><a href="#update_global_product">Update a global product</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-default"><strong>PATCH</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/globalproducts/{id}</td>
      <td>Updates <code>globalproduct</code> information.</td>
    </tr>
    <tr>
      <td><a href="#delete_global_product">Delete a global product</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-danger"><strong>DELETE</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/globalproducts/{id}</td>
      <td>Deletes the <code>globalproduct</code>.</td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="list_global_product">List Global Products</h3>

<p>Returns a list of all the <code>global products</code> in your company</p>
<p>You can query based on various parameters</p>
<br>
<pre>
    GET  {{url ('/api/v1/globalproducts') }}
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

<h3 id="create_global_product">Create Global Product</h3>

<p>Create a new <code>global product</code> in your company</p>
<br>
<pre>
    POST  {{url ('/api/v1/globalproducts') }}
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
        <td>The name of the <code>global product</code>.</td>
      </tr>
      <tr>
        <td><code>brand</code></td>
        <td>string</td>
        <td>The name of the brand of this <code>global product</code>.</td>
      </tr>
      <tr>
        <td><code>type</code></td>
        <td>string</td>
        <td>What is the type or category this <code>global product</code> belongs.</td>
      </tr>
      <tr>
        <td><code>units</code></td>
        <td>string</td>
        <td>The units this <code>global product</code> is measured.</td>
      </tr>
      <tr>
        <td><code>unit_price</code></td>
        <td>numeric</td>
        <td>Price for a single unit of <code>global product</code>.</td>
      </tr>
      <tr>
        <td><code>unit_currency</code></td>
        <td>string</td>
        <td>The currency in which the <code>unit_price</code> is based. <i>Accept <a href="http://www.xe.com/iso4217.php" target="_blank">ISO 4217 Code</a> currency format</i></td>
      </tr>
       <tr>
        <td><code>photos</code></td>
        <td>array</td>
        <td>Array of file photos of the <code>global product</code>.</td>
      </tr>
  </tbody>
</table>

<br>

<h3 id="view_global_product">View Global Product</h3>

<p>Returns <code>global product</code> information.</p>
<br>
<pre>
    GET  {{url ('/api/v1/globalproducts/{globalproduct_id}') }}
</pre>
<br>

<h3 id="update_global_product">Update Global Product</h3>

<p>Update the <code>global product</code> information.</p>
<br>
<pre>
    PATCH  {{url ('/api/v1/globalproducts/{globalproduct_id}') }}
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
        <td>The name of the <code>global product</code>.</td>
      </tr>
      <tr>
        <td><code>brand</code></td>
        <td>string</td>
        <td>The name of the brand of this <code>global product</code>.</td>
      </tr>
      <tr>
        <td><code>type</code></td>
        <td>string</td>
        <td>What is the type or category this <code>global product</code> belongs.</td>
      </tr>
      <tr>
        <td><code>units</code></td>
        <td>string</td>
        <td>The units this <code>global product</code> is measured.</td>
      </tr>
      <tr>
        <td><code>unit_price</code></td>
        <td>numeric</td>
        <td>Price for a single unit of <code>global product</code>.</td>
      </tr>
      <tr>
        <td><code>unit_currency</code></td>
        <td>string</td>
        <td>The currency in which the <code>unit_price</code> is based. <i>Accept <a href="http://www.xe.com/iso4217.php" target="_blank">ISO 4217 Code</a> currency format</i></td>
      </tr>
      <tr>
        <td><code>add_photos</code></td>
        <td>array</td>
        <td>Array of file photos of the <code>global product</code>.</td>
      </tr>
      <tr>
        <td><code>remove_photos</code></td>
        <td>array</td>
        <td>Array of integers of the order of the photo you want to remove.</td>
      </tr>
  </tbody>
</table>

<br>

<h3 id="delete_global_product">Delete Global Product</h3>

<p>Delete the <code>global product</code>.</p>
<br>
<pre>
    DELETE  {{url ('/api/v1/globalproducts/{globalproduct_id}') }}
</pre>

<br>
<br>
<br>


@endsection
