<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
	<style>
		body {
			font-family: Avenir, Helvetica, sans-serif;
			box-sizing: border-box;
			padding: 0px;
			margin: 0px;
			width: 100%;
			-premailer-cellpadding: 0; 
			-premailer-cellspacing: 0; 
			-premailer-width: 100%;
		}

		.grey {
			background-color: #f5f8fa
		}

		.logo-holder {
			padding: 25px 0;
			text-align: center;
		}

		.logo-text {
			color: #bbbfc3; 
			font-size: 19px; 
			font-weight: bold; 
			text-decoration: none; 
			text-shadow: 0 1px 0 white;
		}

		.body {
			background-color:white;
		}

		.footer {
			margin: 0 auto; 
			text-align: center; 
			width: 570px; 
			-premailer-width: 570px;
		}

		.copy-right-notice {
			line-height: 1.5em; 
			color: #AEAEAE; 
			font-size: 12px; 
			text-align: center;
		}

		.content-cell {
			padding: 35px;
		}

		h1 {
			color: #2F3133; 
			font-size: 19px;
			font-weight: bold; 
			margin-top: 0; 
			text-align: left
		}

		.message {
			color: #74787E; 
			font-size: 16px; 
			line-height: 1.5em;
			margin-top: 0;
			text-align: left;
		}

		.button {
			border-radius: 3px; 
			box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); 
			color: #FFF; 
			display: inline-block;
			text-decoration: none;
			-webkit-text-size-adjust: none; 
			background-color: #3097D1;
			border-top: 10px solid #3097D1;
			border-right: 18px solid #3097D1; 
			border-bottom: 10px solid #3097D1; 
			border-left: 18px solid #3097D1;
		}

		.center-margin {
			margin: 30px auto; 
			text-align: center
		}

        @media  only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media  only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>

    <table class="wrapper grey" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
		    			<td class="header logo-holder">
		        			<a href="{{ config('app.url') }}" class="logo-text">{{ config('app.name', 'Laravel') }}</a>
		    			</td>
		    		</tr>
		    	</table>
		    </td>
		</tr>
        <tr class="body">
            <td class="content-cell">
            	<h1>Hello!</h1>
				<p class="message">You are receiving this email because you need to confirm the creation of your acount.</p>
				<small>if you did not request a registration at lets-event you don not need to do anything with this email</small>
				<table class="action center-margin" align="center" width="100%" cellpadding="0" cellspacing="0">
			    	<tr>
			        	<td align="center">
			            	<table width="100%" border="0" cellpadding="0" cellspacing="0">
			                	<tr>
			                    	<td align="center">
			                        	<table border="0" cellpadding="0" cellspacing="0">
			                            	<tr>
			                                	<td>
			                                    	<a href="{{ route('completeRegister', [$token]) }}" class="button button-blue" target="_blank">Click here to complete your registration</a>
			                                	</td>
			                            	</tr>
			                        	</table>
			                    	</td>
			                	</tr>
			            	</table>
			        	</td>
			    	</tr>
				</table>
			</td>
		</tr>
		<tr>
		    <td>
		        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0">
		            <tr>
		                <td class="content-cell" align="center">
		                    <p>© {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
		                </td>
		            </tr>
		        </table>
		    </td>
		</tr>
	</table>
</body>
</html>