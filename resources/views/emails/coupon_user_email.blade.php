<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
  	<meta name="description" content="Free Web tutorials">
  	<meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="author" content="John Doe">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Countdown Timer</title>
	<!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;600&display=swap');

		* {
			box-sizing: border-box;
		}

		body{
			background-image: url('./frontend/themes/images/snow.jpg');
			background-size: cover;
			background-position: center;
			display: flex;
			flex-direction: column;
			align-items: center;
			min-height: 100vh;
			font-family: "Poppins", sans-serif;
			margin: 0;
		}

		h1{
			font-weight: normal;
			font-size: 4rem;
			margin-top: 5rem;
		}

		.countdown-container{
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			justify-content: center;
		}

		.big-text{
			font-weight: bold;
			font-size: 6rem;
			line-height: 1;
			margin: 1rem 2rem;
		}

		.countdown-e1{
			text-align: center;
		}

		.countdown-e1 span{
			font-size: 1.3rem;
		}
	</style>
</head>
<body>
	<p><strong>Congratulations</strong>, Now you are a <strong>{{$coupon_type}}</strong> coupon use for shopping our Ecommerce site. Your Coupon Code is <strong>{{$coupon_code}}</strong> And Discount amount is <strong>{{$amount}} @if($amount_type == "Percentage")% @else TK @endif</strong> </p><br>


	<h1>Your coupon Expiry Date : {{date('d M Y', strtotime($expiry_date))}}</h1>
	<div class="countdown-container">
		<div class="countdown-e1 days-c">
			<p class="big-text days" id="days">0</p>
			<span>days</span>
		</div>
		<div class="countdown-e1 hours-c">
			<p class="big-text" id="hours">0</p>
			<span>hours</span>
		</div>
		<div class="countdown-e1 mins-c">
			<p class="big-text" id="mins">0</p>
			<span>mins</span>
		</div>
		<div class="countdown-e1 seconds-c">
			<p class="big-text" id="seconds">0</p>
			<span>seconds</span>
		</div>
	</div>

</body>
<!-- <script type="text/javascript" src="script.js"></script> -->
<script type="text/javascript">
	
	const daysE1 = document.querySelector('#days');
	const hoursE1 = document.querySelector('#hours');
	const minsE1 = document.querySelector('#mins');
	const secondsE1 = document.querySelector('#seconds');

	// const newYears = date('d M Y', strtotime($expiry_date));
	const newYears = '1 apr 2022';

	function countdown()
	{
		const newYearsDate = new Date(newYears);
		const currentDate = new Date();

		const totalSeconds = (newYearsDate - currentDate) / 1000;
		const days = Math.floor(totalSeconds / 3600 / 24);
		const hours = Math.floor(totalSeconds / 3600) % 24;
		const mins = Math.floor(totalSeconds / 60) % 60;
		const seconds = Math.floor(totalSeconds) % 60;

		daysE1.innerHTML = formatTime(days);
		hoursE1.innerHTML = formatTime(hours);
		minsE1.innerHTML = formatTime(mins);
		secondsE1.innerHTML = formatTime(seconds);
	}

	function formatTime(time)
	{
		return time < 10 ? `0${time}` : time;
	}

	//initial call
	countdown();

	setInterval(countdown, 1000);
</script>
</html>