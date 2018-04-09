<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password</title>

    <style type="text/css">
    	.panel-heading {
		    align-items: center;
			text-align: center;
			margin: auto;
    	}

    	.panel-body {
    		margin: auto;
    		text-align: center;
    		display: table !important;
    	}

    	.panel-body p {
    		font-size: 18px;
    	}

    	.panel-footer {
    		text-align: center;
    		padding: 50px 25px;
    	}
    </style>

</head>
<body>
    <section>
        <div class="panel-heading">
        	<h3><strong>OOHYAH</strong></h3>
        </div>
        <div class="panel-body">

            <table>
            	<td><p>If you`ve lost your password or wish to reset it, use the link below to get started.</p></td>
			    <tr>
			        <td style="background-color: #2942d1;border: 2px solid #2942d1;padding: 10px;text-align: center;">
			            <a style="display: block;color: #ffffff;font-size: 12px;text-decoration: none;text-transform: uppercase;" href="{{ $url }}">
			                Reset Password
			            </a>
			        </td>
			    </tr>
			</table>
        </div>
        <div class="panel-footer">
        	© 2018 <a href="http://oohyah.com">Oohyah</a> All right reserved.
        </div>
    </section>
</body>
</html>
