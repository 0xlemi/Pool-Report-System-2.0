<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
  <title>Pool Report System</title>
  <style type="text/css">
.ReadMsgBody { width: 100%; background-color: #ffffff; }
.ExternalClass { width: 100%; background-color: #ffffff; }
.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }
html { width: 100%; }
body { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; margin: 0; padding: 0; }
table { border-spacing: 0; border-collapse: collapse; table-layout: fixed; margin: 0 auto; }
table table table { table-layout: auto; }
img { display: block !important; }
table td { border-collapse: collapse; }
.yshortcuts a { border-bottom: none !important; }
a { color: #ff646a; text-decoration: none; }
.textbutton a { font-family: 'open sans', arial, sans-serif !important; color: #ffffff !important; }
.footer-link a { color: #7f8c8d !important; }
</style>
</head>

<body>
  <!-- header -->
  <table bgcolor="#f8f8f8" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr align="center" valign="top">
      <td>
        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="208" align="center" valign="top" bgcolor="#449EE4">
              <table width="158" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="50"></td>
                </tr>
                <!-- logo -->
                <tr>
                  <td align="center" style="line-height:0px;"><img style="display:block;font-size:0px; border:0px;height:45px;line-height:0px;" height="45px" src="{{ \Storage::url('images/assets/app/logo-2.png') }}" alt="logo" /></td>
                </tr>
                <!-- end logo -->
                <tr>
                  <td height="40"></td>
                </tr>
                <!-- company name -->
                <tr>
                  <td style="font-family: 'Open Sans', Arial, sans-serif; font-size:16px; color:#FFFFFF; line-height:26px; font-weight: bold;">{{ $company->name }}</td>
                </tr>
                <!-- end company name -->
                <tr>
                  <td height="5"></td>
                </tr>
                <!-- address -->
                <tr>
                  <td style="font-family: 'Open Sans', Arial, sans-serif; font-size:13px; color:#FFFFFF; line-height:26px;">
                    <br />{{ $company->website }}</td>
                </tr>
                <!-- end address -->
                <tr>
                  <td height="25"></td>
                </tr>
              </table>
            </td>
            <td width="392" align="center" valign="top">
              <table width="342" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="50"></td>
                </tr>
                <!-- title -->
                <tr>
                  <td align="right" style="font-family: 'Open Sans', Arial, sans-serif; font-size:38px; color:#3b3b3b; line-height:26px;">INVOICE</td>
                </tr>
                <!-- end title -->
                <tr>
                  <td height="25"></td>
                </tr>
                <tr>
                  <td align="right">
                    <table align="right" width="50" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td bgcolor="#ff646a" height="3" style="line-height:0px; font-size:0px;">&nbsp;</td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td height="15"></td>
                </tr>
                <!-- company name -->
                <tr>
                  <td align="right" style="font-family: 'Open Sans', Arial, sans-serif; font-size:16px; color:#3b3b3b; line-height:26px; font-weight: bold;">{{ $userRoleCompany->user->fullName }}</td>
                </tr>
                <!-- end company name -->
                <tr>
                  <td height="5"></td>
                </tr>
                <!-- address -->
                <tr>
                  <td align="right" style="font-family: 'Open Sans', Arial, sans-serif; font-size:13px; color:#7f8c8d; line-height:26px;"> {{ $service->address_line }}
                    <br /> {{ $service->city }} {{ $service->postal_code }} {{$service->state }} {{$service->country }}
                    <br /> Invoice number : <span style="color:#3b3b3b"> <strong>{{ $invoice->seq_id }}</strong> </span></td>
                </tr>
                <!-- end address -->
                <tr>
                  <td height="25"></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <!-- end header -->
  <!-- title -->
  <table width="100%" align="center" bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center">
        <table align="center" width="600" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" style="border-bottom:3px solid #bcbcbc;">
              <table align="center" width="550" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="50"></td>
                </tr>
                <!-- header -->
                <tr>
                  <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="263" align="left" valign="top" style="font-family: 'Open Sans', Arial, sans-serif; font-size:13px; color:#3b3b3b; line-height:26px; text-transform:uppercase;">description</td>
                        <td width="87" align="right" valign="top" style="font-family: 'Open Sans', Arial, sans-serif; font-size:13px; color:#3b3b3b; line-height:26px; text-transform:uppercase;">PRICE</td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <!-- end header -->
                <tr>
                  <td height="10"></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <!-- end title -->
  <!-- list -->
  <table align="center" width="100%" bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center">
        <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" style="border-bottom:1px solid #ecf0f1;">
              <table width="550" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="35"></td>
                </tr>
                <tr>
                  <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="263" align="left" valign="top" style="font-family: 'Open Sans', Arial, sans-serif; font-size:14px; color:#3b3b3b; line-height:26px;  font-weight: bold;">{{ $title }}</td>
                        <td width="87" align="right" valign="top" style="font-family: 'Open Sans', Arial, sans-serif; font-size:14px; color:#3b3b3b; line-height:26px;  font-weight: bold;">${{$invoice->amount}}</td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td height="5"></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="5"></td>
          </tr>
          <tr>
            <td align="center">
              <table width="550" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="font-family: 'Open Sans', Arial, sans-serif; font-size:12px; color:#7f8c8d; line-height:26px;">{{$invoice->description}}</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <!-- end list -->
  <!-- total -->
  <table align="center" width="100%" bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center">
        <table align="center" width="600" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" height="40" style="border-bottom:3px solid #3b3b3b;"></td>
          </tr>
          <tr>
            <td height="15"></td>
          </tr>
          <tr>
            <td align="center">
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="416" align="center" valign="top" bgcolor="#f8f8f8">
                    <table width="366" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td height="10"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" style="font-family: 'Open Sans', Arial, sans-serif; font-size:12px; color:#3b3b3b; line-height:26px; text-transform:uppercase;line-height:24px;"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" style="font-family: 'Open Sans', Arial, sans-serif; font-size:24px; color:#3b3b3b;  font-weight: bold;"></td>
                      </tr>
                      <tr>
                        <td height="15"></td>
                      </tr>
                    </table>
                  </td>
                  <td width="184" align="center" valign="top" bgcolor="#e1e6e7">
                    <table width="134" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td height="10"></td>
                      </tr>
                      <tr>
                        <td align="right" valign="top" style="font-family: 'Open Sans', Arial, sans-serif; font-size:12px; color:#3b3b3b; line-height:26px; text-transform:uppercase;line-height:24px;">Total</td>
                      </tr>
                      <tr>
                        <td align="right" valign="top" style="font-family: 'Open Sans', Arial, sans-serif; font-size:24px; color:#3b3b3b;  font-weight: bold;">${{$invoice->amount.' '.$invoice->currency}}</td>
                      </tr>
                      <tr>
                        <td height="15"></td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="15"></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <!-- end total -->
  <!-- note -->
  <table align="center" width="100%" bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center">
        <table align="center" width="600" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="40"></td>
          </tr>
            <!-- button -->
            <tr>
              <td align="center">
                <table class="textbutton" align="center" bgcolor="#449EE4" border="0" cellspacing="0" cellpadding="0" style=" border-radius:30px; box-shadow: 0px 1px 0px #D4D2D2;">
                  <tr>
                    <td class="btn-link" height="50" align="center" style="font-family: 'Open Sans', Arial, sans-serif; font-size:16px; color:#FFFFFF; font-weight: bold;padding-left: 25px;padding-right: 25px;">
                      <a href="{{ $magicLink }}">GO AND TAKE A LOOK</a>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <!-- end button -->
          <tr>
            <td height="40"></td>
          </tr>
          <tr>
            <td height="15" style="border-bottom:3px solid #bcbcbc;"></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <!-- end note -->
  <!-- footer -->
  <table align="center" width="100%" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" valign="top" style="border-bottom:10px solid #ecf0f1;">
        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="25"></td>
          </tr>
          <tr>
            <td align="center" valign="top">
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="11" align="center" style="line-height:0px;"><img style="display:block;font-size:0px; border:0px; line-height:0px;" src="{{ \Storage::url('images/assets/email/envelope_icon.png') }}" alt="img" /></td>
                  <td class="footer-link" align="left" style="font-family: 'Open Sans', Arial, sans-serif; font-size:13px; color:#3b3b3b; line-height:26px;padding-left: 15px;padding-right: 15px;">support@poolreportsystem.com</td>
                  <td class="footer-link" align="right" style="font-family: 'Open Sans', Arial, sans-serif; font-size:13px; color:#3b3b3b; line-height:26px;"><a href="{{ $unsubscribeLink }}">UNSUBSCRIBE</a></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="25"></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <!-- end footer -->
</body>

</html>
