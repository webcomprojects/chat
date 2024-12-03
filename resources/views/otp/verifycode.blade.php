<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تایید شماره موبایل</title>
    <link rel="stylesheet" href="{{ asset('admin') }}/css/font.css">

    <style>
        body {
            font-family: IRANSans, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #121212;
            color: #e0e0e0;
        }

        button {
            font-family: IRANSans, sans-serif;
        }

        .container {
            background-color: #1e1e1e;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h1 {
            margin-bottom: 1rem;
            color: #ffffff;
        }

        .otp-input {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .otp-input input {
            width: 16px;
            height: 20px;
            margin: 0 2px;
            text-align: center;
            font-size: .8rem;
            border: 1px solid #444;
            border-radius: 4px;
            background-color: #2a2a2a;
            color: #ffffff;
        }

        .otp-input input::-webkit-outer-spin-button,
        .otp-input input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .otp-input input[type=number] {
            -moz-appearance: textfield;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 4px 10px;
            font-size: .7rem;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
        }

        h2 {
            font-size: 1rem;
        }

        button:hover {
            background-color: #45a049;
        }

        button:disabled {
            background-color: #cccccc;
            color: #666666;
            cursor: not-allowed;
        }

        #timer {
            font-size: .8rem;
            margin-bottom: 1rem;
            color: #ff9800;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>تایید شماره موبایل</h2>
        <div id="timer">تا ۲:۰۰ دقیقه دیگر کد ارسال می شود</div>
        <div class="otp-input">
            <input type="number" min="0" max="9" required>
            <input type="number" min="0" max="9" required>
            <input type="number" min="0" max="9" required>
            <input type="number" min="0" max="9" required>
            <input type="number" min="0" max="9" required>
            <input type="number" min="0" max="9" required>
        </div>
        <button onclick="verifyOTP()">تایید</button>
        <button id="resendButton" onclick="resendOTP()" disabled>ارسال مجدد</button>
        <div dir="rtl" id="response"
            style="display: none;background: rgb(221 54 54); margin-top: 10px; font-size: 12px; padding: 2px 0; border-radius: 2px;">
        </div>
    </div>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

    <script>
        const inputs = document.querySelectorAll('.otp-input input');
        const timerDisplay = document.getElementById('timer');
        const resendButton = document.getElementById('resendButton');
        let timeLeft = 120;
        let timerId;

        function startTimer() {
            timerId = setInterval(() => {
                if (timeLeft <= 0) {
                    clearInterval(timerId);
                    timerDisplay.textContent = "روی ارسال مجدد کلیک کنید";
                    resendButton.disabled = false;
                    inputs.forEach(input => input.disabled = true);
                } else {
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    timerDisplay.textContent =
                        `تا ${minutes}:${seconds.toString().padStart(2, '0')} دقیقه دیگر کد ارسال می شود`;
                    timeLeft--;
                }
            }, 1000);
        }

        function resendOTP() {
            $('#response').text('').hide();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: "post",
                url: '{{ route('resendCode') }}',
                dataType: "json",
                success: function(response) {
                    if (response.status == 'ok') {
                        timeLeft = 60;
                        inputs.forEach(input => {
                            input.value = '';
                            input.disabled = false;
                        });
                        resendButton.disabled = true;
                        inputs[0].focus();
                        clearInterval(timerId);
                        startTimer();
                    }
                },
                error: function(data) {
                    if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function(key, value) {
                            $('#response').show().append(value);
                        });
                    }
                    if (data.status === 404) {
                        window.location.replace('/otp/login');
                    }
                }
            });

        }

        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length > 1) {
                    e.target.value = e.target.value.slice(0, 1);
                }
                if (e.target.value.length === 1) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value) {
                    if (index > 0) {
                        inputs[index - 1].focus();
                    }
                }
                if (e.key === 'e') {
                    e.preventDefault();
                }
            });
        });

        function verifyOTP() {
            $('#response').text();
            const otp = Array.from(inputs).map(input => input.value).join('');
            if (otp.length === 6) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    type: "post",
                    url: '{{ route('verify') }}',
                    data: {
                        code: otp
                    },
                    dataType: "json",
                    success: function(response) {
                        window.location.replace('/dashboard');
                    },
                    error: function(data) {
                        if (data.status === 422) {
                            var errors = $.parseJSON(data.responseText);
                            $.each(errors, function(key, value) {
                                $('#response').show().append(value);
                            });
                        } else if (data.status === 404) {
                            window.location.replace('/otp/login');
                        }
                    }
                });
            } else {
                alert('Please enter a 6-digit OTP');
            }
        }

        startTimer();
    </script>
</body>

</html>
