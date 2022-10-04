<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="content-language" content="en-us">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Store - Reset Password
    </title>
  </head>
  <body bgcolor="#ffffff" style="background:#fff; margin:0; font-family:-apple-system, BlinkMacSystemFont,'Segoe UI', 'Roboto', 'Oxygen','Ubuntu', 'Cantarell', 'Fira Sans','Droid Sans', 'Helvetica Neue', sans-serif;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="background-color: #fff;border-collapse:collapse;margin:0;padding:0;">
      <tbody>
        <tr>
          <td align="center" valign="top" style="padding: 0 20px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:600px; width: 100%;">
              <tbody>
                <tr>
                  <td>
                    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; width: 100%;">
                      <tbody>
                        <tr>
                          <td align="center" style="padding: 43px 30px 30px">
                            <a align="center" href="#" target="_blank" style="float: left;">
                              <img style="display: inline-block; text-align: center; height: 50px;" src="{{asset('images/logo-auth.png')}}" alt="Store" />
                            </a>
                            <span style="font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; color: #333333; letter-spacing: 2px; font-size: 12px; text-transform: uppercase; padding: 18px 0 0; float: right">Reset Password</span>
                          </td>
                        </tr>
                        <tr>
                          <td style="background: #ffffff;">
                            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%;">
                              <tbody>
                                <tr>
                                  <td style="padding: 0px 30px 0;">
                                    <p style="margin: 0; padding: 0px; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; color: #333333; font-size: 28px; line-height: 38px;">
                                      <strong>You have requested to</strong><br><span><strong>Reset</strong> Your Password</span>
                                    </p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="padding: 30px 30px 0;">
                                    <p style="margin: 0; padding: 0 0 20px; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; color: #333333; font-size: 16px; line-height: 26px;">
                                      We cannot simply send you your old password. A unique link to reset your password has been generated for you. To reset your password, click the following <strong>&quot; Reset Password &rarr; &quot;</strong> button and follow the instructions.
                                    </p>
                                    <p style="margin: 0; padding: 0; text-align: left;">
                                      <a href="{{ route('customerresetpasswordform', $token) }}" target="_blank" style="display: inline-block; padding: 14px 15px; background-color: #7367F0; color: #ffffff; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; font-size: 18px; letter-spacing: -0.3px; text-decoration: none; border-radius: 4px;">
                                        Reset Password &rarr;
                                      </a>
                                    </p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="padding: 40px 30px 0;">
                                    <p style="margin: 0; padding: 0 0 10px; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; color: #333333; font-size: 26px;">
                                      <strong>Use this link to reset your password:</strong>
                                    </p><br>

                                    <a href="{{ route('customerresetpasswordform', $token) }}" style="color: #1155cc; text-decoration: none;">{{ route('customerresetpasswordform', $token) }}</a><br><br>

                                    <p style="margin: 0; padding: 0 0 10px; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; color: #333333; font-size: 16px; line-height: 26px;">
                                      <strong>Note: </strong> This link is valid for 1 hour from the time it was sent to you and can be used to change your password only once.
                                    </p><br>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>

                        <tr>
                          <td style="padding: 40px 20px 20px; background: #081124;">
                            <p style="margin: 0; padding: 0px; text-align: center; font-size: 14px; line-height: 24px; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; color: #ffffff;">
                              Sent with ♥ from your friends at Store
                            </p>
                          </td>
                        </tr>

                        <tr>
                          <td style="padding: 0 40px 40px; background: #081124;">
                            <p style="margin: 0; padding: 0px; text-align: left; font-size: 14px; line-height: 24px; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; color: #ffffff;">
                              Cheers,
                              <br>The Store Team
                            </p>

                            <p style="margin: 0; padding: 0px; text-align: right; font-size: 14px; line-height: 24px; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; color: #ffffff;">
                              Thank You
                            </p>
                          </td>
                        </tr>

                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>

    </body>
</html>
