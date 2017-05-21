@extends('docs.layout')

@section('content')
<h1>User / Roles</h1>

<p>Users can have multiple roles, this roles are associated to a specific company.<br> Using the Api you can manage the attributes of the users and also the attributes of the <code>user-roles</code> that user possesses.</p>

<h2>Resource Representation</h2>
<h4>User</h4>
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
        <td>The user's name.</td>
      </tr>
      <tr>
        <td>last_name</td>
        <td>string</td>
        <td>The user's last name.</td>
      </tr>
      <tr>
        <td>email</td>
        <td>string</td>
        <td>The users's valid email.</td>
      </tr>
       <tr>
        <td>password</td>
        <td>string</td>
        <td>The user's password (this is only for edit).</td>
      </tr>
      <tr>
        <td>language</td>
        <td>string</td>
        <td>The user's language preference.</td>
      </tr>
    </tbody>
  </table>
</div>

<br>
<h4>User-Role</h4>
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
        <td>id</td>
        <td>integer</td>
        <td>Autoincrementing unique identifier.</td>
      </tr>
      <tr>
        <td>cellphone</td>
        <td>string</td>
        <td>The role cellphone.</td>
      </tr>
      <tr>
        <td>address</td>
        <td>string</td>
        <td>The role address.</td>
      </tr>
      <tr>
        <td>about</td>
        <td>text</td>
        <td>The role description and unique information.</td>
      </tr>
       <tr>
        <td>chat_id</td>
        <td>uuid</td>
        <td>Unique identifier for the chat system (sendbird).</td>
      </tr>
       <tr>
        <td>chat_nickname</td>
        <td>string</td>
        <td>Role nickname for the chat system (sendbird).</td>
      </tr>
       <tr>
        <td>chat_token</td>
        <td>string</td>
        <td>Authentication token for the chat system (sendbird).</td>
      </tr>
      <tr>
        <td>type</td>
        <td>integer</td>
        <td>The meaning depends on the type of role.</td>
      </tr>
       <tr>
        <td>selected</td>
        <td>boolean</td>
        <td>If true this is the <code>user-role</code> the user currently wants to play as.</td>
      </tr>
       <tr>
        <td>accepted</td>
        <td>boolean</td>
        <td>The user has accepted this <code>user-role</code>, in the case another user craeted the role for him.</td>
      </tr>
       <tr>
        <td>paid</td>
        <td>boolean</td>
        <td>This <code>user-role</code> is registed as a paying or unactive.</td>
      </tr>
    </tbody>
  </table>
</div>

<br>

<h4>Possible Roles</h4>

 <table class="table table-bordered table-striped ">
  <thead>
    <tr>
      <th>Icon</th>
      <th>Name</th>
      <th>Details</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><i class="glyphicon glyphicon-cog"></td>
      <td>admin</td>
      <td>System Administrator has all the system permissions, can change company information.</td>
    </tr>
    <tr>
      <td><i class="glyphicon glyphicon-user"></td>
      <td>client</td>
      <td>Pool company clients, they can see their pool reports, work orders and invoices.</td>
    </tr>
    <tr>
      <td><i class="glyphicon glyphicon-eye-open"></td>
      <td>sup</td>
      <td>Pool company Supervisor, more permissions than technican. But less permissions that System Administrator.</td>
    </tr>
    <tr>
      <td><i class="glyphicon glyphicon-wrench"></td>
      <td>tech</td>
      <td>Pool company technician, has the least amount of permissions by default.</td>
    </tr>
  </tbody>
</table>

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
      <td><a href="#list_user_role">List user-roles</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/userrolecompanies</td>
      <td>Returns a list of all <code>user-roles</code> in your company.</td>
    </tr>
    <tr>
      <td><a href="#create_user_role">Create user-roles</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-warning"><strong>POST</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/userrolecompanies</td>
      <td>Creates new <code>user-role</code>. And if it don't exists also creates the user.</td>
    </tr>
    <tr>
      <td><a href="#view_user_role">View a user-role</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-success"><strong>GET</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/userrolecompanies</td>
      <td>Returns <code>user-role</code> information.</td>
    </tr>
    <tr>
      <td><a href="#update_user_role">Update a user-role</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-default"><strong>PATCH</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/userrolecompanies</td>
      <td>Updates <code>user-role</code> information.</td>
    </tr>
    <tr>
      <td><a href="#delete_user_role">Delete a user-role</a></td>
      <td><h6 style="display: inline-block;"><span class="label label-danger"><strong>DELETE</strong></span></h6>&nbsp;&nbsp;&nbsp;&nbsp;/userrolecompanies</td>
      <td>Deletes the <code>user-role</code>.</td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="list_user_role">List User-Roles</h3>

