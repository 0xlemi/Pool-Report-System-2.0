@extends('layouts.app')

@section('content')
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>Edit Service</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="{{ url('services') }}">Services</a></li>
						<li><a href="{{ url('services/'.$service->seq_id) }}">View Service {{ $service->seq_id }}</a></li>
						<li class="active">Edit Service</li>
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
						<form method="POST" action="{{ url('services/'.$service->seq_id) }}" enctype="multipart/form-data">
							{{ csrf_field() }}
							{{ method_field('PATCH') }}
							<div class="form-group row {{($errors->has('name'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Name:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="name" maxlength="20" value="{{ $service->name }}">
									@if ($errors->has('name'))
										<small class="text-muted">{{ $errors->first('name') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('address_line'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Street and number:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="address_line" maxlength="50" value="{{ $service->address_line }}">
									@if ($errors->has('address_line'))
										<small class="text-muted">{{ $errors->first('address_line') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('city'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">City:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="city" maxlength="30" value="{{ $service->city }}">
									@if ($errors->has('city'))
										<small class="text-muted">{{ $errors->first('city') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('state'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">State:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="state" maxlength="30" value="{{ $service->state }}">
									@if ($errors->has('state'))
										<small class="text-muted">{{ $errors->first('state') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('postal_code'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Postal Code:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="postal_code" maxlength="15" value="{{ $service->postal_code }}">
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
										<option value="US" {{ ($service->country == 'US') ? 'selected':'' }}>United States</option>
										<option value="MX" {{ ($service->country == 'MX') ? 'selected':'' }}>Mexico</option>
										<option value="AF" {{ ($service->country == 'AF') ? 'selected':'' }}>Afghanistan</option>
										<option value="AX" {{ ($service->country == 'AX') ? 'selected':'' }}>Åland Islands</option>
										<option value="AL" {{ ($service->country == 'AL') ? 'selected':'' }}>Albania</option>
										<option value="DZ" {{ ($service->country == 'DZ') ? 'selected':'' }}>Algeria</option>
										<option value="AS" {{ ($service->country == 'AS') ? 'selected':'' }}>American Samoa</option>
										<option value="AD" {{ ($service->country == 'AD') ? 'selected':'' }}>Andorra</option>
										<option value="AO" {{ ($service->country == 'AO') ? 'selected':'' }}>Angola</option>
										<option value="AI" {{ ($service->country == 'AI') ? 'selected':'' }}>Anguilla</option>
										<option value="AQ" {{ ($service->country == 'AQ') ? 'selected':'' }}>Antarctica</option>
										<option value="AG" {{ ($service->country == 'AG') ? 'selected':'' }}>Antigua and Barbuda</option>
										<option value="AR" {{ ($service->country == 'AR') ? 'selected':'' }}>Argentina</option>
										<option value="AM" {{ ($service->country == 'AM') ? 'selected':'' }}>Armenia</option>
										<option value="AW" {{ ($service->country == 'AW') ? 'selected':'' }}>Aruba</option>
										<option value="AU" {{ ($service->country == 'AU') ? 'selected':'' }}>Australia</option>
										<option value="AT" {{ ($service->country == 'AT') ? 'selected':'' }}>Austria</option>
										<option value="AZ" {{ ($service->country == 'AZ') ? 'selected':'' }}>Azerbaijan</option>
										<option value="BS" {{ ($service->country == 'BS') ? 'selected':'' }}>Bahamas</option>
										<option value="BH" {{ ($service->country == 'BH') ? 'selected':'' }}>Bahrain</option>
										<option value="BD" {{ ($service->country == 'BD') ? 'selected':'' }}>Bangladesh</option>
										<option value="BB" {{ ($service->country == 'BB') ? 'selected':'' }}>Barbados</option>
										<option value="BY" {{ ($service->country == 'BY') ? 'selected':'' }}>Belarus</option>
										<option value="BE" {{ ($service->country == 'BE') ? 'selected':'' }}>Belgium</option>
										<option value="BZ" {{ ($service->country == 'BZ') ? 'selected':'' }}>Belize</option>
										<option value="BJ" {{ ($service->country == 'BJ') ? 'selected':'' }}>Benin</option>
										<option value="BM" {{ ($service->country == 'BM') ? 'selected':'' }}>Bermuda</option>
										<option value="BT" {{ ($service->country == 'BT') ? 'selected':'' }}>Bhutan</option>
										<option value="BO" {{ ($service->country == 'BO') ? 'selected':'' }}>Bolivia, Plurinational State of</option>
										<option value="BQ" {{ ($service->country == 'BQ') ? 'selected':'' }}>Bonaire, Sint Eustatius and Saba</option>
										<option value="BA" {{ ($service->country == 'BA') ? 'selected':'' }}>Bosnia and Herzegovina</option>
										<option value="BW" {{ ($service->country == 'BW') ? 'selected':'' }}>Botswana</option>
										<option value="BV" {{ ($service->country == 'BV') ? 'selected':'' }}>Bouvet Island</option>
										<option value="BR" {{ ($service->country == 'BR') ? 'selected':'' }}>Brazil</option>
										<option value="IO" {{ ($service->country == 'IO') ? 'selected':'' }}>British Indian Ocean Territory</option>
										<option value="BN" {{ ($service->country == 'BN') ? 'selected':'' }}>Brunei Darussalam</option>
										<option value="BG" {{ ($service->country == 'BG') ? 'selected':'' }}>Bulgaria</option>
										<option value="BF" {{ ($service->country == 'BF') ? 'selected':'' }}>Burkina Faso</option>
										<option value="BI" {{ ($service->country == 'BI') ? 'selected':'' }}>Burundi</option>
										<option value="KH" {{ ($service->country == 'KH') ? 'selected':'' }}>Cambodia</option>
										<option value="CM" {{ ($service->country == 'CM') ? 'selected':'' }}>Cameroon</option>
										<option value="CA" {{ ($service->country == 'CA') ? 'selected':'' }}>Canada</option>
										<option value="CV" {{ ($service->country == 'CV') ? 'selected':'' }}>Cape Verde</option>
										<option value="KY" {{ ($service->country == 'KY') ? 'selected':'' }}>Cayman Islands</option>
										<option value="CF" {{ ($service->country == 'CF') ? 'selected':'' }}>Central African Republic</option>
										<option value="TD" {{ ($service->country == 'TD') ? 'selected':'' }}>Chad</option>
										<option value="CL" {{ ($service->country == 'CL') ? 'selected':'' }}>Chile</option>
										<option value="CN" {{ ($service->country == 'CN') ? 'selected':'' }}>China</option>
										<option value="CX" {{ ($service->country == 'CX') ? 'selected':'' }}>Christmas Island</option>
										<option value="CC" {{ ($service->country == 'CC') ? 'selected':'' }}>Cocos (Keeling) Islands</option>
										<option value="CO" {{ ($service->country == 'CO') ? 'selected':'' }}>Colombia</option>
										<option value="KM" {{ ($service->country == 'KM') ? 'selected':'' }}>Comoros</option>
										<option value="CG" {{ ($service->country == 'CG') ? 'selected':'' }}>Congo</option>
										<option value="CD" {{ ($service->country == 'CD') ? 'selected':'' }}>Congo, the Democratic Republic of the</option>
										<option value="CK" {{ ($service->country == 'CK') ? 'selected':'' }}>Cook Islands</option>
										<option value="CR" {{ ($service->country == 'CR') ? 'selected':'' }}>Costa Rica</option>
										<option value="CI" {{ ($service->country == 'CI') ? 'selected':'' }}>Côte d'Ivoire</option>
										<option value="HR" {{ ($service->country == 'HR') ? 'selected':'' }}>Croatia</option>
										<option value="CU" {{ ($service->country == 'CU') ? 'selected':'' }}>Cuba</option>
										<option value="CW" {{ ($service->country == 'CW') ? 'selected':'' }}>Curaçao</option>
										<option value="CY" {{ ($service->country == 'CY') ? 'selected':'' }}>Cyprus</option>
										<option value="CZ" {{ ($service->country == 'CZ') ? 'selected':'' }}>Czech Republic</option>
										<option value="DK" {{ ($service->country == 'DK') ? 'selected':'' }}>Denmark</option>
										<option value="DJ" {{ ($service->country == 'DJ') ? 'selected':'' }}>Djibouti</option>
										<option value="DM" {{ ($service->country == 'DM') ? 'selected':'' }}>Dominica</option>
										<option value="DO" {{ ($service->country == 'DO') ? 'selected':'' }}>Dominican Republic</option>
										<option value="EC" {{ ($service->country == 'EC') ? 'selected':'' }}>Ecuador</option>
										<option value="EG" {{ ($service->country == 'EG') ? 'selected':'' }}>Egypt</option>
										<option value="SV" {{ ($service->country == 'SV') ? 'selected':'' }}>El Salvador</option>
										<option value="GQ" {{ ($service->country == 'GQ') ? 'selected':'' }}>Equatorial Guinea</option>
										<option value="ER" {{ ($service->country == 'ER') ? 'selected':'' }}>Eritrea</option>
										<option value="EE" {{ ($service->country == 'EE') ? 'selected':'' }}>Estonia</option>
										<option value="ET" {{ ($service->country == 'ET') ? 'selected':'' }}>Ethiopia</option>
										<option value="FK" {{ ($service->country == 'FK') ? 'selected':'' }}>Falkland Islands (Malvinas)</option>
										<option value="FO" {{ ($service->country == 'FO') ? 'selected':'' }}>Faroe Islands</option>
										<option value="FJ" {{ ($service->country == 'FJ') ? 'selected':'' }}>Fiji</option>
										<option value="FI" {{ ($service->country == 'FI') ? 'selected':'' }}>Finland</option>
										<option value="FR" {{ ($service->country == 'FR') ? 'selected':'' }}>France</option>
										<option value="GF" {{ ($service->country == 'GF') ? 'selected':'' }}>French Guiana</option>
										<option value="PF" {{ ($service->country == 'PF') ? 'selected':'' }}>French Polynesia</option>
										<option value="TF" {{ ($service->country == 'TF') ? 'selected':'' }}>French Southern Territories</option>
										<option value="GA" {{ ($service->country == 'GA') ? 'selected':'' }}>Gabon</option>
										<option value="GM" {{ ($service->country == 'GM') ? 'selected':'' }}>Gambia</option>
										<option value="GE" {{ ($service->country == 'GE') ? 'selected':'' }}>Georgia</option>
										<option value="DE" {{ ($service->country == 'DE') ? 'selected':'' }}>Germany</option>
										<option value="GH" {{ ($service->country == 'GH') ? 'selected':'' }}>Ghana</option>
										<option value="GI" {{ ($service->country == 'GI') ? 'selected':'' }}>Gibraltar</option>
										<option value="GR" {{ ($service->country == 'GR') ? 'selected':'' }}>Greece</option>
										<option value="GL" {{ ($service->country == 'GL') ? 'selected':'' }}>Greenland</option>
										<option value="GD" {{ ($service->country == 'GD') ? 'selected':'' }}>Grenada</option>
										<option value="GP" {{ ($service->country == 'GP') ? 'selected':'' }}>Guadeloupe</option>
										<option value="GU" {{ ($service->country == 'GU') ? 'selected':'' }}>Guam</option>
										<option value="GT" {{ ($service->country == 'GT') ? 'selected':'' }}>Guatemala</option>
										<option value="GG" {{ ($service->country == 'GG') ? 'selected':'' }}>Guernsey</option>
										<option value="GN" {{ ($service->country == 'GN') ? 'selected':'' }}>Guinea</option>
										<option value="GW" {{ ($service->country == 'GW') ? 'selected':'' }}>Guinea-Bissau</option>
										<option value="GY" {{ ($service->country == 'GY') ? 'selected':'' }}>Guyana</option>
										<option value="HT" {{ ($service->country == 'HT') ? 'selected':'' }}>Haiti</option>
										<option value="HM" {{ ($service->country == 'HM') ? 'selected':'' }}>Heard Island and McDonald Islands</option>
										<option value="VA" {{ ($service->country == 'VA') ? 'selected':'' }}>Holy See (Vatican City State)</option>
										<option value="HN" {{ ($service->country == 'HN') ? 'selected':'' }}>Honduras</option>
										<option value="HK" {{ ($service->country == 'HK') ? 'selected':'' }}>Hong Kong</option>
										<option value="HU" {{ ($service->country == 'HU') ? 'selected':'' }}>Hungary</option>
										<option value="IS" {{ ($service->country == 'IS') ? 'selected':'' }}>Iceland</option>
										<option value="IN" {{ ($service->country == 'IN') ? 'selected':'' }}>India</option>
										<option value="ID" {{ ($service->country == 'ID') ? 'selected':'' }}>Indonesia</option>
										<option value="IR" {{ ($service->country == 'IR') ? 'selected':'' }}>Iran, Islamic Republic of</option>
										<option value="IQ" {{ ($service->country == 'IQ') ? 'selected':'' }}>Iraq</option>
										<option value="IE" {{ ($service->country == 'IE') ? 'selected':'' }}>Ireland</option>
										<option value="IM" {{ ($service->country == 'IM') ? 'selected':'' }}>Isle of Man</option>
										<option value="IL" {{ ($service->country == 'IL') ? 'selected':'' }}>Israel</option>
										<option value="IT" {{ ($service->country == 'IT') ? 'selected':'' }}>Italy</option>
										<option value="JM" {{ ($service->country == 'JM') ? 'selected':'' }}>Jamaica</option>
										<option value="JP" {{ ($service->country == 'JP') ? 'selected':'' }}>Japan</option>
										<option value="JE" {{ ($service->country == 'JE') ? 'selected':'' }}>Jersey</option>
										<option value="JO" {{ ($service->country == 'JO') ? 'selected':'' }}>Jordan</option>
										<option value="KZ" {{ ($service->country == 'KZ') ? 'selected':'' }}>Kazakhstan</option>
										<option value="KE" {{ ($service->country == 'KE') ? 'selected':'' }}>Kenya</option>
										<option value="KI" {{ ($service->country == 'KI') ? 'selected':'' }}>Kiribati</option>
										<option value="KP" {{ ($service->country == 'KP') ? 'selected':'' }}>Korea, Democratic People's Republic of</option>
										<option value="KR" {{ ($service->country == 'KR') ? 'selected':'' }}>Korea, Republic of</option>
										<option value="KW" {{ ($service->country == 'KW') ? 'selected':'' }}>Kuwait</option>
										<option value="KG" {{ ($service->country == 'KG') ? 'selected':'' }}>Kyrgyzstan</option>
										<option value="LA" {{ ($service->country == 'LA') ? 'selected':'' }}>Lao People's Democratic Republic</option>
										<option value="LV" {{ ($service->country == 'LV') ? 'selected':'' }}>Latvia</option>
										<option value="LB" {{ ($service->country == 'LB') ? 'selected':'' }}>Lebanon</option>
										<option value="LS" {{ ($service->country == 'LS') ? 'selected':'' }}>Lesotho</option>
										<option value="LR" {{ ($service->country == 'LR') ? 'selected':'' }}>Liberia</option>
										<option value="LY" {{ ($service->country == 'LY') ? 'selected':'' }}>Libya</option>
										<option value="LI" {{ ($service->country == 'LI') ? 'selected':'' }}>Liechtenstein</option>
										<option value="LT" {{ ($service->country == 'LT') ? 'selected':'' }}>Lithuania</option>
										<option value="LU" {{ ($service->country == 'LU') ? 'selected':'' }}>Luxembourg</option>
										<option value="MO" {{ ($service->country == 'MO') ? 'selected':'' }}>Macao</option>
										<option value="MK" {{ ($service->country == 'MK') ? 'selected':'' }}>Macedonia, the former Yugoslav Republic of</option>
										<option value="MG" {{ ($service->country == 'MG') ? 'selected':'' }}>Madagascar</option>
										<option value="MW" {{ ($service->country == 'MW') ? 'selected':'' }}>Malawi</option>
										<option value="MY" {{ ($service->country == 'MY') ? 'selected':'' }}>Malaysia</option>
										<option value="MV" {{ ($service->country == 'MV') ? 'selected':'' }}>Maldives</option>
										<option value="ML" {{ ($service->country == 'ML') ? 'selected':'' }}>Mali</option>
										<option value="MT" {{ ($service->country == 'MT') ? 'selected':'' }}>Malta</option>
										<option value="MH" {{ ($service->country == 'MH') ? 'selected':'' }}>Marshall Islands</option>
										<option value="MQ" {{ ($service->country == 'MQ') ? 'selected':'' }}>Martinique</option>
										<option value="MR" {{ ($service->country == 'MR') ? 'selected':'' }}>Mauritania</option>
										<option value="MU" {{ ($service->country == 'MU') ? 'selected':'' }}>Mauritius</option>
										<option value="YT" {{ ($service->country == 'YT') ? 'selected':'' }}>Mayotte</option>
										<option value="FM" {{ ($service->country == 'FM') ? 'selected':'' }}>Micronesia, Federated States of</option>
										<option value="MD" {{ ($service->country == 'MD') ? 'selected':'' }}>Moldova, Republic of</option>
										<option value="MC" {{ ($service->country == 'MC') ? 'selected':'' }}>Monaco</option>
										<option value="MN" {{ ($service->country == 'MN') ? 'selected':'' }}>Mongolia</option>
										<option value="ME" {{ ($service->country == 'ME') ? 'selected':'' }}>Montenegro</option>
										<option value="MS" {{ ($service->country == 'MS') ? 'selected':'' }}>Montserrat</option>
										<option value="MA" {{ ($service->country == 'MA') ? 'selected':'' }}>Morocco</option>
										<option value="MZ" {{ ($service->country == 'MZ') ? 'selected':'' }}>Mozambique</option>
										<option value="MM" {{ ($service->country == 'MM') ? 'selected':'' }}>Myanmar</option>
										<option value="NA" {{ ($service->country == 'NA') ? 'selected':'' }}>Namibia</option>
										<option value="NR" {{ ($service->country == 'NR') ? 'selected':'' }}>Nauru</option>
										<option value="NP" {{ ($service->country == 'NP') ? 'selected':'' }}>Nepal</option>
										<option value="NL" {{ ($service->country == 'NL') ? 'selected':'' }}>Netherlands</option>
										<option value="NC" {{ ($service->country == 'NC') ? 'selected':'' }}>New Caledonia</option>
										<option value="NZ" {{ ($service->country == 'NZ') ? 'selected':'' }}>New Zealand</option>
										<option value="NI" {{ ($service->country == 'NI') ? 'selected':'' }}>Nicaragua</option>
										<option value="NE" {{ ($service->country == 'NE') ? 'selected':'' }}>Niger</option>
										<option value="NG" {{ ($service->country == 'NG') ? 'selected':'' }}>Nigeria</option>
										<option value="NU" {{ ($service->country == 'NU') ? 'selected':'' }}>Niue</option>
										<option value="NF" {{ ($service->country == 'NF') ? 'selected':'' }}>Norfolk Island</option>
										<option value="MP" {{ ($service->country == 'MP') ? 'selected':'' }}>Northern Mariana Islands</option>
										<option value="NO" {{ ($service->country == 'NO') ? 'selected':'' }}>Norway</option>
										<option value="OM" {{ ($service->country == 'OM') ? 'selected':'' }}>Oman</option>
										<option value="PK" {{ ($service->country == 'PK') ? 'selected':'' }}>Pakistan</option>
										<option value="PW" {{ ($service->country == 'PW') ? 'selected':'' }}>Palau</option>
										<option value="PS" {{ ($service->country == 'PS') ? 'selected':'' }}>Palestinian Territory, Occupied</option>
										<option value="PA" {{ ($service->country == 'PA') ? 'selected':'' }}>Panama</option>
										<option value="PG" {{ ($service->country == 'PG') ? 'selected':'' }}>Papua New Guinea</option>
										<option value="PY" {{ ($service->country == 'PY') ? 'selected':'' }}>Paraguay</option>
										<option value="PE" {{ ($service->country == 'PE') ? 'selected':'' }}>Peru</option>
										<option value="PH" {{ ($service->country == 'PH') ? 'selected':'' }}>Philippines</option>
										<option value="PN" {{ ($service->country == 'PN') ? 'selected':'' }}>Pitcairn</option>
										<option value="PL" {{ ($service->country == 'PL') ? 'selected':'' }}>Poland</option>
										<option value="PT" {{ ($service->country == 'PT') ? 'selected':'' }}>Portugal</option>
										<option value="PR" {{ ($service->country == 'PR') ? 'selected':'' }}>Puerto Rico</option>
										<option value="QA" {{ ($service->country == 'QA') ? 'selected':'' }}>Qatar</option>
										<option value="RE" {{ ($service->country == 'RE') ? 'selected':'' }}>Réunion</option>
										<option value="RO" {{ ($service->country == 'RO') ? 'selected':'' }}>Romania</option>
										<option value="RU" {{ ($service->country == 'RU') ? 'selected':'' }}>Russian Federation</option>
										<option value="RW" {{ ($service->country == 'RW') ? 'selected':'' }}>Rwanda</option>
										<option value="BL" {{ ($service->country == 'BL') ? 'selected':'' }}>Saint Barthélemy</option>
										<option value="SH" {{ ($service->country == 'SH') ? 'selected':'' }}>Saint Helena, Ascension and Tristan da Cunha</option>
										<option value="KN" {{ ($service->country == 'KN') ? 'selected':'' }}>Saint Kitts and Nevis</option>
										<option value="LC" {{ ($service->country == 'LC') ? 'selected':'' }}>Saint Lucia</option>
										<option value="MF" {{ ($service->country == 'MF') ? 'selected':'' }}>Saint Martin (French part)</option>
										<option value="PM" {{ ($service->country == 'PM') ? 'selected':'' }}>Saint Pierre and Miquelon</option>
										<option value="VC" {{ ($service->country == 'VC') ? 'selected':'' }}>Saint Vincent and the Grenadines</option>
										<option value="WS" {{ ($service->country == 'WS') ? 'selected':'' }}>Samoa</option>
										<option value="SM" {{ ($service->country == 'SM') ? 'selected':'' }}>San Marino</option>
										<option value="ST" {{ ($service->country == 'ST') ? 'selected':'' }}>Sao Tome and Principe</option>
										<option value="SA" {{ ($service->country == 'SA') ? 'selected':'' }}>Saudi Arabia</option>
										<option value="SN" {{ ($service->country == 'SN') ? 'selected':'' }}>Senegal</option>
										<option value="RS" {{ ($service->country == 'RS') ? 'selected':'' }}>Serbia</option>
										<option value="SC" {{ ($service->country == 'SC') ? 'selected':'' }}>Seychelles</option>
										<option value="SL" {{ ($service->country == 'SL') ? 'selected':'' }}>Sierra Leone</option>
										<option value="SG" {{ ($service->country == 'SG') ? 'selected':'' }}>Singapore</option>
										<option value="SX" {{ ($service->country == 'SX') ? 'selected':'' }}>Sint Maarten (Dutch part)</option>
										<option value="SK" {{ ($service->country == 'SK') ? 'selected':'' }}>Slovakia</option>
										<option value="SI" {{ ($service->country == 'SI') ? 'selected':'' }}>Slovenia</option>
										<option value="SB" {{ ($service->country == 'SB') ? 'selected':'' }}>Solomon Islands</option>
										<option value="SO" {{ ($service->country == 'SO') ? 'selected':'' }}>Somalia</option>
										<option value="ZA" {{ ($service->country == 'ZA') ? 'selected':'' }}>South Africa</option>
										<option value="GS" {{ ($service->country == 'GS') ? 'selected':'' }}>South Georgia and the South Sandwich Islands</option>
										<option value="SS" {{ ($service->country == 'SS') ? 'selected':'' }}>South Sudan</option>
										<option value="ES" {{ ($service->country == 'ES') ? 'selected':'' }}>Spain</option>
										<option value="LK" {{ ($service->country == 'LK') ? 'selected':'' }}>Sri Lanka</option>
										<option value="SD" {{ ($service->country == 'SD') ? 'selected':'' }}>Sudan</option>
										<option value="SR" {{ ($service->country == 'SR') ? 'selected':'' }}>Suriname</option>
										<option value="SJ" {{ ($service->country == 'SJ') ? 'selected':'' }}>Svalbard and Jan Mayen</option>
										<option value="SZ" {{ ($service->country == 'SZ') ? 'selected':'' }}>Swaziland</option>
										<option value="SE" {{ ($service->country == 'SE') ? 'selected':'' }}>Sweden</option>
										<option value="CH" {{ ($service->country == 'CH') ? 'selected':'' }}>Switzerland</option>
										<option value="SY" {{ ($service->country == 'SY') ? 'selected':'' }}>Syrian Arab Republic</option>
										<option value="TW" {{ ($service->country == 'TW') ? 'selected':'' }}>Taiwan, Province of China</option>
										<option value="TJ" {{ ($service->country == 'TJ') ? 'selected':'' }}>Tajikistan</option>
										<option value="TZ" {{ ($service->country == 'TZ') ? 'selected':'' }}>Tanzania, United Republic of</option>
										<option value="TH" {{ ($service->country == 'TH') ? 'selected':'' }}>Thailand</option>
										<option value="TL" {{ ($service->country == 'TL') ? 'selected':'' }}>Timor-Leste</option>
										<option value="TG" {{ ($service->country == 'TG') ? 'selected':'' }}>Togo</option>
										<option value="TK" {{ ($service->country == 'TK') ? 'selected':'' }}>Tokelau</option>
										<option value="TO" {{ ($service->country == 'TO') ? 'selected':'' }}>Tonga</option>
										<option value="TT" {{ ($service->country == 'TT') ? 'selected':'' }}>Trinidad and Tobago</option>
										<option value="TN" {{ ($service->country == 'TN') ? 'selected':'' }}>Tunisia</option>
										<option value="TR" {{ ($service->country == 'TR') ? 'selected':'' }}>Turkey</option>
										<option value="TM" {{ ($service->country == 'TM') ? 'selected':'' }}>Turkmenistan</option>
										<option value="TC" {{ ($service->country == 'TC') ? 'selected':'' }}>Turks and Caicos Islands</option>
										<option value="TV" {{ ($service->country == 'TV') ? 'selected':'' }}>Tuvalu</option>
										<option value="UG" {{ ($service->country == 'UG') ? 'selected':'' }}>Uganda</option>
										<option value="UA" {{ ($service->country == 'UA') ? 'selected':'' }}>Ukraine</option>
										<option value="AE" {{ ($service->country == 'AE') ? 'selected':'' }}>United Arab Emirates</option>
										<option value="GB" {{ ($service->country == 'GB') ? 'selected':'' }}>United Kingdom</option>
										<option value="UM" {{ ($service->country == 'UM') ? 'selected':'' }}>United States Minor Outlying Islands</option>
										<option value="UY" {{ ($service->country == 'UY') ? 'selected':'' }}>Uruguay</option>
										<option value="UZ" {{ ($service->country == 'UZ') ? 'selected':'' }}>Uzbekistan</option>
										<option value="VU" {{ ($service->country == 'VU') ? 'selected':'' }}>Vanuatu</option>
										<option value="VE" {{ ($service->country == 'VE') ? 'selected':'' }}>Venezuela, Bolivarian Republic of</option>
										<option value="VN" {{ ($service->country == 'VN') ? 'selected':'' }}>Viet Nam</option>
										<option value="VG" {{ ($service->country == 'VG') ? 'selected':'' }}>Virgin Islands, British</option>
										<option value="VI" {{ ($service->country == 'VI') ? 'selected':'' }}>Virgin Islands, U.S.</option>
										<option value="WF" {{ ($service->country == 'WF') ? 'selected':'' }}>Wallis and Futuna</option>
										<option value="EH" {{ ($service->country == 'EH') ? 'selected':'' }}>Western Sahara</option>
										<option value="YE" {{ ($service->country == 'YE') ? 'selected':'' }}>Yemen</option>
										<option value="ZM" {{ ($service->country == 'ZM') ? 'selected':'' }}>Zambia</option>
										<option value="ZW" {{ ($service->country == 'ZW') ? 'selected':'' }}>Zimbabwe</option>
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
										data-size="small" name="type" {{ ($service->type == 1) ? 'checked':'' }}>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Service Days:</label>
								<div class="col-sm-10">
									<div class="btn-group btn-group-sm" data-toggle="buttons">
										<label class="btn {{ ($service->service_days_by_day()['monday']) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off"
													name="service_days_monday" {{ ($service->service_days_by_day()['monday']) ? 'checked':'' }}>Monday
										</label>
										<label class="btn {{ ($service->service_days_by_day()['tuesday']) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off"
													name="service_days_tuesday" {{ ($service->service_days_by_day()['tuesday']) ? 'checked':'' }}>Tuesday
										</label>
										<label class="btn {{ ($service->service_days_by_day()['wednesday']) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off" 
													name="service_days_wednesday" {{ ($service->service_days_by_day()['wednesday']) ? 'checked':'' }}>Wednesday
										</label>
										<label class="btn {{ ($service->service_days_by_day()['thursday']) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off" 
													name="service_days_thursday" {{ ($service->service_days_by_day()['thursday']) ? 'checked':'' }}>Thursday
										</label>
										<label class="btn {{ ($service->service_days_by_day()['friday']) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off" 
													name="service_days_friday" {{ ($service->service_days_by_day()['friday']) ? 'checked':'' }}>Friday
										</label>
										<label class="btn {{ ($service->service_days_by_day()['saturday']) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off" 
													name="service_days_saturday" {{ ($service->service_days_by_day()['saturday']) ? 'checked':'' }}>Saturday
										</label>
										<label class="btn {{ ($service->service_days_by_day()['sunday']) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off" 
													name="service_days_sunday" {{ ($service->service_days_by_day()['sunday']) ? 'checked':'' }}>Sunday
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
														name="start_time" value="{{ substr($service->start_time, 0, 5) }}">
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-time"></span>
												</span>
											</div>
										<div class="input-group-addon">To:</div>
										<div class="input-group clockpicker" data-autoclose="true">
											<input type="text" class="form-control"
													name="end_time" value="{{ substr($service->end_time, 0, 5) }}">
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
										 		value="{{ $service->amount }}">
										 <div class="input-group-addon">
										 	<select name='currency' data-live-search="true">
										 		<option value="USD" {{ ($service->currency == 'USD') ? 'selected':'' }}>USD</option>
										 		<option value="MXN" {{ ($service->currency == 'MXN') ? 'selected':'' }}>MXN</option>
										 		<option value="CAD" {{ ($service->currency == 'CAD') ? 'selected':'' }}>CAD</option>
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
										data-size="small" name="status" {{ ($service->status) ? 'checked':'' }}>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Service Photo</label>
								<div class="col-sm-10">
					                <div class="fileupload fileupload-new" data-provides="fileupload">
					                  <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
					                  <img src="{{ url($service->thumbnail()) }}" alt="Placeholder" /></div>
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
												name="comments">{{ $service->comments }}</textarea>
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
								<i class="font-icon font-icon-ok"></i>&nbsp;&nbsp;&nbsp;Edit Service</button>
							</p>
							<br>
							<br>
						</form>
					</div>
			</section>
		</div>
	</div>
@endsection