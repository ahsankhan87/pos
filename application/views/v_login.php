<html lang="en" class="no-js"><!--<![endif]--><!-- BEGIN HEAD --><head>
<meta charset="utf-8">
<title>Login | Kasbook Accounting Software</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta content="Kasbook Accounting Software to run your business, Point of Sale, Accounts Management Systems" name="description">
<meta content="Ahsan khan" name="author">
<meta name="MobileOptimized" content="320">
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.css">
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo base_url(); ?>assets/css/style-conquer.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/style-responsive.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/plugins.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color">
<link href="<?php echo base_url(); ?>assets/css/pages/login.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet" type="text/css">
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.ico">
</head>
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo animated bounceIn">
	<a href="<?php echo base_url(); ?>">
	<img src="<?php echo base_url(); ?>assets/img/logo.png" alt="">
	</a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content animated bounceIn">
	<!-- BEGIN LOGIN FORM -->
	<form class="login-form" action="<?php echo site_url('C_login/verify'); ?>" method="post" novalidate="novalidate">
		<?php
            if($this->session->flashdata('message'))
            {
                echo "<div class='alert alert-success fade in'>";
                echo '<span>'.$this->session->flashdata('message').'</span>';
                echo '</div>';
            }
            if($this->session->flashdata('error'))
            {
                echo "<div class='alert alert-danger fade in'>";
                echo '<span>'. $this->session->flashdata('error').'</span>';
                echo "</div>";
            }
            
            
        ?>
        <div id="success-msg" class="alert alert-success display-hide">
			<button class="close" data-close="alert"></button>
			<?php echo 'Account Created successfully'; ?>
		</div>
        <h3 class="form-title">Login to your account</h3>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>Enter username and password. </span>
		</div>
       
       <!-- <div class="form-group">
			ie8, ie9 does not support html5 placeholder, so we just show field title for that
			<label class="control-label visible-ie8 visible-ie9">Role</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<select class="form-control" name="role">
                    <option value="admin">&nbsp;&nbsp;&nbsp;&nbsp;Administrator</option>
                    <option value="emp">&nbsp;&nbsp;&nbsp;&nbsp;Employee</option>
                </select>
			</div>
		</div>-->
        <div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Username</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" autofocus="" autocomplete="off" placeholder="Username" name="username">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Password</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password">
			</div>
		</div>
		<div class="form-actions">
			<label class="checkbox">
			<!-- <div class="checker"><span><input type="checkbox" name="remember" value="1"></span></div> Remember me </label> -->
			<button type="submit" class="btn btn-info pull-right">
			Login </button>
		</div>
        
		<!-- <div class="forget-password">
			<h4>Forgot your password ?</h4>
			<p>
				 no worries, click <a href="javascript:;" id="forget-password">here</a>
				to reset your password.
			</p>
		</div> -->
		<div class="create-account">
			<p>
				 Don't have an account yet ?&nbsp; <a href="javascript:;" id="register-btn">Create an account</a>
			</p>
		</div>
        
	</form>
	<!-- END LOGIN FORM -->
	<!-- BEGIN FORGOT PASSWORD FORM -->
	<form class="forget-form" action="index.html" method="post" novalidate="novalidate">
		<h3>Forget Password ?</h3>
		<p>
			 Enter your e-mail address below to reset your password.
		</p>
		<div class="form-group">
			<div class="input-icon">
				<i class="fa fa-envelope"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email">
			</div>
		</div>
		<div class="form-actions">
			<button type="button" id="back-btn" class="btn btn-default">
			<i class="m-icon-swapleft"></i> Back </button>
			<button type="submit" class="btn btn-info pull-right">
			Submit </button>
		</div>
	</form>
	<!-- END FORGOT PASSWORD FORM -->
	<!-- BEGIN REGISTRATION FORM -->
	<form class="register-form" action="" method="post" novalidate="novalidate">
                   
		<h3>Create New Account</h3>
		<p>
			 Enter your personal details below:
		</p>
        
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Company Name</label>
			<div class="input-icon">
				<i class="fa fa-font"></i>
                <input type="hidden" id="url" value="<?php echo site_url('en/companies/C_newStore/create') ?>" />
     
				<input class="form-control placeholder-no-fix" type="text" placeholder="Company Name" name="name">
			</div>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Email</label>
			<div class="input-icon">
				<i class="fa fa-envelope"></i>
				<input class="form-control placeholder-no-fix" type="text" placeholder="Email" name="email">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Address</label>
			<div class="input-icon">
				<i class="fa fa-check"></i>
				<input class="form-control placeholder-no-fix" type="text" placeholder="Address" name="address">
			</div>
		</div>
		<div class="form-group">
          <label class="control-label visible-ie8 visible-ie9">Time Zone:</label>
                <select class="form-control" name="time_zone"> 
                    <option value="">Select Timezone</option>
                    <option value="Pacific/Midway">Midway [SST -11:00]</option> 
                    <option value="Pacific/Niue">Niue [NUT -11:00]</option> 
                    <option value="Pacific/Apia">Apia [WST -11:00]</option> 
                    <option value="Pacific/Tahiti">Tahiti [TAHT -10:00]</option> 
                    <option value="Pacific/Honolulu">Honolulu [HST -10:00]</option> 
                    <option value="Pacific/Rarotonga">Rarotonga [CKT -10:00]</option> 
                    <option value="Pacific/Fakaofo">Fakaofo [TKT -10:00]</option> 
                    <option value="Pacific/Marquesas">Marquesas [MART -09:30]</option> 
                    <option value="America/Adak">Adak [HADT -09:00]</option> 
                    <option value="Pacific/Gambier">Gambier [GAMT -09:00]</option> 
                    <option value="America/Anchorage">Anchorage [AKDT -08:00]</option> 
                    <option value="Pacific/Pitcairn">Pitcairn [PST -08:00]</option> 
                    <option value="America/Dawson_Creek">Dawson Creek [MST -07:00]</option> 
                    <option value="America/Dawson">Dawson [PDT -07:00]</option> 
                    <option value="America/Belize">Belize [CST -06:00]</option> 
                    <option value="America/Boise">Boise [MDT -06:00]</option> 
                    <option value="Pacific/Easter">Easter [EAST -06:00]</option> 
                    <option value="Pacific/Galapagos">Galapagos [GALT -06:00]</option> 
                    <option value="America/Resolute">Resolute [CDT -05:00]</option> 
                    <option value="America/Cancun">Cancun [CDT -05:00]</option> 
                    <option value="America/Guayaquil">Guayaquil [ECT -05:00]</option> 
                    <option value="America/Lima">Lima [PET -05:00]</option> 
                    <option value="America/Bogota">Bogota [COT -05:00]</option> 
                    <option value="America/Atikokan">Atikokan [EST -05:00]</option> 
                    <option value="America/Caracas">Caracas [VET -04:30]</option> 
                    <option value="America/Guyana">Guyana [GYT -04:00]</option> 
                    <option value="America/Campo_Grande">Campo Grande [AMT -04:00]</option> 
                    <option value="America/La_Paz">La Paz [BOT -04:00]</option> 
                    <option value="America/Anguilla">Anguilla [AST -04:00]</option> 
                    <option value="Atlantic/Stanley">Stanley [FKT -04:00]</option> 
                    <option value="America/Detroit">Detroit [EDT -04:00]</option> 
                    <option value="America/Boa_Vista">Boa Vista [AMT -04:00]</option> 
                    <option value="America/Santiago">Santiago [CLT -04:00]</option> 
                    <option value="America/Asuncion">Asuncion [PYT -04:00]</option> 
                    <option value="Antarctica/Rothera">Rothera [ROTT -03:00]</option> 
                    <option value="America/Paramaribo">Paramaribo [SRT -03:00]</option> 
                    <option value="America/Sao_Paulo">Sao Paulo [BRT -03:00]</option> 
                    <option value="America/Argentina/Buenos_Aires">Buenos Aires [ART -03:00]</option> 
                    <option value="America/Cayenne">Cayenne [GFT -03:00]</option> 
                    <option value="America/Glace_Bay">Glace Bay [ADT -03:00]</option> 
                    <option value="America/Argentina/San_Luis">San Luis [WARST -03:00]</option> 
                    <option value="America/Araguaina">Araguaina [BRT -03:00]</option> 
                    <option value="America/Montevideo">Montevideo [UYT -03:00]</option> 
                    <option value="America/St_Johns">St Johns [NDT -02:30]</option> 
                    <option value="America/Miquelon">Miquelon [PMDT -02:00]</option> 
                    <option value="America/Noronha">Noronha [FNT -02:00]</option> 
                    <option value="America/Godthab">Godthab [WGST -02:00]</option> 
                    <option value="Atlantic/Cape_Verde">Cape Verde [CVT -01:00]</option> 
                    <option value="Atlantic/Azores">Azores [AZOST  00:00]</option> 
                    <option value="America/Scoresbysund">Scoresbysund [EGST  00:00]</option> 
                    <option value="UTC">UTC [UTC  00:00]</option> 
                    <option value="Africa/Abidjan">Abidjan [GMT  00:00]</option> 
                    <option value="Africa/Casablanca">Casablanca [WET  00:00]</option> 
                    <option value="Africa/Bangui">Bangui [WAT +01:00]</option> 
                    <option value="Europe/Guernsey">Guernsey [BST +01:00]</option> 
                    <option value="Europe/Dublin">Dublin [IST +01:00]</option> 
                    <option value="Africa/Algiers">Algiers [CET +01:00]</option> 
                    <option value="Atlantic/Canary">Canary [WEST +01:00]</option> 
                    <option value="Africa/Windhoek">Windhoek [WAT +01:00]</option> 
                    <option value="Africa/Johannesburg">Johannesburg [SAST +02:00]</option> 
                    <option value="Africa/Blantyre">Blantyre [CAT +02:00]</option> 
                    <option value="Africa/Tripoli">Tripoli [EET +02:00]</option> 
                    <option value="Africa/Ceuta">Ceuta [CEST +02:00]</option> 
                    <option value="Asia/Jerusalem">Jerusalem [IDT +03:00]</option> 
                    <option value="Africa/Addis_Ababa">Addis Ababa [EAT +03:00]</option> 
                    <option value="Africa/Cairo">Cairo [EEST +03:00]</option> 
                    <option value="Antarctica/Syowa">Syowa [SYOT +03:00]</option> 
                    <option value="Europe/Volgograd">Volgograd [VOLST +04:00]</option> 
                    <option value="Europe/Samara">Samara [SAMST +04:00]</option> 
                    <option value="Asia/Tbilisi">Tbilisi [GET +04:00]</option> 
                    <option value="Europe/Moscow">Moscow [MSD +04:00]</option> 
                    <option value="Asia/Dubai">Dubai [GST +04:00]</option> 
                    <option value="Indian/Mauritius">Mauritius [MUT +04:00]</option> 
                    <option value="Indian/Reunion">Reunion [RET +04:00]</option> 
                    <option value="Indian/Mahe">Mahe [SCT +04:00]</option> 
                    <option value="Asia/Tehran">Tehran [IRDT +04:30]</option> 
                    <option value="Asia/Kabul">Kabul [AFT +04:30]</option> 
                    <option value="Asia/Aqtau">Aqtau [AQTT +05:00]</option> 
                    <option value="Asia/Ashgabat">Ashgabat [TMT +05:00]</option> 
                    <option value="Asia/Oral">Oral [ORAT +05:00]</option> 
                    <option value="Asia/Yerevan">Yerevan [AMST +05:00]</option> 
                    <option value="Asia/Baku">Baku [AZST +05:00]</option> 
                    <option value="Indian/Kerguelen">Kerguelen [TFT +05:00]</option> 
                    <option value="Indian/Maldives">Maldives [MVT +05:00]</option> 
                    <option value="Asia/Karachi">Karachi / Islamabad [PKT +05:00]</option> 
                    <option value="Asia/Dushanbe">Dushanbe [TJT +05:00]</option> 
                    <option value="Asia/Samarkand">Samarkand [UZT +05:00]</option> 
                    <option value="Antarctica/Mawson">Mawson [MAWT +05:00]</option> 
                    <option value="Asia/Colombo">Colombo [IST +05:30]</option> 
                    <option value="Asia/Kathmandu">Kathmandu [NPT +05:45]</option> 
                    <option value="Indian/Chagos">Chagos [IOT +06:00]</option> 
                    <option value="Asia/Bishkek">Bishkek [KGT +06:00]</option> 
                    <option value="Asia/Almaty">Almaty [ALMT +06:00]</option> 
                    <option value="Antarctica/Vostok">Vostok [VOST +06:00]</option> 
                    <option value="Asia/Yekaterinburg">Yekaterinburg [YEKST +06:00]</option> 
                    <option value="Asia/Dhaka">Dhaka [BDT +06:00]</option> 
                    <option value="Asia/Thimphu">Thimphu [BTT +06:00]</option> 
                    <option value="Asia/Qyzylorda">Qyzylorda [QYZT +06:00]</option> 
                    <option value="Indian/Cocos">Cocos [CCT +06:30]</option> 
                    <option value="Asia/Rangoon">Rangoon [MMT +06:30]</option> 
                    <option value="Asia/Jakarta">Jakarta [WIT +07:00]</option> 
                    <option value="Asia/Hovd">Hovd [HOVT +07:00]</option> 
                    <option value="Antarctica/Davis">Davis [DAVT +07:00]</option> 
                    <option value="Asia/Bangkok">Bangkok [ICT +07:00]</option> 
                    <option value="Indian/Christmas">Christmas [CXT +07:00]</option> 
                    <option value="Asia/Omsk">Omsk [OMSST +07:00]</option> 
                    <option value="Asia/Novokuznetsk">Novokuznetsk [NOVST +07:00]</option> 
                    <option value="Asia/Choibalsan">Choibalsan [CHOT +08:00]</option> 
                    <option value="Asia/Ulaanbaatar">Ulaanbaatar [ULAT +08:00]</option> 
                    <option value="Asia/Brunei">Brunei [BNT +08:00]</option> 
                    <option value="Antarctica/Casey">Casey [WST +08:00]</option> 
                    <option value="Asia/Singapore">Singapore [SGT +08:00]</option> 
                    <option value="Asia/Manila">Manila [PHT +08:00]</option> 
                    <option value="Asia/Hong_Kong">Hong Kong [HKT +08:00]</option> 
                    <option value="Asia/Krasnoyarsk">Krasnoyarsk [KRAST +08:00]</option> 
                    <option value="Asia/Makassar">Makassar [CIT +08:00]</option> 
                    <option value="Asia/Kuala_Lumpur">Kuala Lumpur [MYT +08:00]</option> 
                    <option value="Australia/Eucla">Eucla [CWST +08:45]</option> 
                    <option value="Pacific/Palau">Palau [PWT +09:00]</option> 
                    <option value="Asia/Tokyo">Tokyo [JST +09:00]</option> 
                    <option value="Asia/Dili">Dili [TLT +09:00]</option> 
                    <option value="Asia/Jayapura">Jayapura [EIT +09:00]</option> 
                    <option value="Asia/Pyongyang">Pyongyang [KST +09:00]</option> 
                    <option value="Asia/Irkutsk">Irkutsk [IRKST +09:00]</option> 
                    <option value="Australia/Adelaide">Adelaide [CST +09:30]</option> 
                    <option value="Asia/Yakutsk">Yakutsk [YAKST +10:00]</option> 
                    <option value="Australia/Currie">Currie [EST +10:00]</option> 
                    <option value="Pacific/Port_Moresby">Port Moresby [PGT +10:00]</option> 
                    <option value="Pacific/Guam">Guam [ChST +10:00]</option> 
                    <option value="Pacific/Truk">Truk [TRUT +10:00]</option> 
                    <option value="Antarctica/DumontDUrville">DumontDUrville [DDUT +10:00]</option> 
                    <option value="Australia/Lord_Howe">Lord Howe [LHST +10:30]</option> 
                    <option value="Pacific/Ponape">Ponape [PONT +11:00]</option> 
                    <option value="Pacific/Kosrae">Kosrae [KOST +11:00]</option> 
                    <option value="Antarctica/Macquarie">Macquarie [MIST +11:00]</option> 
                    <option value="Pacific/Noumea">Noumea [NCT +11:00]</option> 
                    <option value="Pacific/Efate">Efate [VUT +11:00]</option> 
                    <option value="Pacific/Guadalcanal">Guadalcanal [SBT +11:00]</option> 
                    <option value="Asia/Sakhalin">Sakhalin [SAKST +11:00]</option> 
                    <option value="Asia/Vladivostok">Vladivostok [VLAST +11:00]</option> 
                    <option value="Pacific/Norfolk">Norfolk [NFT +11:30]</option> 
                    <option value="Asia/Kamchatka">Kamchatka [PETST +12:00]</option> 
                    <option value="Pacific/Tarawa">Tarawa [GILT +12:00]</option> 
                    <option value="Asia/Magadan">Magadan [MAGST +12:00]</option> 
                    <option value="Pacific/Wallis">Wallis [WFT +12:00]</option> 
                    <option value="Pacific/Kwajalein">Kwajalein [MHT +12:00]</option> 
                    <option value="Pacific/Funafuti">Funafuti [TVT +12:00]</option> 
                    <option value="Pacific/Nauru">Nauru [NRT +12:00]</option> 
                    <option value="Asia/Anadyr">Anadyr [ANAST +12:00]</option> 
                    <option value="Antarctica/McMurdo">McMurdo [NZST +12:00]</option> 
                    <option value="Pacific/Wake">Wake [WAKT +12:00]</option> 
                    <option value="Pacific/Fiji">Fiji [FJT +12:00]</option> 
                    <option value="Pacific/Chatham">Chatham [CHAST +12:45]</option> 
                    <option value="Pacific/Enderbury">Enderbury [PHOT +13:00]</option> 
                    <option value="Pacific/Tongatapu">Tongatapu [TOT +13:00]</option> 
                    <option value="Pacific/Kiritimati">Kiritimati [LINT +14:00]</option> 
                </select>
        </div>
        		
        <div class="form-group">
          <label class="control-label visible-ie8 visible-ie9" >Currency:</label>
            <div class="input-icon">
            <!--<i class="fa fa-dollar"></i> -->
            <?php echo form_dropdown('currency_id',$currencyDropDown,'','class="form-control placeholder-no-fix"'); ?>
                
        </div>
        </div>
        
        <div class="form-group">
          <label class="control-label visible-ie8 visible-ie9">Multi Currency</label>
          <div class="input-icon">
               Multi Currency
               <input type="checkbox" name="is_multi_currency" value="1" class="form-control placeholder-no-fix"/>
    
          </div>
        </div>

        <div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Contact</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="number" autocomplete="off" placeholder="Contact No" name="contact_no">
			</div>
		</div>
        <div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Fiscal Start Date</label>
			<div class="input-icon">
				<i class="fa fa-date"></i>
				FY start<input class="form-control placeholder-no-fix" type="date" autocomplete="off" placeholder="Fiscal Start Date" name="fy_start_date">
			</div>
		</div>
        <div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Fiscal End Date</label>
			<div class="input-icon">
				<i class="fa fa-date"></i>
				FY end<input class="form-control placeholder-no-fix" type="date" autocomplete="off" placeholder="Fiscal End Date" name="fy_end_date">
			</div>
		</div>
        <div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Fiscal Year</label>
			<div class="input-icon">
				<i class="fa fa-date"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Fiscal Year" name="fy_year">
			</div>
		</div>
		<p>
			 Enter your account details below:
		</p>
        <!--<div class="form-group">
          <label class="control-label visible-ie8 visible-ie9">Role:</label>
                <select class="form-control" name="role">
                    <option value="admin">Admin</option>
                    <option value="">User</option>
                </select>
        </div>--->  
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Username</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" id="u_name" name="u_name" >
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Password</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
			<div class="controls">
				<div class="input-icon">
					<i class="fa fa-check"></i>
					<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="rpassword">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label>
			<div class=""><span><input type="checkbox" name="tnc"></span></div> I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
			</label>
			<div id="register_tnc_error">
			</div>
		</div>
        
		<div class="form-actions">
			<button id="register-back-btn" type="button" class="btn btn-default">
			<i class="m-icon-swapleft"></i> Back </button>
            <button type="submit" id="register-submit-btn" class="btn btn-info pull-right">
			Sign Up <i class="m-icon-swapright m-icon-white"></i> 
            </button>
            <img src="<?php echo base_url('images/wait.gif')?>" width="20" height="20" class="loading  pull-right" />
			
		</div>
	</form>
	<!-- END REGISTRATION FORM -->
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
	 <?php echo date("Y"); ?> &copy; kasbook.com