<p>Returns a list of the <code>users-roles</code> in your company</p>
<p>You can query based on various parameters</p>
<br>
<pre>
    GET  {{url ('/api/v1/userrolecompanies') }}
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
      <td><code>role</code></td>
      <td>string</td>
      <td>Filter <code>user-roles</code> by role name. Example: admin, client, sup and tech.</td>
    </tr>
    <tr>
      <td><code>preview</code></td>
      <td>boolean</td>
      <td>Show a small preview of all <code>user-roles</code>. <i>(great for dropdowns)</i></td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="create_user_role">Create User-Roles</h3>

<p>Create a new <code>user-role</code> in your company</p>
<p>
    User-roles are identified by a unique ID.<br>
    When creating a user-role you can eather create a new user or attache it to existing one.<br>
    That depends on weather the email is already in use.
</p>
<br>
<pre>
    POST  {{url ('/api/v1/userrolecompanies') }}
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
      <td>The <code>user</code> first name. <i>(this is only used if creating a new user)</i></td>
    </tr>
    <tr>
      <td><code>last_name</code></td>
      <td>string</td>
      <td>The <code>user</code> last name. <i>(this is only used if creating a new user)</i></td>
    </tr>
    <tr>
      <td><code>cellphone</code></td>
      <td>string</td>
      <td>The <code>user-role</code> cellphone number.</td>
    </tr>
    <tr>
      <td><code>address</code></td>
      <td>string</td>
      <td>The <code>user-role</code> home address.</td>
    </tr>
    <tr>
      <td><code>language</code></td>
      <td>string</td>
      <td>The <code>user-role</code> language preference.</td>
    </tr>
    <tr>
      <td><code>type</code></td>
      <td>integer</td>
      <td>The type of <code>user-role</code> this is, it depends one the role it has.</td>
    </tr>
    <tr>
      <td><code>about</code></td>
      <td>string</td>
      <td>Extra information or description about this <code>user-role</code>.</td>
    </tr>
    <tr>
      <td><code>email</code></td>
      <td>string</td>
      <td>The <code>user</code> email. If there is a <code>user</code> with this email we attache the <code>user-role</code> to it, if not it creates a new one with this email.</td>
    </tr>
    <tr>
      <td><code>role</code></td>
      <td>string</td>
      <td>The role this <code>user-role</code> shoud have. Example: admin, client, sup and tech.</td>
    </tr>
    <tr>
      <td><code>photo</code></td>
      <td>file</td>
      <td>Profile photo attached to this <code>user-role</code>.</td>
    </tr>
    <tr>
      <td><code>add_service</code></td>
      <td>array</td>
      <td>Array of services ids that this <code>user-role</code> owns.</td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="view_user_role">View User-Roles</h3>

<p>Returns <code>user-role</code> information.</p>
<br>
<pre>
    GET  {{url ('/api/v1/userrolecompanies/{user_role_company_id}') }}
</pre>
<br>

<h3 id="update_user_role">Update User-Roles</h3>

<p>Update the <code>user-role</code> information.</p>
<br>
<pre>
    PATCH  {{url ('/api/v1/userrolecompanies/{user_role_company_id}') }}
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
      <td><code>cellphone</code></td>
      <td>string</td>
      <td><i><strong>(Optional)</strong></i> The <code>user-role</code> cellphone number.</td>
    </tr>
    <tr>
      <td><code>address</code></td>
      <td>string</td>
      <td><i><strong>(Optional)</strong></i> The <code>user-role</code> home address.</td>
    </tr>
    <tr>
      <td><code>type</code></td>
      <td>integer</td>
      <td><i><strong>(Optional)</strong></i> The type of <code>user-role</code> this is, it depends one the role it has.</td>
    </tr>
    <tr>
      <td><code>about</code></td>
      <td>string</td>
      <td><i><strong>(Optional)</strong></i> Extra information or description about this <code>user-role</code>.</td>
    </tr>
    <tr>
      <td><code>photo</code></td>
      <td>file</td>
      <td><i><strong>(Optional)</strong></i> Profile photo attached to this <code>user-role</code>.</td>
    </tr>
    <tr>
      <td><code>add_service</code></td>
      <td>array</td>
      <td><i><strong>(Optional)</strong></i> Array of services ids that you want to add to the <code>user-role</code>.</td>
    </tr>
    <tr>
      <td><code>remove_service</code></td>
      <td>array</td>
      <td><i><strong>(Optional)</strong></i> Array of services ids that you want to remove from the <code>user-role</code>.</td>
    </tr>
  </tbody>
</table>

<br>

<h3 id="delete_user_role">Delete User-Roles</h3>

<p>Delete the <code>user-role</code>.</p>
<br>
<pre>
    DELETE  {{url ('/api/v1/userrolecompanies/{user_role_company_id}') }}
</pre>


@endsection
