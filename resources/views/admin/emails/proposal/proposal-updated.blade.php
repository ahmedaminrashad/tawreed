<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $subject }}</title>
    @if(app()->getLocale() == 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @else
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    @endif
</head>
<body style="
      margin: 0;
      font-family: {{ app()->getLocale() == 'ar' ? "'Cairo', sans-serif" : "'Poppins', sans-serif" }};
      background: #ffffff;
      font-size: 14px;
      direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};
    ">
    <div style="
        max-width: 680px;
        margin: 0 auto;
        padding: 45px 30px 60px;
        background: #f4f7ff;
        background-image: url(https://archisketch-resources.s3.ap-northeast-2.amazonaws.com/vrstyler/1661497957196_595865/email-template-background-banner);
        background-repeat: no-repeat;
        background-size: 800px 452px;
        background-position: top center;
        font-size: 14px;
        color: #434343;
      ">
        <header>
            <table style="width: 100%; direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
                <tbody>
                    <tr style="height: 0;">
                        <td style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}; width: 50%;">
                            <img alt="" src="{{ asset('/assets/front/img/logo.png') }}" height="30px">
                        </td>
                        <td style="text-align: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}; width: 50%;">
                            <span style="font-size: 16px; line-height: 30px; color: #ffffff;">{{ $data['date'] }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </header>

        <main>
            <div style="
            margin: 0;
            margin-top: 70px;
            padding: 92px 30px 115px;
            background: #ffffff;
            border-radius: 30px;
            text-align: center;
            direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};
          ">
                <div style="width: 100%; max-width: 489px; margin: 0 auto;">
                    <h1 style="
                margin: 0;
                font-size: 24px;
                font-weight: 500;
                color: #1f1f1f;
              ">
                        {{ __('web.proposal_updated_email_title') }}
                    </h1>
                    <p style="
                margin: 0;
                margin-top: 17px;
                font-size: 16px;
                font-weight: 500;
              ">
                        {{ __('web.proposal_updated_email_greeting', ['name' => $data['proposal_owner_name']]) }}
                    </p>
                    <p style="
                margin: 0;
                margin-top: 17px;
                font-weight: 500;
                letter-spacing: 0.56px;
              ">
                        {{ __('web.proposal_updated_email_message') }} <strong>{{ $data['tender_subject'] }}</strong>
                    </p>
                    <p style="
                margin: 0;
                margin-top: 17px;
                font-weight: 500;
                letter-spacing: 0.56px;
              ">
                        {{ __('web.proposal_updated_email_updated_by') }} <strong>{{ $data['tender_owner_name'] }}</strong>
                    </p>
                    <div style="
                margin-top: 40px;
                padding: 20px;
                background: #f4f7ff;
                border-radius: 10px;
              ">
                        <a href="{{ $data['proposal_url'] }}" style="
                    display: inline-block;
                    padding: 12px 30px;
                    background: #499fb6;
                    color: #ffffff;
                    text-decoration: none;
                    border-radius: 5px;
                    font-weight: 500;
                  ">{{ __('web.proposal_updated_email_view_proposal') }}</a>
                    </div>
                </div>
            </div>

            <p style="
            max-width: 400px;
            margin: 0 auto;
            margin-top: 90px;
            text-align: center;
            font-weight: 500;
            color: #8c8c8c;
          ">
                {{ __('web.proposal_updated_email_need_help') }}
                <a href="mailto:{{ $data['administratorEmail'] }}" style="color: #499fb6; text-decoration: none;">{{ $data['administratorEmail'] }}</a>
                {{ __('web.proposal_updated_email_or_visit') }}
                <a href="{{ route('home') }}" target="_blank" style="color: #499fb6; text-decoration: none;">{{ __('web.proposal_updated_email_help_center') }}</a>
            </p>
        </main>

        <footer style="
          width: 100%;
          max-width: 490px;
          margin: 20px auto 0;
          text-align: center;
          border-top: 1px solid #e6ebf1;
        ">
            <p style="margin: 0; margin-top: 16px; color: #434343;">
                {{ __('web.proposal_updated_email_copyright') }}
            </p>
        </footer>
    </div>
</body>
</html>

