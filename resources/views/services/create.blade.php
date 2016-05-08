@extends('layouts.app')

@section('content')
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>Create Service</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="{{ url('services') }}">Services</a></li>
						<li class="active">Create Service</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xl-8 col-xl-offset-2">
			<section class="card">
					<header class="card-header card-header-lg">
						Service info:
					</header>
					<div class="card-block">
						<form method="POST" action="{{ url('services') }}" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="form-group row {{($errors->has('name'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Name:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="name" maxlength="20" value="{{ old('name') }}">
									@if ($errors->has('name'))
										<small class="text-muted">{{ $errors->first('name') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('address_line'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Street and number:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="address_line" maxlength="50" value="{{ old('address_line') }}">
									@if ($errors->has('address_line'))
										<small class="text-muted">{{ $errors->first('address_line') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('city'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">City:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="city" maxlength="30" value="{{ old('city') }}">
									@if ($errors->has('city'))
										<small class="text-muted">{{ $errors->first('city') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('state'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">State:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="state" maxlength="30" value="{{ old('state') }}">
									@if ($errors->has('state'))
										<small class="text-muted">{{ $errors->first('state') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('postal_code'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Postal Code:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="postal_code" maxlength="15" value="{{ old('postal_code') }}">
									@if ($errors->has('postal_code'))
										<small class="text-muted">{{ $errors->first('postal_code') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('country'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Country:</label>
								<div class="col-sm-10">
									<select class="bootstrap-select" data-live-search="true"
											name="country">
										<option value="US" {{ (old('country') == 'US') ? 'selected':'' }}>United States</option>
										<option value="MX" {{ (old('country') == 'MX') ? 'selected':'' }}>Mexico</option>
										<option value="AF" {{ (old('country') == 'AF') ? 'selected':'' }}>Afghanistan</option>
										<option value="AX" {{ (old('country') == 'AX') ? 'selected':'' }}>Åland Islands</option>
										<option value="AL" {{ (old('country') == 'AL') ? 'selected':'' }}>Albania</option>
										<option value="DZ" {{ (old('country') == 'DZ') ? 'selected':'' }}>Algeria</option>
										<option value="AS" {{ (old('country') == 'AS') ? 'selected':'' }}>American Samoa</option>
										<option value="AD" {{ (old('country') == 'AD') ? 'selected':'' }}>Andorra</option>
										<option value="AO" {{ (old('country') == 'AO') ? 'selected':'' }}>Angola</option>
										<option value="AI" {{ (old('country') == 'AI') ? 'selected':'' }}>Anguilla</option>
										<option value="AQ" {{ (old('country') == 'AQ') ? 'selected':'' }}>Antarctica</option>
										<option value="AG" {{ (old('country') == 'AG') ? 'selected':'' }}>Antigua and Barbuda</option>
										<option value="AR" {{ (old('country') == 'AR') ? 'selected':'' }}>Argentina</option>
										<option value="AM" {{ (old('country') == 'AM') ? 'selected':'' }}>Armenia</option>
										<option value="AW" {{ (old('country') == 'AW') ? 'selected':'' }}>Aruba</option>
										<option value="AU" {{ (old('country') == 'AU') ? 'selected':'' }}>Australia</option>
										<option value="AT" {{ (old('country') == 'AT') ? 'selected':'' }}>Austria</option>
										<option value="AZ" {{ (old('country') == 'AZ') ? 'selected':'' }}>Azerbaijan</option>
										<option value="BS" {{ (old('country') == 'BS') ? 'selected':'' }}>Bahamas</option>
										<option value="BH" {{ (old('country') == 'BH') ? 'selected':'' }}>Bahrain</option>
										<option value="BD" {{ (old('country') == 'BD') ? 'selected':'' }}>Bangladesh</option>
										<option value="BB" {{ (old('country') == 'BB') ? 'selected':'' }}>Barbados</option>
										<option value="BY" {{ (old('country') == 'BY') ? 'selected':'' }}>Belarus</option>
										<option value="BE" {{ (old('country') == 'BE') ? 'selected':'' }}>Belgium</option>
										<option value="BZ" {{ (old('country') == 'BZ') ? 'selected':'' }}>Belize</option>
										<option value="BJ" {{ (old('country') == 'BJ') ? 'selected':'' }}>Benin</option>
										<option value="BM" {{ (old('country') == 'BM') ? 'selected':'' }}>Bermuda</option>
										<option value="BT" {{ (old('country') == 'BT') ? 'selected':'' }}>Bhutan</option>
										<option value="BO" {{ (old('country') == 'BO') ? 'selected':'' }}>Bolivia, Plurinational State of</option>
										<option value="BQ" {{ (old('country') == 'BQ') ? 'selected':'' }}>Bonaire, Sint Eustatius and Saba</option>
										<option value="BA" {{ (old('country') == 'BA') ? 'selected':'' }}>Bosnia and Herzegovina</option>
										<option value="BW" {{ (old('country') == 'BW') ? 'selected':'' }}>Botswana</option>
										<option value="BV" {{ (old('country') == 'BV') ? 'selected':'' }}>Bouvet Island</option>
										<option value="BR" {{ (old('country') == 'BR') ? 'selected':'' }}>Brazil</option>
										<option value="IO" {{ (old('country') == 'IO') ? 'selected':'' }}>British Indian Ocean Territory</option>
										<option value="BN" {{ (old('country') == 'BN') ? 'selected':'' }}>Brunei Darussalam</option>
										<option value="BG" {{ (old('country') == 'BG') ? 'selected':'' }}>Bulgaria</option>
										<option value="BF" {{ (old('country') == 'BF') ? 'selected':'' }}>Burkina Faso</option>
										<option value="BI" {{ (old('country') == 'BI') ? 'selected':'' }}>Burundi</option>
										<option value="KH" {{ (old('country') == 'KH') ? 'selected':'' }}>Cambodia</option>
										<option value="CM" {{ (old('country') == 'CM') ? 'selected':'' }}>Cameroon</option>
										<option value="CA" {{ (old('country') == 'CA') ? 'selected':'' }}>Canada</option>
										<option value="CV" {{ (old('country') == 'CV') ? 'selected':'' }}>Cape Verde</option>
										<option value="KY" {{ (old('country') == 'KY') ? 'selected':'' }}>Cayman Islands</option>
										<option value="CF" {{ (old('country') == 'CF') ? 'selected':'' }}>Central African Republic</option>
										<option value="TD" {{ (old('country') == 'TD') ? 'selected':'' }}>Chad</option>
										<option value="CL" {{ (old('country') == 'CL') ? 'selected':'' }}>Chile</option>
										<option value="CN" {{ (old('country') == 'CN') ? 'selected':'' }}>China</option>
										<option value="CX" {{ (old('country') == 'CX') ? 'selected':'' }}>Christmas Island</option>
										<option value="CC" {{ (old('country') == 'CC') ? 'selected':'' }}>Cocos (Keeling) Islands</option>
										<option value="CO" {{ (old('country') == 'CO') ? 'selected':'' }}>Colombia</option>
										<option value="KM" {{ (old('country') == 'KM') ? 'selected':'' }}>Comoros</option>
										<option value="CG" {{ (old('country') == 'CG') ? 'selected':'' }}>Congo</option>
										<option value="CD" {{ (old('country') == 'CD') ? 'selected':'' }}>Congo, the Democratic Republic of the</option>
										<option value="CK" {{ (old('country') == 'CK') ? 'selected':'' }}>Cook Islands</option>
										<option value="CR" {{ (old('country') == 'CR') ? 'selected':'' }}>Costa Rica</option>
										<option value="CI" {{ (old('country') == 'CI') ? 'selected':'' }}>Côte d'Ivoire</option>
										<option value="HR" {{ (old('country') == 'HR') ? 'selected':'' }}>Croatia</option>
										<option value="CU" {{ (old('country') == 'CU') ? 'selected':'' }}>Cuba</option>
										<option value="CW" {{ (old('country') == 'CW') ? 'selected':'' }}>Curaçao</option>
										<option value="CY" {{ (old('country') == 'CY') ? 'selected':'' }}>Cyprus</option>
										<option value="CZ" {{ (old('country') == 'CZ') ? 'selected':'' }}>Czech Republic</option>
										<option value="DK" {{ (old('country') == 'DK') ? 'selected':'' }}>Denmark</option>
										<option value="DJ" {{ (old('country') == 'DJ') ? 'selected':'' }}>Djibouti</option>
										<option value="DM" {{ (old('country') == 'DM') ? 'selected':'' }}>Dominica</option>
										<option value="DO" {{ (old('country') == 'DO') ? 'selected':'' }}>Dominican Republic</option>
										<option value="EC" {{ (old('country') == 'EC') ? 'selected':'' }}>Ecuador</option>
										<option value="EG" {{ (old('country') == 'EG') ? 'selected':'' }}>Egypt</option>
										<option value="SV" {{ (old('country') == 'SV') ? 'selected':'' }}>El Salvador</option>
										<option value="GQ" {{ (old('country') == 'GQ') ? 'selected':'' }}>Equatorial Guinea</option>
										<option value="ER" {{ (old('country') == 'ER') ? 'selected':'' }}>Eritrea</option>
										<option value="EE" {{ (old('country') == 'EE') ? 'selected':'' }}>Estonia</option>
										<option value="ET" {{ (old('country') == 'ET') ? 'selected':'' }}>Ethiopia</option>
										<option value="FK" {{ (old('country') == 'FK') ? 'selected':'' }}>Falkland Islands (Malvinas)</option>
										<option value="FO" {{ (old('country') == 'FO') ? 'selected':'' }}>Faroe Islands</option>
										<option value="FJ" {{ (old('country') == 'FJ') ? 'selected':'' }}>Fiji</option>
										<option value="FI" {{ (old('country') == 'FI') ? 'selected':'' }}>Finland</option>
										<option value="FR" {{ (old('country') == 'FR') ? 'selected':'' }}>France</option>
										<option value="GF" {{ (old('country') == 'GF') ? 'selected':'' }}>French Guiana</option>
										<option value="PF" {{ (old('country') == 'PF') ? 'selected':'' }}>French Polynesia</option>
										<option value="TF" {{ (old('country') == 'TF') ? 'selected':'' }}>French Southern Territories</option>
										<option value="GA" {{ (old('country') == 'GA') ? 'selected':'' }}>Gabon</option>
										<option value="GM" {{ (old('country') == 'GM') ? 'selected':'' }}>Gambia</option>
										<option value="GE" {{ (old('country') == 'GE') ? 'selected':'' }}>Georgia</option>
										<option value="DE" {{ (old('country') == 'DE') ? 'selected':'' }}>Germany</option>
										<option value="GH" {{ (old('country') == 'GH') ? 'selected':'' }}>Ghana</option>
										<option value="GI" {{ (old('country') == 'GI') ? 'selected':'' }}>Gibraltar</option>
										<option value="GR" {{ (old('country') == 'GR') ? 'selected':'' }}>Greece</option>
										<option value="GL" {{ (old('country') == 'GL') ? 'selected':'' }}>Greenland</option>
										<option value="GD" {{ (old('country') == 'GD') ? 'selected':'' }}>Grenada</option>
										<option value="GP" {{ (old('country') == 'GP') ? 'selected':'' }}>Guadeloupe</option>
										<option value="GU" {{ (old('country') == 'GU') ? 'selected':'' }}>Guam</option>
										<option value="GT" {{ (old('country') == 'GT') ? 'selected':'' }}>Guatemala</option>
										<option value="GG" {{ (old('country') == 'GG') ? 'selected':'' }}>Guernsey</option>
										<option value="GN" {{ (old('country') == 'GN') ? 'selected':'' }}>Guinea</option>
										<option value="GW" {{ (old('country') == 'GW') ? 'selected':'' }}>Guinea-Bissau</option>
										<option value="GY" {{ (old('country') == 'GY') ? 'selected':'' }}>Guyana</option>
										<option value="HT" {{ (old('country') == 'HT') ? 'selected':'' }}>Haiti</option>
										<option value="HM" {{ (old('country') == 'HM') ? 'selected':'' }}>Heard Island and McDonald Islands</option>
										<option value="VA" {{ (old('country') == 'VA') ? 'selected':'' }}>Holy See (Vatican City State)</option>
										<option value="HN" {{ (old('country') == 'HN') ? 'selected':'' }}>Honduras</option>
										<option value="HK" {{ (old('country') == 'HK') ? 'selected':'' }}>Hong Kong</option>
										<option value="HU" {{ (old('country') == 'HU') ? 'selected':'' }}>Hungary</option>
										<option value="IS" {{ (old('country') == 'IS') ? 'selected':'' }}>Iceland</option>
										<option value="IN" {{ (old('country') == 'IN') ? 'selected':'' }}>India</option>
										<option value="ID" {{ (old('country') == 'ID') ? 'selected':'' }}>Indonesia</option>
										<option value="IR" {{ (old('country') == 'IR') ? 'selected':'' }}>Iran, Islamic Republic of</option>
										<option value="IQ" {{ (old('country') == 'IQ') ? 'selected':'' }}>Iraq</option>
										<option value="IE" {{ (old('country') == 'IE') ? 'selected':'' }}>Ireland</option>
										<option value="IM" {{ (old('country') == 'IM') ? 'selected':'' }}>Isle of Man</option>
										<option value="IL" {{ (old('country') == 'IL') ? 'selected':'' }}>Israel</option>
										<option value="IT" {{ (old('country') == 'IT') ? 'selected':'' }}>Italy</option>
										<option value="JM" {{ (old('country') == 'JM') ? 'selected':'' }}>Jamaica</option>
										<option value="JP" {{ (old('country') == 'JP') ? 'selected':'' }}>Japan</option>
										<option value="JE" {{ (old('country') == 'JE') ? 'selected':'' }}>Jersey</option>
										<option value="JO" {{ (old('country') == 'JO') ? 'selected':'' }}>Jordan</option>
										<option value="KZ" {{ (old('country') == 'KZ') ? 'selected':'' }}>Kazakhstan</option>
										<option value="KE" {{ (old('country') == 'KE') ? 'selected':'' }}>Kenya</option>
										<option value="KI" {{ (old('country') == 'KI') ? 'selected':'' }}>Kiribati</option>
										<option value="KP" {{ (old('country') == 'KP') ? 'selected':'' }}>Korea, Democratic People's Republic of</option>
										<option value="KR" {{ (old('country') == 'KR') ? 'selected':'' }}>Korea, Republic of</option>
										<option value="KW" {{ (old('country') == 'KW') ? 'selected':'' }}>Kuwait</option>
										<option value="KG" {{ (old('country') == 'KG') ? 'selected':'' }}>Kyrgyzstan</option>
										<option value="LA" {{ (old('country') == 'LA') ? 'selected':'' }}>Lao People's Democratic Republic</option>
										<option value="LV" {{ (old('country') == 'LV') ? 'selected':'' }}>Latvia</option>
										<option value="LB" {{ (old('country') == 'LB') ? 'selected':'' }}>Lebanon</option>
										<option value="LS" {{ (old('country') == 'LS') ? 'selected':'' }}>Lesotho</option>
										<option value="LR" {{ (old('country') == 'LR') ? 'selected':'' }}>Liberia</option>
										<option value="LY" {{ (old('country') == 'LY') ? 'selected':'' }}>Libya</option>
										<option value="LI" {{ (old('country') == 'LI') ? 'selected':'' }}>Liechtenstein</option>
										<option value="LT" {{ (old('country') == 'LT') ? 'selected':'' }}>Lithuania</option>
										<option value="LU" {{ (old('country') == 'LU') ? 'selected':'' }}>Luxembourg</option>
										<option value="MO" {{ (old('country') == 'MO') ? 'selected':'' }}>Macao</option>
										<option value="MK" {{ (old('country') == 'MK') ? 'selected':'' }}>Macedonia, the former Yugoslav Republic of</option>
										<option value="MG" {{ (old('country') == 'MG') ? 'selected':'' }}>Madagascar</option>
										<option value="MW" {{ (old('country') == 'MW') ? 'selected':'' }}>Malawi</option>
										<option value="MY" {{ (old('country') == 'MY') ? 'selected':'' }}>Malaysia</option>
										<option value="MV" {{ (old('country') == 'MV') ? 'selected':'' }}>Maldives</option>
										<option value="ML" {{ (old('country') == 'ML') ? 'selected':'' }}>Mali</option>
										<option value="MT" {{ (old('country') == 'MT') ? 'selected':'' }}>Malta</option>
										<option value="MH" {{ (old('country') == 'MH') ? 'selected':'' }}>Marshall Islands</option>
										<option value="MQ" {{ (old('country') == 'MQ') ? 'selected':'' }}>Martinique</option>
										<option value="MR" {{ (old('country') == 'MR') ? 'selected':'' }}>Mauritania</option>
										<option value="MU" {{ (old('country') == 'MU') ? 'selected':'' }}>Mauritius</option>
										<option value="YT" {{ (old('country') == 'YT') ? 'selected':'' }}>Mayotte</option>
										<option value="FM" {{ (old('country') == 'FM') ? 'selected':'' }}>Micronesia, Federated States of</option>
										<option value="MD" {{ (old('country') == 'MD') ? 'selected':'' }}>Moldova, Republic of</option>
										<option value="MC" {{ (old('country') == 'MC') ? 'selected':'' }}>Monaco</option>
										<option value="MN" {{ (old('country') == 'MN') ? 'selected':'' }}>Mongolia</option>
										<option value="ME" {{ (old('country') == 'ME') ? 'selected':'' }}>Montenegro</option>
										<option value="MS" {{ (old('country') == 'MS') ? 'selected':'' }}>Montserrat</option>
										<option value="MA" {{ (old('country') == 'MA') ? 'selected':'' }}>Morocco</option>
										<option value="MZ" {{ (old('country') == 'MZ') ? 'selected':'' }}>Mozambique</option>
										<option value="MM" {{ (old('country') == 'MM') ? 'selected':'' }}>Myanmar</option>
										<option value="NA" {{ (old('country') == 'NA') ? 'selected':'' }}>Namibia</option>
										<option value="NR" {{ (old('country') == 'NR') ? 'selected':'' }}>Nauru</option>
										<option value="NP" {{ (old('country') == 'NP') ? 'selected':'' }}>Nepal</option>
										<option value="NL" {{ (old('country') == 'NL') ? 'selected':'' }}>Netherlands</option>
										<option value="NC" {{ (old('country') == 'NC') ? 'selected':'' }}>New Caledonia</option>
										<option value="NZ" {{ (old('country') == 'NZ') ? 'selected':'' }}>New Zealand</option>
										<option value="NI" {{ (old('country') == 'NI') ? 'selected':'' }}>Nicaragua</option>
										<option value="NE" {{ (old('country') == 'NE') ? 'selected':'' }}>Niger</option>
										<option value="NG" {{ (old('country') == 'NG') ? 'selected':'' }}>Nigeria</option>
										<option value="NU" {{ (old('country') == 'NU') ? 'selected':'' }}>Niue</option>
										<option value="NF" {{ (old('country') == 'NF') ? 'selected':'' }}>Norfolk Island</option>
										<option value="MP" {{ (old('country') == 'MP') ? 'selected':'' }}>Northern Mariana Islands</option>
										<option value="NO" {{ (old('country') == 'NO') ? 'selected':'' }}>Norway</option>
										<option value="OM" {{ (old('country') == 'OM') ? 'selected':'' }}>Oman</option>
										<option value="PK" {{ (old('country') == 'PK') ? 'selected':'' }}>Pakistan</option>
										<option value="PW" {{ (old('country') == 'PW') ? 'selected':'' }}>Palau</option>
										<option value="PS" {{ (old('country') == 'PS') ? 'selected':'' }}>Palestinian Territory, Occupied</option>
										<option value="PA" {{ (old('country') == 'PA') ? 'selected':'' }}>Panama</option>
										<option value="PG" {{ (old('country') == 'PG') ? 'selected':'' }}>Papua New Guinea</option>
										<option value="PY" {{ (old('country') == 'PY') ? 'selected':'' }}>Paraguay</option>
										<option value="PE" {{ (old('country') == 'PE') ? 'selected':'' }}>Peru</option>
										<option value="PH" {{ (old('country') == 'PH') ? 'selected':'' }}>Philippines</option>
										<option value="PN" {{ (old('country') == 'PN') ? 'selected':'' }}>Pitcairn</option>
										<option value="PL" {{ (old('country') == 'PL') ? 'selected':'' }}>Poland</option>
										<option value="PT" {{ (old('country') == 'PT') ? 'selected':'' }}>Portugal</option>
										<option value="PR" {{ (old('country') == 'PR') ? 'selected':'' }}>Puerto Rico</option>
										<option value="QA" {{ (old('country') == 'QA') ? 'selected':'' }}>Qatar</option>
										<option value="RE" {{ (old('country') == 'RE') ? 'selected':'' }}>Réunion</option>
										<option value="RO" {{ (old('country') == 'RO') ? 'selected':'' }}>Romania</option>
										<option value="RU" {{ (old('country') == 'RU') ? 'selected':'' }}>Russian Federation</option>
										<option value="RW" {{ (old('country') == 'RW') ? 'selected':'' }}>Rwanda</option>
										<option value="BL" {{ (old('country') == 'BL') ? 'selected':'' }}>Saint Barthélemy</option>
										<option value="SH" {{ (old('country') == 'SH') ? 'selected':'' }}>Saint Helena, Ascension and Tristan da Cunha</option>
										<option value="KN" {{ (old('country') == 'KN') ? 'selected':'' }}>Saint Kitts and Nevis</option>
										<option value="LC" {{ (old('country') == 'LC') ? 'selected':'' }}>Saint Lucia</option>
										<option value="MF" {{ (old('country') == 'MF') ? 'selected':'' }}>Saint Martin (French part)</option>
										<option value="PM" {{ (old('country') == 'PM') ? 'selected':'' }}>Saint Pierre and Miquelon</option>
										<option value="VC" {{ (old('country') == 'VC') ? 'selected':'' }}>Saint Vincent and the Grenadines</option>
										<option value="WS" {{ (old('country') == 'WS') ? 'selected':'' }}>Samoa</option>
										<option value="SM" {{ (old('country') == 'SM') ? 'selected':'' }}>San Marino</option>
										<option value="ST" {{ (old('country') == 'ST') ? 'selected':'' }}>Sao Tome and Principe</option>
										<option value="SA" {{ (old('country') == 'SA') ? 'selected':'' }}>Saudi Arabia</option>
										<option value="SN" {{ (old('country') == 'SN') ? 'selected':'' }}>Senegal</option>
										<option value="RS" {{ (old('country') == 'RS') ? 'selected':'' }}>Serbia</option>
										<option value="SC" {{ (old('country') == 'SC') ? 'selected':'' }}>Seychelles</option>
										<option value="SL" {{ (old('country') == 'SL') ? 'selected':'' }}>Sierra Leone</option>
										<option value="SG" {{ (old('country') == 'SG') ? 'selected':'' }}>Singapore</option>
										<option value="SX" {{ (old('country') == 'SX') ? 'selected':'' }}>Sint Maarten (Dutch part)</option>
										<option value="SK" {{ (old('country') == 'SK') ? 'selected':'' }}>Slovakia</option>
										<option value="SI" {{ (old('country') == 'SI') ? 'selected':'' }}>Slovenia</option>
										<option value="SB" {{ (old('country') == 'SB') ? 'selected':'' }}>Solomon Islands</option>
										<option value="SO" {{ (old('country') == 'SO') ? 'selected':'' }}>Somalia</option>
										<option value="ZA" {{ (old('country') == 'ZA') ? 'selected':'' }}>South Africa</option>
										<option value="GS" {{ (old('country') == 'GS') ? 'selected':'' }}>South Georgia and the South Sandwich Islands</option>
										<option value="SS" {{ (old('country') == 'SS') ? 'selected':'' }}>South Sudan</option>
										<option value="ES" {{ (old('country') == 'ES') ? 'selected':'' }}>Spain</option>
										<option value="LK" {{ (old('country') == 'LK') ? 'selected':'' }}>Sri Lanka</option>
										<option value="SD" {{ (old('country') == 'SD') ? 'selected':'' }}>Sudan</option>
										<option value="SR" {{ (old('country') == 'SR') ? 'selected':'' }}>Suriname</option>
										<option value="SJ" {{ (old('country') == 'SJ') ? 'selected':'' }}>Svalbard and Jan Mayen</option>
										<option value="SZ" {{ (old('country') == 'SZ') ? 'selected':'' }}>Swaziland</option>
										<option value="SE" {{ (old('country') == 'SE') ? 'selected':'' }}>Sweden</option>
										<option value="CH" {{ (old('country') == 'CH') ? 'selected':'' }}>Switzerland</option>
										<option value="SY" {{ (old('country') == 'SY') ? 'selected':'' }}>Syrian Arab Republic</option>
										<option value="TW" {{ (old('country') == 'TW') ? 'selected':'' }}>Taiwan, Province of China</option>
										<option value="TJ" {{ (old('country') == 'TJ') ? 'selected':'' }}>Tajikistan</option>
										<option value="TZ" {{ (old('country') == 'TZ') ? 'selected':'' }}>Tanzania, United Republic of</option>
										<option value="TH" {{ (old('country') == 'TH') ? 'selected':'' }}>Thailand</option>
										<option value="TL" {{ (old('country') == 'TL') ? 'selected':'' }}>Timor-Leste</option>
										<option value="TG" {{ (old('country') == 'TG') ? 'selected':'' }}>Togo</option>
										<option value="TK" {{ (old('country') == 'TK') ? 'selected':'' }}>Tokelau</option>
										<option value="TO" {{ (old('country') == 'TO') ? 'selected':'' }}>Tonga</option>
										<option value="TT" {{ (old('country') == 'TT') ? 'selected':'' }}>Trinidad and Tobago</option>
										<option value="TN" {{ (old('country') == 'TN') ? 'selected':'' }}>Tunisia</option>
										<option value="TR" {{ (old('country') == 'TR') ? 'selected':'' }}>Turkey</option>
										<option value="TM" {{ (old('country') == 'TM') ? 'selected':'' }}>Turkmenistan</option>
										<option value="TC" {{ (old('country') == 'TC') ? 'selected':'' }}>Turks and Caicos Islands</option>
										<option value="TV" {{ (old('country') == 'TV') ? 'selected':'' }}>Tuvalu</option>
										<option value="UG" {{ (old('country') == 'UG') ? 'selected':'' }}>Uganda</option>
										<option value="UA" {{ (old('country') == 'UA') ? 'selected':'' }}>Ukraine</option>
										<option value="AE" {{ (old('country') == 'AE') ? 'selected':'' }}>United Arab Emirates</option>
										<option value="GB" {{ (old('country') == 'GB') ? 'selected':'' }}>United Kingdom</option>
										<option value="UM" {{ (old('country') == 'UM') ? 'selected':'' }}>United States Minor Outlying Islands</option>
										<option value="UY" {{ (old('country') == 'UY') ? 'selected':'' }}>Uruguay</option>
										<option value="UZ" {{ (old('country') == 'UZ') ? 'selected':'' }}>Uzbekistan</option>
										<option value="VU" {{ (old('country') == 'VU') ? 'selected':'' }}>Vanuatu</option>
										<option value="VE" {{ (old('country') == 'VE') ? 'selected':'' }}>Venezuela, Bolivarian Republic of</option>
										<option value="VN" {{ (old('country') == 'VN') ? 'selected':'' }}>Viet Nam</option>
										<option value="VG" {{ (old('country') == 'VG') ? 'selected':'' }}>Virgin Islands, British</option>
										<option value="VI" {{ (old('country') == 'VI') ? 'selected':'' }}>Virgin Islands, U.S.</option>
										<option value="WF" {{ (old('country') == 'WF') ? 'selected':'' }}>Wallis and Futuna</option>
										<option value="EH" {{ (old('country') == 'EH') ? 'selected':'' }}>Western Sahara</option>
										<option value="YE" {{ (old('country') == 'YE') ? 'selected':'' }}>Yemen</option>
										<option value="ZM" {{ (old('country') == 'ZM') ? 'selected':'' }}>Zambia</option>
										<option value="ZW" {{ (old('country') == 'ZW') ? 'selected':'' }}>Zimbabwe</option>
									</select>
									@if ($errors->has('country'))
										<small class="text-muted">{{ $errors->first('country') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Type:</label>
								<div class="col-sm-10">
									<input type="checkbox" data-toggle="toggle" 
										data-on="Clorine" data-off="Salt" 
										data-onstyle="info" data-offstyle="primary"
										data-size="small" name="type" {{ (old('type')) ? 'checked':'' }}>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Service Days:</label>
								<div class="col-sm-10">
									<div class="btn-group btn-group-sm" data-toggle="buttons">
										<label class="btn {{ (old('service_days_monday')) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off"
													name="service_days_monday" {{ (old('service_days_monday')) ? 'checked':'' }}>Monday
										</label>
										<label class="btn {{ (old('service_days_tuesday')) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off"
													name="service_days_tuesday" {{ (old('service_days_tuesday')) ? 'checked':'' }}>Tuesday
										</label>
										<label class="btn {{ (old('service_days_wednesday')) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off" 
													name="service_days_wednesday" {{ (old('service_days_wednesday')) ? 'checked':'' }}>Wednesday
										</label>
										<label class="btn {{ (old('service_days_thursday')) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off" 
													name="service_days_thursday" {{ (old('service_days_thursday')) ? 'checked':'' }}>Thursday
										</label>
										<label class="btn {{ (old('service_days_friday')) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off" 
													name="service_days_friday" {{ (old('service_days_friday')) ? 'checked':'' }}>Friday
										</label>
										<label class="btn {{ (old('service_days_saturday')) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off" 
													name="service_days_saturday" {{ (old('service_days_saturday')) ? 'checked':'' }}>Saturday
										</label>
										<label class="btn {{ (old('service_days_sunday')) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off" 
													name="service_days_sunday" {{ (old('service_days_sunday')) ? 'checked':'' }}>Sunday
										</label>
									</div>
								</div>
							</div>

							<div class="form-group row {{($errors->has('start_time') || $errors->has('end_time'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Time interval:</label>
								<div class="col-sm-10">
									<div class="input-group">
										<div class="input-group-addon">From:</div>
											<div class="input-group clockpicker" data-autoclose="true">
												<input type="text" class="form-control"
														name="start_time" value="{{ old('start_time') }}">
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-time"></span>
												</span>
											</div>
										<div class="input-group-addon">To:</div>
										<div class="input-group clockpicker" data-autoclose="true">
											<input type="text" class="form-control"
													name="end_time" value="{{ old('end_time') }}">
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-time"></span>
											</span>
										</div>
									</div>
									@if ($errors->has('start_time'))
										<small class="text-muted">{{ $errors->first('start_time') }}</small>
									@endif
									@if ($errors->has('end_time'))
										<small class="text-muted">{{ $errors->first('end_time') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('amount') || $errors->has('currency'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Price:</label>
								<div class="col-sm-10">
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="text" class="form-control money-mask-input"
										 		name="amount" placeholder="Amount"
										 		value="{{ old('amount') }}">
										 <div class="input-group-addon">
										 	<select name='currency' data-live-search="true">
										 		<option value="USD" {{ (old('currency') == 'USD') ? 'selected':'' }}>USD</option>
										 		<option value="MXN" {{ (old('currency') == 'MXN') ? 'selected':'' }}>MXN</option>
										 		<option value="CAD" {{ (old('currency') == 'CAD') ? 'selected':'' }}>CAD</option>
										 	</select>
										 </div>
									</div>
									@if ($errors->has('amount'))
										<small class="text-muted">{{ $errors->first('amount') }}</small>
									@endif
									@if ($errors->has('currency'))
										<small class="text-muted">{{ $errors->first('currency') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Status:</label>
								<div class="col-sm-10">
								<input type="checkbox" data-toggle="toggle" 
										data-on="Active" data-off="Not Active" 
										data-onstyle="success" data-offstyle="danger"
										data-size="small" name="status" {{ (old('status')) ? 'checked':'' }}>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Service Photo</label>
								<div class="col-sm-10">
					                <div class="fileupload fileupload-new" data-provides="fileupload">
					                  <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
					                  <img src="{{ url('img/no_image.png') }}" alt="Placeholder" /></div>
					                  <div class="fileupload-preview fileupload-exists thumbnail"
					                   		style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
					                  @if ($errors->has('photo'))
					                  	<br>
										<span class="label label-danger">{{ $errors->first('photo') }}</span>
										<br><br>
									  @endif
					                  <div>
					                    <span class="btn btn-default btn-file">
					                    <span class="fileupload-new">Select image</span>
					                    <span class="fileupload-exists">Change</span>
					                    <input type="file" name="photo" id="photo" ></span>
					                    <a href="#" class="btn btn-default fileupload-exists" 
					                    	data-dismiss="fileupload">Remove</a>
					                  </div>
					                </div>
				              	</div>
							</div>

							<div class="form-group row {{($errors->has('comments'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Comments:</label>
								<div class="col-sm-10">
									<textarea rows="5" class="form-control" 
												placeholder="Any additional info about this service."
												name="comments">{{ old('comments') }}</textarea>
									@if ($errors->has('comments'))
										<small class="text-muted">{{ $errors->first('comments') }}</small>
									@endif
								</div>
							</div>
							
							<hr>
							<p style="float: left;">
								<a  class="btn btn-danger"
								href="{{ url('services') }}">
								<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back</a>
								<button  class="btn btn-success"
								type='submit'>
								<i class="font-icon font-icon-ok"></i>&nbsp;&nbsp;&nbsp;Create Service</button>
							</p>
							<br>
							<br>
						</form>
					</div>
			</section>
		</div>
	</div>
@endsection