</div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<script async="" src="//www.google-analytics.com/analytics.js"></script><script src="<?php echo base_url(); ?>assets/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!-- END JAVASCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<!-- <script src="<?php echo base_url(); ?>assets/scripts/login.js" type="text/javascript"></script> -->

 
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() { 
  
  var site_url = '<?php echo site_url(); ?>';
  var base_url = '<?php echo base_url(); ?>';
    
console.log(site_url);

  App.init();
//   Login();
            handleLogin();
            handleForgetPassword();
            handleRegister(); 
  var action = location.hash.substr(1);
          if (action == 'createaccount') {
              $('.register-form').show();
              $('.login-form').hide();
              $('.forget-form').hide();
          } else if (action == 'forgetpassword')  {
              $('.register-form').hide();
              $('.login-form').hide();
              $('.forget-form').show();
          }

   
    function handleLogin() {
		$('.login-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            rules: {
	                username: {
	                    required: true
	                },
	                password: {
	                    required: true
	                },
	                remember: {
	                    required: false
	                }
	            },

	            messages: {
	                username: {
	                    required: "Username is required1."
	                },
	                password: {
	                    required: "Password is required2."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
	                $('.alert-danger', $('.login-form')).show();
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });

	        $('.login-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.login-form').validate().form()) {
	                    $('.login-form').submit();
	                }
	                return false;
	            }
	        });
	}

	function handleForgetPassword() {
		$('.forget-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                email: {
	                    required: true,
	                    email: true
	                }
	            },

	            messages: {
	                email: {
	                    required: "Email is required."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   

	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });

	        $('.forget-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.forget-form').validate().form()) {
	                    $('.forget-form').submit();
	                }
	                return false;
	            }
	        });

	        jQuery('#forget-password').click(function () {
	            jQuery('.login-form').hide();
	            jQuery('.forget-form').show();
	        });

	        jQuery('#back-btn').click(function () {
	            jQuery('.login-form').show();
	            jQuery('.forget-form').hide();
	        });

	}

	function handleRegister() {
        //console.log(site_url);
        
		function format(state) {
            if (!state.id) return state.text; // optgroup
            return "<img class='flag' src='assets/img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
        }


		$("#select2_sample4").select2({
		  	placeholder: '<i class="fa fa-map-marker"></i>&nbsp;Select a Country',
            allowClear: true,
            formatResult: format,
            formatSelection: format,
            escapeMarkup: function (m) {
                return m;
            }
        });


			$('#select2_sample4').change(function () {
                $('.register-form').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
		
		var url      = window.location.origin;
		$.validator.addMethod("checkUsername", 
            function(value, element) {
                var result = false;
                $.ajax({
                    type:"POST",
                    async: false,
                    url  : site_url+'/en/companies/C_newStore/checkUsername', // script to validate in server side
                    data : $("#u_name").serialize(),
                    success: function(data) {
                        //console.log(data);
                        result = (data == 'true' ? false : true);
                        
                        //console.log($("#u_name").serialize());
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
                // return true if username is exist in database
                //console.log(result);
                return result; 
            }, 
            "This username is already taken! Try another."
        );
    
        var success1 = $('.alert-success');
        $("#register-submit-btn").show();
        $(".loading").hide();
                    
         $('.register-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                
	                name: {
	                    required: true
	                },
	                email: {
	                    required: true,
	                    email: true
	                },
	                address: {
	                    required: true
	                },
	                time_zone: {
	                    required: true
	                },
	                currency_id: {
	                    required: true
	                },
                    
                    contact_no:{
                        required:true
                    },
                    fy_start_date:{
                        required:true
                    },
                    fy_end_date:{
                        required:true
                    },
                    fy_year:{
                        required:true
                    },
	                u_name: {
	                    required: true,
                        minlength: 3,
                        maxlength:12,
                        checkUsername:true
                        //remote: {  // value of 'username' field is sent by default
//                            type: 'POST',
//                            url: 'http://localhost/khybersoft/pos1/en/companies/C_companies/hasLoginUsername'
//                        }
	                },
                    role: {
	                    required: true
	                },
	                password: {
	                    required: true,
                        minlength: 3,
                        maxlength:12,
	                },
	                rpassword: {
	                   minlength: 3,
                        maxlength:12,
	                    equalTo: "#register_password"
	                },

	                tnc: {
	                    required: true
	                }
	            },

	            messages: { // custom messages for radio buttons and checkboxes
	                tnc: {
	                    required: "Please accept TNC first."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
                    $("#register-submit-btn").show();
                    $(".loading").hide();
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                if (element.attr("name") == "tnc") { // insert checkbox errors after the container                  
	                    error.insertAfter($('#register_tnc_error'));
	                } else if (element.closest('.input-icon').size() === 1) {
	                    error.insertAfter(element.closest('.input-icon'));
	                } else {
	                	error.insertAfter(element);
	                }
	            },

	            submitHandler: function (form) {
	               
                   $("#register-submit-btn").hide();
                   $(".loading").show();
	               
                    $.ajax({
            				type : 'POST',
            				url  : $('#url').val(),
            				data : $('.register-form').serialize(),
                            success : function(data)
            						  {
            						      console.log($('#url').val());
    						              $("#success-msg").show();
                                          $("#register-submit-btn").show();
                                          $(".loading").hide();  
                                          jQuery('.register-form').hide();
                                          jQuery('.login-form').show();
                                          
                                          console.log(data);
                                          //window.location.href = $('#url').val();
            					      },
                            error: function (request, status, error) {
                                        console.log(request);
                                        console.log(error);
                                    }
            				});
                    return false; // required to block normal submit since you used ajax
        
	            }
	        });

			$('.register-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.register-form').validate().form()) {
	                    $('.register-form').submit();
	                }
	                return false;
	            }
	        });

	        jQuery('#register-btn').click(function () {
	            jQuery('.login-form').hide();
	            jQuery('.register-form').show();
                //alert('You are not a premuim user. please contact the vendor');
	        });

	        jQuery('#register-back-btn').click(function () {
	            jQuery('.login-form').show();
	            jQuery('.register-form').hide();
	        });
	}
    
    


});
</script>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css">

<!-- END BODY -->
<span role="status" aria-live="polite" class="select2-hidden-accessible"></span></body></html>